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
        // Bolt Optimization: Use withAvg('reviews', 'rating') instead of eager loading full review models
        return BabysitterProfile::with('user')
            ->withAvg('reviews', 'rating')
            ->where('verified_status', \App\Enums\VerifiedStatus::Verified)
            ->inRandomOrder()
            ->take(6)
            ->get();
    }

    public function getAll(array $filters): LengthAwarePaginator
    {
        // Bolt Optimization: Use withAvg('reviews', 'rating') instead of eager loading all review models
        // to avoid loading hundreds/thousands of review records into memory.
        $query = BabysitterProfile::with('user')->withAvg('reviews', 'rating');

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

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'rate_asc' => $query->orderBy('hourly_rate', 'asc'),
            'rate_desc' => $query->orderBy('hourly_rate', 'desc'),
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            default => $query->orderByDesc('created_at'),
        };

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
