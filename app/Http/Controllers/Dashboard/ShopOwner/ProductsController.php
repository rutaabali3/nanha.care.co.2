<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IFileUploadService;
use App\Contracts\IProductService;
use App\Enums\ContentStatus;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Models\Marketplace\Product;
use Illuminate\Http\Request;

class ProductsController
{
    public function __construct(
        protected IProductService $service,
        protected IFileUploadService $fileUploadService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'status', 'search']);
        $products = $this->service->getByShopOwner(auth()->id(), $filters);

        return view('dashboard.shop-owner.products.index', compact('products'));
    }

    public function create()
    {
        return view('dashboard.shop-owner.products.create');
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        $status = $request->input('action') === 'submit'
            ? ContentStatus::UnderReview
            : ContentStatus::Draft;
        $data['status'] = $status;
        $userId = auth()->id();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $this->fileUploadService->save($file, 'products');
            }
        }

        $data['image_paths'] = $images;
        $this->service->create($data, $userId);

        return redirect()->route('shop-owner.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with('shop')->findOrFail($id);

        if ($product->shop->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.shop-owner.products.edit', compact('product'));
    }

    public function update(EditProductRequest $request, $id)
    {
        $data = $request->validated();
        $status = $request->input('action') === 'submit'
            ? ContentStatus::UnderReview
            : ContentStatus::Draft;
        $data['status'] = $status;
        $this->service->update($id, $data, auth()->id());

        return redirect()->route('shop-owner.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function duplicate($id)
    {
        $this->service->duplicate($id, auth()->id());

        return redirect()->route('shop-owner.products.index')
            ->with('success', 'Product duplicated successfully.');
    }

    public function archive($id)
    {
        $this->service->update($id, ['status' => 'archived'], auth()->id());

        return redirect()->route('shop-owner.products.index')
            ->with('success', 'Product archived successfully.');
    }

    public function destroy($id)
    {
        $this->service->delete($id, auth()->id());

        return redirect()->route('shop-owner.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function deleteImage($id)
    {
        $this->service->deleteImage((int) $id, auth()->id());

        return back()->with('success', 'Image deleted successfully.');
    }
}
