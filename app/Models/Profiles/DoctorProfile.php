<?php

namespace App\Models\Profiles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'license_number',
        'specialization',
        'hospital',
        'pmdc_number',
        'profile_photo',
        'medical_license',
        'pmdc_cert',
        'cv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
