<?php

namespace App\Services;

use App\Contracts\IMarketplaceService;
use App\Enums\ContentStatus;
use App\Enums\ProductCategory;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MarketplaceService implements IMarketplaceService
{
    public function getProducts(array $filters): LengthAwarePaginator
    {
        $query = Product::with('shop', 'images')
            ->where('status', ContentStatus::Published);

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }
        if (! empty($filters['age_tag'])) {
            $query->whereJsonContains('age_tags', $filters['age_tag']);
        }
        if (! empty($filters['shop_id'])) {
            $query->where('shop_id', $filters['shop_id']);
        }

        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('created_at'),
        };

        return $query->paginate(12);
    }

    public function getProductById(int $id): Product
    {
        return Product::with('shop', 'images', 'reviews.user')
            ->where('status', ContentStatus::Published)
            ->findOrFail($id);
    }

    public function getRelatedProducts(int $productId): Collection
    {
        $product = Product::findOrFail($productId);

        return Product::with('shop', 'images')
            ->where('id', '!=', $productId)
            ->where('status', ContentStatus::Published)
            ->where(function ($q) use ($product) {
                $q->where('category', $product->category)
                    ->orWhere('shop_id', $product->shop_id);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getCategories(): array
    {
        return ProductCategory::values();
    }

    public function getShops(): Collection
    {
        return Shop::all();
    }
}
