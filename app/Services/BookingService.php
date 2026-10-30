<?php

namespace App\Services;

use App\Contracts\IBookingService;
use App\Contracts\IEmailService;
use App\Contracts\INotificationService;
use App\Enums\BookingStatus;
use App\Enums\VerifiedStatus;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BookingService implements IBookingService
{
    public function __construct(
        private INotificationService $notification,
        private IEmailService $email,
    ) {}

    public function getByBabysitter(string $userId, ?string $status): LengthAwarePaginator
    {
        $query = Booking::with('parent', 'bookingChildren.child')
            ->where('babysitter_id', $userId);
        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderByDesc('created_at')->paginate(10);
    }

    public function getByParent(string $userId, ?string $status): LengthAwarePaginator
    {
        $query = Booking::with('parent', 'bookingChildren.child')
            ->where('parent_id', $userId);
        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderByDesc('created_at')->paginate(10);
    }

    public function create(array $data): Booking
    {
        $profile = BabysitterProfile::where('user_id', $data['babysitter_id'])
            ->where('verified_status', VerifiedStatus::Verified)
            ->first();

        if (! $profile) {
            throw new \InvalidArgumentException('Babysitter is not verified.');
        }

        return DB::transaction(function () use ($data) {
            $booking = Booking::create([
                'parent_id' => $data['parent_id'],
                'babysitter_id' => $data['babysitter_id'],
                'date' => $data['date'],
                'start_time' => $data['start_time'],
                'duration_hours' => $data['duration_hours'] ?? null,
                'location' => $data['location'] ?? null,
                'notes' => $data['notes'] ?? null,
                'total_fee' => $data['total_fee'] ?? null,
                'status' => BookingStatus::Pending,
            ]);

            foreach ($data['child_ids'] as $childId) {
                $booking->bookingChildren()->create(['child_id' => $childId]);
            }

            $this->notification->send(
                $data['babysitter_id'],
                'new_booking',
                'New booking request from '.($booking->parent->name ?? 'a parent'),
            );

            return $booking->load('parent', 'bookingChildren.child');
        });
    }

    public function accept(int $id, string $userId): void
    {
        $booking = Booking::findOrFail($id);
        if ($booking->babysitter_id !== $userId) {
            throw new AuthorizationException;
        }
        $booking->update(['status' => BookingStatus::Confirmed]);

        $this->notification->send(
            $booking->parent_id,
            'booking_accepted',
            'Your booking was accepted.',
        );
        $this->email->sendBookingConfirmation($id);
    }

    public function decline(int $id, string $userId, string $reason): void
    {
        $booking = Booking::findOrFail($id);
        if ($booking->babysitter_id !== $userId) {
            throw new AuthorizationException;
        }
        $booking->update([
            'status' => BookingStatus::Cancelled,
            'decline_reason' => $reason,
        ]);

        $this->notification->send(
            $booking->parent_id,
            'booking_declined',
            'Your booking was declined.',
        );
    }

    public function complete(int $id, string $userId): void
    {
        $booking = Booking::findOrFail($id);
        if ($booking->babysitter_id !== $userId) {
            throw new AuthorizationException;
        }
        $booking->update(['status' => BookingStatus::Completed]);

        $this->notification->send(
            $booking->parent_id,
            'booking_completed',
            'Session completed. Leave a review!',
        );
    }
}
