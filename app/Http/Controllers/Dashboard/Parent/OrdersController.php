<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Contracts\IOrderService;
use App\Models\Marketplace\Order;
use Illuminate\Http\Request;

class OrdersController
{
    public function __construct(
        protected IOrderService $service
    ) {}

    public function index()
    {
        $orders = $this->service->getByParent(auth()->id());

        return view('dashboard.parent.orders.index', compact('orders'));
    }

    public function details($id)
    {
        $order = Order::with('items.product')
            ->where('parent_id', auth()->id())
            ->findOrFail($id);

        return view('dashboard.parent.orders.details', compact('order'));
    }

    public function requestReturn(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $this->service->requestReturn($id, $validated['reason'], auth()->id());

        return redirect()->route('parent.orders.details', $id)
            ->with('success', 'Return request submitted successfully.');
    }
}
