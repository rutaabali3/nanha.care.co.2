<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function formatPkr(float $amount): string
    {
        return 'Rs. '.number_format($amount, 0);
    }

    public static function calculateCommission(float $amount, float $percent): float
    {
        return round(($amount * $percent) / 100, 2);
    }

    public static function calculateTotal(array $items): float
    {
        return array_reduce($items, function (float $carry, array $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0.0);
    }
}
