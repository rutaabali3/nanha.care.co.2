<?php

namespace App\Models\Marketplace;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'banner',
        'category',
        'description',
        'contact_info',
        'return_policy',
    ];

    protected $casts = [
        'category' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productReviews()
    {
        return $this->hasManyThrough(ProductReview::class, Product::class);
    }

    /**
     * Calculate average rating for the shop across all its product reviews.
     * Evaluates rating aggregate via efficient hasManyThrough relationship query.
     */
    public function averageRating(): float
    {
        return (float) ($this->productReviews()->avg('rating') ?: 0);
    }
}
