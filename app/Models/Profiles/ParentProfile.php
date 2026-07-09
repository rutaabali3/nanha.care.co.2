<?php

namespace App\Models\Profiles;

use Illuminate\Database\Eloquent\Model;

class ParentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'num_children',
        'children_ages',
        'emergency_contact_name',
        'emergency_contact_phone',
        'address',
        'special_requirements',
    ];

    protected $casts = [
        'children_ages' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
