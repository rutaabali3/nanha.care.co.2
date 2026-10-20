<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IPaymentService;
use App\Enums\OrderStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\System\PlatformSetting;
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

        // Optimization: Execute a single aggregate SQL query grouped by year and month
        // instead of running 12 separate database queries in a loop.
        $driver = DB::connection()->getDriverName();
        $monthKeySql = $driver === 'sqlite'
            ? "strftime('%Y-%m', order_items.created_at) as month_key"
            : "DATE_FORMAT(order_items.created_at, '%Y-%m') as month_key";

        $monthlyTotals = OrderItem::whereHas('product.shop', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('order', function ($q) use ($startDate) {
                $q->where('status', OrderStatus::Delivered)
                    ->where('created_at', '>=', $startDate);
            })
            ->selectRaw("{$monthKeySql}, SUM(order_items.total) as total")
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

        return redirect()->back()->with('success', 'Payout request submitted successfully.');
    }
}
