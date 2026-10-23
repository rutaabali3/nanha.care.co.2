<?php

namespace App\Services;

use App\Contracts\IBabysitterService;
use App\Models\Profiles\BabysitterProfile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BabysitterService implements IBabysitterService
{
    public function getFeatured(): Collection
    {
        // Performance optimization: Eagerly aggregate average review ratings via database withAvg()
        // instead of loading all review models into memory or triggering N+1 queries in views.
        return BabysitterProfile::with('user')
            ->withAvg('reviews', 'rating')
            ->where('verified_status', \App\Enums\VerifiedStatus::Verified)
            ->inRandomOrder()
            ->take(6)
            ->get();
    }

    public function getAll(array $filters): LengthAwarePaginator
    {
        // Performance optimization: Replace with('reviews') with withAvg('reviews', 'rating')
        // to avoid hydrating hundreds of BabysitterReview Eloquent models for list card views.
        $query = BabysitterProfile::with('user')
            ->withAvg('reviews', 'rating');

        if (!empty($filters['city'])) {
            $query->whereHas('user', fn($q) => $q->where('city', $filters['city']));
        }
        if (!empty($filters['min_rate'])) {
            $query->where('hourly_rate', '>=', $filters['min_rate']);
        }
        if (!empty($filters['max_rate'])) {
            $query->where('hourly_rate', '<=', $filters['max_rate']);
        }
        if (!empty($filters['specialization'])) {
            $query->whereJsonContains('specializations', $filters['specialization']);
        }
        if (!empty($filters['verified'])) {
            $query->where('verified_status', \App\Enums\VerifiedStatus::Verified);
        }

        return $query->paginate(12);
    }

    public function getById(int $id): BabysitterProfile
    {
        return BabysitterProfile::with('user', 'reviews', 'verificationBadges')->findOrFail($id);
    }

    public function getCompletionPercentage(string $userId): int
    {
        $profile = BabysitterProfile::where('user_id', $userId)->firstOrFail();
        $fields = ['bio', 'hourly_rate', 'experience_years', 'specializations', 'cnic', 'avatar', 'availability'];
        $filled = collect($fields)->filter(fn($f) => !empty($profile->$f))->count();
        return (int) round(($filled / count($fields)) * 100);
    }
}
