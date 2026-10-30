<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Contracts\IBookingService;
use Illuminate\Http\Request;

class BookingsController
{
    public function __construct(
        protected IBookingService $service
    ) {}

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');
        $bookings = $this->service->getByBabysitter(auth()->id(), $tab);

        return view('dashboard.babysitter.bookings.index', compact('bookings', 'tab'));
    }

    public function accept($id)
    {
        $this->service->accept($id, auth()->id());

        return redirect()->back()->with('success', 'Booking accepted successfully.');
    }

    public function decline(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        $this->service->decline($id, auth()->id(), $request->reason);

        return redirect()->back()->with('success', 'Booking declined.');
    }

    public function complete($id)
    {
        $this->service->complete($id, auth()->id());

        return redirect()->back()->with('success', 'Booking completed.');
    }
}
