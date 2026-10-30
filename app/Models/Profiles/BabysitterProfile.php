<?php

namespace App\Models\Profiles;

use App\Enums\VerifiedStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\VerificationBadge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
            Cache::forget('babysitter_cities');
            Cache::forget('babysitter_specializations');
        });

        static::deleted(function () {
            Cache::forget('babysitter_cities');
            Cache::forget('babysitter_specializations');
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
}
