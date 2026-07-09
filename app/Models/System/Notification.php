<?php

namespace App\Models\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'link',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function ($notification) {
            \Illuminate\Support\Facades\Cache::forget("notifications.unread.{$notification->user_id}");
            \Illuminate\Support\Facades\Cache::forget("notifications.recent.{$notification->user_id}");
        });

        static::deleted(function ($notification) {
            \Illuminate\Support\Facades\Cache::forget("notifications.unread.{$notification->user_id}");
            \Illuminate\Support\Facades\Cache::forget("notifications.recent.{$notification->user_id}");
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
