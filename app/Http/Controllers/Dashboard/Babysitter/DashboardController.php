<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Contracts\IDashboardService;

class DashboardController
{
    public function __construct(
        protected IDashboardService $service
    ) {}

    public function index()
    {
        $data = $this->service->getBabysitterOverview(auth()->id());

        return view('dashboard.babysitter.index', $data);
    }
}
