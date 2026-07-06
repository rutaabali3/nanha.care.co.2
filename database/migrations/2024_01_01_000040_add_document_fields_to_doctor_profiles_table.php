<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->string('medical_license')->nullable()->after('profile_photo');
            $table->string('pmdc_cert')->nullable()->after('medical_license');
            $table->string('cv')->nullable()->after('pmdc_cert');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn(['medical_license', 'pmdc_cert', 'cv']);
        });
    }
};
