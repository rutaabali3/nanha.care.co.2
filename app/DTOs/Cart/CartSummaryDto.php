<?php

namespace App\DTOs\Cart;

readonly class CartSummaryDto
{
    public function __construct(
        public array $items,
        public float $subtotal,
        public float $tax,
        public float $total,
        public int $item_count,
    ) {}

    public static function fromSessionCart(array $cart): self
    {
        $items = [];
        foreach ($cart as $data) {
            $items[] = CartItemDto::fromArray($data);
        }

        $subtotal = array_reduce($items, fn (float $carry, CartItemDto $item) => $carry + $item->total(), 0.0);
        $tax = round($subtotal * 0.05, 2);
        $total = round($subtotal + $tax, 2);

        return new self(
            items: $items,
            subtotal: $subtotal,
            tax: $tax,
            total: $total,
            item_count: count($items),
        );
    }
}
