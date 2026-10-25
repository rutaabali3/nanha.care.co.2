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
        return $this->hasMany(BabysitterReview::class, 'babysitter_id', 'user_id');
    }

    /**
     * Get the average rating, leveraging pre-computed reviews_avg_rating if loaded via withAvg.
     */
    public function getAvgRatingAttribute(): float
    {
        return (float) ($this->attributes['reviews_avg_rating'] ?? $this->reviews()->avg('rating') ?? 0);
    }

    public function verificationBadges()
    {
        return $this->hasMany(VerificationBadge::class, 'babysitter_profile_id');
    }
}
