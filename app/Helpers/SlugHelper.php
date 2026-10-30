<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlugHelper
{
    public static function generate(string $text, string $model, string $column = 'slug'): string
    {
        $slug = Str::slug($text);
        $original = $slug;
        $counter = 1;

        while (DB::table($model)->where($column, $slug)->exists()) {
            $slug = $original.'-'.$counter++;
        }

        return $slug;
    }

    public static function generateFromTitle(string $title): string
    {
        return Str::slug($title);
    }

    public static function unique(string $model, string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        $query = $model::where('slug', $slug);
        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $original.'-'.$counter++;
            $query = $model::where('slug', $slug);
            if ($ignoreId !== null) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
