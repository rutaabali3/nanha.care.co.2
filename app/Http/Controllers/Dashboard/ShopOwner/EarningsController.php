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
        $startDate = now()->subMonths(11)->startOfMonth();

        // Performance Optimization: Replace 12 monthly SQL queries in a loop with a single query.
        // Fetches all delivered order items over the 12-month period and aggregates totals by month in memory.
        $totalsByMonth = OrderItem::whereHas('product.shop', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->whereHas('order', function ($q) use ($startDate) {
                $q->where('status', OrderStatus::Delivered)
                    ->where('created_at', '>=', $startDate);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('order_items.total', 'orders.created_at as order_created_at')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->order_created_at)->format('Y-m');
            })
            ->map(fn ($group) => (float) $group->sum('total'));

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $months->push([
                'month' => $monthKey,
                'total' => (float) ($totalsByMonth->get($monthKey, 0.0)),
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
