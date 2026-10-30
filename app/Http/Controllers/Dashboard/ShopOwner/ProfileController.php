<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IFileUploadService;
use App\Enums\ShopCategory;
use App\Models\Marketplace\Shop;
use Illuminate\Http\Request;

class ProfileController
{
    public function __construct(
        protected IFileUploadService $fileUploadService
    ) {}

    public function index()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        return view('dashboard.shop-owner.profile.index', compact('shop'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'category' => 'nullable|string',
            'description' => 'required|string',
            'return_policy' => 'nullable|string',
            'contact_info' => 'nullable|string|max:500',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('logo')) {
            $shop->logo = $this->fileUploadService->save($request->file('logo'), 'shops/logos');
        }

        if ($request->hasFile('banner')) {
            $shop->banner = $this->fileUploadService->save($request->file('banner'), 'shops/banners');
        }

        $data = $request->only([
            'name', 'description', 'return_policy', 'contact_info',
        ]);

        if ($request->filled('category')) {
            $categories = json_decode($request->input('category'), true);
            $validValues = ShopCategory::values();

            if (is_array($categories)) {
                $categories = array_intersect($categories, $validValues);
                $data['category'] = array_values($categories);
            }
        }

        $shop->update($data);

        return redirect()->back()->with('success', 'Shop profile updated successfully.');
    }
}
