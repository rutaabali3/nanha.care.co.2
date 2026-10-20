<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Contracts\IPaymentService;
use App\Models\Babysitting\Booking;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningsController
{
    public function __construct(
        protected IPaymentService $service
    ) {}

    public function index()
    {
        $userId = auth()->id();
        $earnings = Booking::where('babysitter_id', $userId)
            ->where('status', BookingStatus::Completed)
            ->orderByDesc('date')
            ->get();
        $payoutHistory = $this->service->getPayoutHistory($userId);
        return view('dashboard.babysitter.earnings.index', compact('earnings', 'payoutHistory'));
    }

    public function chartData()
    {
        $userId = auth()->id();
        $startDate = now()->subMonths(11)->startOfMonth();

        // Optimization: Execute a single aggregate SQL query grouped by year and month
        // instead of running 12 separate database queries in a loop.
        $driver = DB::connection()->getDriverName();
        $monthKeySql = $driver === 'sqlite'
            ? "strftime('%Y-%m', date) as month_key"
            : "DATE_FORMAT(date, '%Y-%m') as month_key";

        $monthlyTotals = Booking::where('babysitter_id', $userId)
            ->where('status', BookingStatus::Completed)
            ->where('date', '>=', $startDate->toDateString())
            ->selectRaw("{$monthKeySql}, SUM(total_fee) as total")
            ->groupBy('month_key')
            ->pluck('total', 'month_key');

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');

            $months->push([
                'month' => $monthKey,
                'total' => (float) ($monthlyTotals->get($monthKey) ?? 0),
            ]);
        }

        return response()->json($months);
    }

    public function payoutRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
        ]);

        $this->service->createPayoutRequest(auth()->id(), $request->amount);
        return redirect()->back()->with('success', 'Payout request submitted.');
    }
}
