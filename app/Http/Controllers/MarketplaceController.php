<?php

namespace App\Http\Controllers;

use App\Contracts\IMarketplaceService;
use App\Enums\ContentStatus;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function __construct(
        private readonly IMarketplaceService $marketplaceService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category', 'min_price', 'max_price', 'sort']);
        $products = $this->marketplaceService->getProducts($filters);
        $categories = $this->marketplaceService->getCategories();
        $shops = $this->marketplaceService->getShops();

        return view('marketplace.index', compact('products', 'filters', 'categories', 'shops'));
    }

    public function detail($id)
    {
        $product = $this->marketplaceService->getProductById((int) $id);

        abort_if(! $product || $product->status !== ContentStatus::Published, 404);

        $related = $this->marketplaceService->getRelatedProducts((int) $id);

        return view('marketplace.detail', compact('product', 'related'));
    }
}
