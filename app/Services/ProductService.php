<?php

namespace App\Services;

use App\Contracts\IFileUploadService;
use App\Contracts\IProductService;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\ProductImage;
use App\Models\Marketplace\Shop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService implements IProductService
{
    public function __construct(
        private IFileUploadService $fileUpload,
    ) {}

    public function getByShopOwner(string $userId, array $filters): LengthAwarePaginator
    {
        $query = Product::with('shop', 'images')
            ->whereHas('shop', fn ($q) => $q->where('user_id', $userId));

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        return $query->orderByDesc('created_at')->paginate(12);
    }

    public function create(array $data, string $userId): Product
    {
        $shop = Shop::where('user_id', $userId)->firstOrFail();
        $data['shop_id'] = $shop->id;

        $product = Product::create($data);

        if (! empty($data['images'])) {
            foreach ($data['images'] as $i => $image) {
                $path = $this->fileUpload->save($image, 'products');
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $i === 0,
                ]);
            }
        }

        return $product->load('images');
    }

    public function update(int $id, array $data, string $userId): Product
    {
        $product = Product::whereHas('shop', fn ($q) => $q->where('user_id', $userId))
            ->findOrFail($id);

        $product->update($data);

        if (! empty($data['images'])) {
            foreach ($data['images'] as $i => $image) {
                $path = $this->fileUpload->save($image, 'products');
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $i === 0 && $product->images()->count() === 0,
                ]);
            }
        }

        return $product->fresh()->load('images');
    }

    public function delete(int $id, string $userId): void
    {
        $product = Product::whereHas('shop', fn ($q) => $q->where('user_id', $userId))
            ->findOrFail($id);
        $product->delete();
    }

    public function duplicate(int $id, string $userId): Product
    {
        $original = Product::whereHas('shop', fn ($q) => $q->where('user_id', $userId))
            ->findOrFail($id);

        $copy = $original->replicate();
        $copy->name = $original->name.' (Copy)';
        $copy->save();

        return $copy->load('images');
    }

    public function deleteImage(int $imageId, string $userId): void
    {
        $image = ProductImage::findOrFail($imageId);
        $product = $image->product;

        if ($product->shop->user_id !== $userId) {
            abort(403);
        }

        $this->fileUpload->delete($image->path);
        $image->delete();
    }
}
