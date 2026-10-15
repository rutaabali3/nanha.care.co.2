<?php

namespace App\Models\Profiles;

use App\Enums\VerifiedStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\VerificationBadge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BabysitterProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'hourly_rate',
        'experience_years',
        'specializations',
        'cnic',
        'avatar',
        'availability',
        'verified_status',
        'rejection_reason',
    ];

    protected $casts = [
        'specializations' => 'array',
        'availability' => 'array',
        'verified_status' => VerifiedStatus::class,
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('babysitter_cities');
            \Illuminate\Support\Facades\Cache::forget('babysitter_specializations');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('babysitter_cities');
            \Illuminate\Support\Facades\Cache::forget('babysitter_specializations');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(BabysitterReview::class, 'babysitter_id');
    }

    public function verificationBadges()
    {
        return $this->hasMany(VerificationBadge::class, 'babysitter_profile_id');
    }

    /**
     * Performance optimization: Returns average rating without hydrating full review collections.
     * Prefers `reviews_avg_rating` populated via `withAvg('reviews', 'rating')`.
     */
    public function getAvgRatingAttribute(): float
    {
        if (array_key_exists('reviews_avg_rating', $this->attributes)) {
            return round((float) ($this->attributes['reviews_avg_rating'] ?? 0), 1);
        }

        if ($this->relationLoaded('reviews')) {
            return round((float) ($this->reviews->avg('rating') ?? 0), 1);
        }

        return round((float) ($this->reviews()->avg('rating') ?? 0), 1);
    }
}
