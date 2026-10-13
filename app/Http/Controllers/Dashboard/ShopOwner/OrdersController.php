<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IOrderService;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrdersController
{
    public function __construct(
        protected IOrderService $service
    ) {}

    public function index(Request $request)
    {
        $status = $request->get('status');
        $from = $request->get('from');
        $to = $request->get('to');

        // Pass filter parameters array to service layer for database-level query filtering
        $orders = $this->service->getByShopOwner(auth()->id(), array_filter([
            'status' => $status,
            'from' => $from,
            'to' => $to,
        ]));

        return view('dashboard.shop-owner.orders.index', compact('orders', 'status'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in([
                OrderStatus::Processing->value,
                OrderStatus::Shipped->value,
                OrderStatus::Delivered->value,
            ])],
        ]);

        $this->service->updateStatus($id, $request->status, auth()->id());

        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $this->service->updateStatus($id, OrderStatus::Cancelled->value, auth()->id());

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}
