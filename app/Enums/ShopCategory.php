<?php

namespace App\Enums;

enum ShopCategory: string
{
    case Diapers = 'diapers';
    case Formula = 'formula';
    case Toys = 'toys';
    case Clothing = 'clothing';
    case HealthSafety = 'health_safety';

    public function label(): string
    {
        return match ($this) {
            self::Diapers => 'Diapers',
            self::Formula => 'Formula',
            self::Toys => 'Toys',
            self::Clothing => 'Clothing',
            self::HealthSafety => 'Health & Safety',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }

        return $result;
    }
}
