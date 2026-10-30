<?php

namespace App\Services;

use App\Contracts\IEmailService;
use App\Contracts\INotificationService;
use App\Contracts\IOrderService;
use App\Enums\OrderStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\ReturnRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService implements IOrderService
{
    public function __construct(
        private INotificationService $notification,
        private IEmailService $email,
    ) {}

    public function getByParent(string $userId): LengthAwarePaginator
    {
        return Order::with('items.product')
            ->where('parent_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function getByShopOwner(string $userId): LengthAwarePaginator
    {
        return Order::with('items.product', 'parent')
            ->whereHas('items.product.shop', fn ($q) => $q->where('user_id', $userId))
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function create(array $data, string $userId): Order
    {
        return DB::transaction(function () use ($data, $userId) {
            $total = 0;
            $items = [];

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $unitPrice = $product->sale_price ?? $product->price;
                $lineTotal = $unitPrice * $item['qty'];
                $total += $lineTotal;
                $items[] = [
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'unit_price' => $unitPrice,
                    'total' => $lineTotal,
                ];
            }

            $order = Order::create([
                'parent_id' => $userId,
                'shipping_address' => $data['shipping_address'],
                'payment_method' => $data['payment_method'],
                'status' => OrderStatus::Processing,
                'total' => $total,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            $this->email->sendOrderConfirmation($order->id);

            return $order->load('items.product');
        });
    }

    public function updateStatus(int $id, string $status, string $userId): void
    {
        $order = Order::whereHas('items.product.shop', fn ($q) => $q->where('user_id', $userId))
            ->findOrFail($id);
        $order->update(['status' => $status]);

        $this->notification->send(
            $order->parent_id,
            'order_status',
            "Your order #{$order->id} status has been updated to {$status}.",
        );
    }

    public function requestReturn(int $id, string $reason, string $userId): void
    {
        $order = Order::with('items.product.shop')
            ->where('parent_id', $userId)
            ->findOrFail($id);

        ReturnRequest::create([
            'order_id' => $order->id,
            'reason' => $reason,
            'status' => 'pending',
        ]);

        $shopOwnerId = $order->items->first()->product->shop->user_id;
        $this->notification->send(
            $shopOwnerId,
            'return_request',
            "Return requested for order #{$order->id}.",
        );
    }
}
