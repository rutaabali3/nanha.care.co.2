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

        // Performance Optimization: Query all existing slugs starting with base slug in a single query
        // to avoid N sequential DB exists checks in a loop during collision resolution.
        $existingSlugs = DB::table($model)
            ->where($column, $slug)
            ->orWhere($column, 'like', $original . '-%')
            ->pluck($column)
            ->flip();

        if (!isset($existingSlugs[$slug])) {
            return $slug;
        }

        $counter = 1;
        while (isset($existingSlugs[$original . '-' . $counter])) {
            $counter++;
        }

        return $original . '-' . $counter;
    }

    public static function generateFromTitle(string $title): string
    {
        return Str::slug($title);
    }

    public static function unique(string $model, string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;

        // Performance Optimization: Fetch matching existing slugs in a single query using LIKE
        // and check key presence in-memory, reducing database queries from O(N) to O(1).
        $query = $model::where(function ($q) use ($slug, $original) {
            $q->where('slug', $slug)
              ->orWhere('slug', 'like', $original . '-%');
        });

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        $existingSlugs = $query->pluck('slug')->flip();

        if (!isset($existingSlugs[$slug])) {
            return $slug;
        }

        $counter = 1;
        while (isset($existingSlugs[$original . '-' . $counter])) {
            $counter++;
        }

        return $original . '-' . $counter;
    }
}
