<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Contracts\IDashboardService;

class DashboardController
{
    public function __construct(
        protected IDashboardService $service
    ) {}

    public function index()
    {
        $data = $this->service->getShopOwnerOverview(auth()->id());

        return view('dashboard.shop-owner.index', ['overview' => $data]);
    }
}
