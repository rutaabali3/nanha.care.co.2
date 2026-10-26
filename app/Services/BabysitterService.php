<?php

namespace App\Services;

use App\Contracts\IBabysitterService;
use App\Enums\VerifiedStatus;
use App\Models\Profiles\BabysitterProfile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BabysitterService implements IBabysitterService
{
    public function getFeatured(): Collection
    {
        // Cache featured babysitters for 5 minutes to avoid executing expensive `inRandomOrder()` query on every homepage hit.
        // Performance impact: Reduces SQL queries from 1 per homepage request to 0 on cache hit.
        return Cache::remember('featured_babysitters', 300, function () {
            return BabysitterProfile::with('user')
                ->withAvg('reviews', 'rating')
                ->where('verified_status', VerifiedStatus::Verified)
                ->inRandomOrder()
                ->take(6)
                ->get();
        });
    }

    public function getAll(array $filters): LengthAwarePaginator
    {
        // Use withAvg('reviews', 'rating') instead of eager loading all 'reviews' models.
        // Performance impact: Avoids hydrating hundreds of BabysitterReview Eloquent model instances
        // into memory during pagination while retrieving the computed average rating directly from SQL.
        $query = BabysitterProfile::with('user')->withAvg('reviews', 'rating');

        if (! empty($filters['city'])) {
            $query->whereHas('user', fn ($q) => $q->where('city', $filters['city']));
        }
        if (! empty($filters['min_rate'])) {
            $query->where('hourly_rate', '>=', $filters['min_rate']);
        }
        if (! empty($filters['max_rate'])) {
            $query->where('hourly_rate', '<=', $filters['max_rate']);
        }
        if (! empty($filters['specialization'])) {
            $query->whereJsonContains('specializations', $filters['specialization']);
        }
        if (! empty($filters['verified'])) {
            $query->where('verified_status', VerifiedStatus::Verified);
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
        $filled = collect($fields)->filter(fn ($f) => ! empty($profile->$f))->count();

        return (int) round(($filled / count($fields)) * 100);
    }
}
