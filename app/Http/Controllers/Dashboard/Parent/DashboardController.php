<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Contracts\IDashboardService;

class DashboardController
{
    public function __construct(
        protected IDashboardService $service
    ) {}

    public function index()
    {
        $data = $this->service->getParentOverview(auth()->id());

        return view('dashboard.parent.index', $data);
    }
}
