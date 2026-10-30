<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Contracts\IDashboardService;

class DashboardController
{
    public function __construct(
        protected IDashboardService $service
    ) {}

    public function index()
    {
        $data = $this->service->getDoctorOverview(auth()->id());

        return view('dashboard.doctor.index', $data);
    }
}
