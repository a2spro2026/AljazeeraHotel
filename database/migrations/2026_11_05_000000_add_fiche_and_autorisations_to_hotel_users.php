<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotel_users', function (Blueprint $table) {
            $table->date('fiche_date')->nullable()->after('code');
            $table->json('autorisations')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('hotel_users', function (Blueprint $table) {
            $table->dropColumn(['fiche_date', 'autorisations']);
        });
    }
};
