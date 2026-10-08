<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IPaymentService;
use App\Enums\OrderStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\System\PlatformSetting;
use Illuminate\Http\Request;

class EarningsController
{
    public function __construct(
        protected IPaymentService $service
    ) {}

    public function index()
    {
        $userId = auth()->id();
        $revenue = Order::whereHas('items.product.shop', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', OrderStatus::Delivered)->get();
        $payoutHistory = $this->service->getPayoutHistory($userId);

        $totalRevenue = (float) $revenue->sum('total');
        $paidPayouts = (float) $payoutHistory->whereIn('status', ['paid', 'approved'])->sum('amount');

        $earnings = [
            'total_revenue' => $totalRevenue,
            'pending_payout' => max(0, $totalRevenue - $paidPayouts),
            'total_orders' => $revenue->count(),
            'commission_percent' => PlatformSetting::get('commission_percent', '10'),
        ];

        return view('dashboard.shop-owner.earnings.index', compact('earnings', 'revenue', 'payoutHistory'));
    }

    public function chartData()
    {
        $userId = auth()->id();

        // PERFORMANCE OPTIMIZATION:
        // Replaced 12 separate database queries in a loop with 1 single batched query over the 12-month range.
        // Grouping in memory avoids 12x subquery overhead and fixes column name ('total' instead of 'price').
        // Expected impact: Reduces database queries from 12 (with subqueries) to 2 (query + eager load), ~80%+ reduction in DB response time.
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $monthlyTotals = OrderItem::whereHas('product.shop', fn($q) => $q->where('user_id', $userId))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->where('status', OrderStatus::Delivered)
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('order:id,created_at')
            ->get()
            ->groupBy(fn($item) => $item->order->created_at->format('Y-m'))
            ->map(fn($group) => (float) $group->sum('total'));

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $months->push([
                'month' => $key,
                'total' => $monthlyTotals->get($key, 0.0),
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

        return redirect()->back()->with('success', 'Payout request submitted successfully.');
    }
}
