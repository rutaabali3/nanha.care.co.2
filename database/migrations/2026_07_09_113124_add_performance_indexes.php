<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status');
            $table->index(['parent_id', 'status']);
            $table->index(['babysitter_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('status');
            $table->index('category');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index(['parent_id', 'status']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('status');
            $table->index(['doctor_id', 'status']);
        });

        Schema::table('support_tickets', function (Blueprint $table) {
            $table->index('status');
            $table->index(['assigned_to', 'status']);
        });

        Schema::table('babysitter_profiles', function (Blueprint $table) {
            $table->index('verified_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['parent_id', 'status']);
            $table->dropIndex(['babysitter_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['parent_id', 'status']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['doctor_id', 'status']);
        });

        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['assigned_to', 'status']);
        });

        Schema::table('babysitter_profiles', function (Blueprint $table) {
            $table->dropIndex(['verified_status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
