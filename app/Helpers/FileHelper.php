<?php

namespace App\Helpers;

class FileHelper
{
    public static function getPublicPath(string $storagePath): string
    {
        return asset('storage/'.ltrim($storagePath, '/'));
    }

    public static function getPlaceholder(string $type): string
    {
        return match ($type) {
            'avatar' => asset('images/placeholders/avatar.png'),
            'product' => asset('images/placeholders/product.png'),
            'banner' => asset('images/placeholders/banner.png'),
            'cover' => asset('images/placeholders/cover.png'),
            default => asset('images/placeholders/default.png'),
        };
    }

    public static function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' B';
    }
}
