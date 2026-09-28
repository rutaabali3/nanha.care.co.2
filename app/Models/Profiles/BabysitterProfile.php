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
     * Get the average rating for the babysitter.
     * Uses pre-loaded reviews_avg_rating if available (from withAvg),
     * otherwise computes from loaded reviews relationship or executes query fallback.
     */
    public function getAvgRatingAttribute(): float
    {
        if (isset($this->attributes['reviews_avg_rating']) && $this->attributes['reviews_avg_rating'] !== null) {
            return (float) $this->attributes['reviews_avg_rating'];
        }

        if ($this->relationLoaded('reviews')) {
            return (float) ($this->reviews->avg('rating') ?: 0);
        }

        return (float) ($this->reviews()->avg('rating') ?: 0);
    }
}
