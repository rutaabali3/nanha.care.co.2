<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Contracts\IBookingService;
use App\Enums\BookingStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\System\UserReport;
use Illuminate\Http\Request;

class BookingsController
{
    public function __construct(
        protected IBookingService $service
    ) {}

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'upcoming');
        $bookings = $this->service->getByParent(auth()->id(), $tab);

        return view('dashboard.parent.bookings.index', compact('bookings', 'tab'));
    }

    public function reviewForm($id)
    {
        $booking = Booking::with('babysitter')->findOrFail($id);

        if ($booking->parent_id !== auth()->id()) {
            abort(403);
        }

        if ((string) $booking->status !== (string) BookingStatus::Completed) {
            return redirect()->route('parent.bookings.index')->with('error', 'You can only review completed bookings.');
        }

        $existingReview = BabysitterReview::where('booking_id', $id)
            ->where('parent_id', auth()->id())
            ->first();

        if ($existingReview) {
            return redirect()->route('parent.bookings.index')->with('error', 'You have already reviewed this booking.');
        }

        return view('dashboard.parent.bookings.review', compact('booking'));
    }

    public function storeReview(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->parent_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        BabysitterReview::create([
            'booking_id' => $id,
            'parent_id' => auth()->id(),
            'babysitter_id' => $booking->babysitter_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('parent.bookings.index')->with('success', 'Review submitted successfully.');
    }

    public function reportIssue(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->parent_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        UserReport::create([
            'reporter_id' => auth()->id(),
            'subject_id' => $booking->babysitter_id,
            'reason' => $validated['reason'],
            'detail' => "Reported from booking #{$id}",
            'status' => 'pending',
        ]);

        return redirect()->route('parent.bookings.index')->with('success', 'Issue reported. We will review it shortly.');
    }
}
