<?php

namespace App\Listeners;

use App\Contracts\INotificationService;
use App\Events\BookingAccepted;
use App\Events\BookingCreated;

class SendBookingNotification
{
    public function __construct(private INotificationService $notificationService) {}

    public function handleBookingCreated(BookingCreated $event): void
    {
        $booking = $event->booking;
        $this->notificationService->send(
            $booking->babysitter_id,
            'booking_request',
            'New booking request for '.($booking->babysitter->name ?? 'you')
        );
    }

    public function handleBookingAccepted(BookingAccepted $event): void
    {
        $booking = $event->booking;
        $this->notificationService->send(
            $booking->parent_id,
            'booking_accepted',
            'Your booking has been accepted by '.($booking->babysitter->name ?? 'the babysitter')
        );
    }

    public function subscribe($events): void
    {
        $events->listen(BookingCreated::class, [self::class, 'handleBookingCreated']);
        $events->listen(BookingAccepted::class, [self::class, 'handleBookingAccepted']);
    }
}
