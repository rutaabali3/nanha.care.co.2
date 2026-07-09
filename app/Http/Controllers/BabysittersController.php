<?php

namespace App\Http\Controllers;

use App\Contracts\IBabysitterService;
use App\Models\Profiles\BabysitterProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BabysittersController extends Controller
{
    public function __construct(
        private readonly IBabysitterService $babysitterService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['city', 'min_rate', 'max_rate', 'experience_years', 'specialization', 'availability_day']);
        $babysitters = $this->babysitterService->getAll($filters);

        $cities = Cache::remember('babysitter_cities', 3600, function () {
            return BabysitterProfile::query()
                ->join('users', 'users.id', '=', 'babysitter_profiles.user_id')
                ->whereNotNull('users.city')
                ->select('users.city')
                ->distinct()
                ->pluck('city')
                ->sort()
                ->values()
                ->toArray();
        });

        $specializations = Cache::remember('babysitter_specializations', 3600, function () {
            return BabysitterProfile::query()
                ->whereNotNull('specializations')
                ->pluck('specializations')
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        });

        return view('babysitters.index', compact('babysitters', 'filters', 'cities', 'specializations'));
    }

    public function profile($id)
    {
        $babysitter = $this->babysitterService->getById((int) $id);

        abort_if(!$babysitter, 404);

        return view('babysitters.profile', compact('babysitter'));
    }
}
