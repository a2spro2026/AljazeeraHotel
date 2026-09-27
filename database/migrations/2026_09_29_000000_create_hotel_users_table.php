<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_users', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('nom');
            $table->string('cin', 30)->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('adresse')->nullable();
            $table->string('profil', 40);
            $table->string('contrat', 40)->nullable();
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->string('formation')->nullable();
            $table->decimal('salaire', 12, 2)->nullable();
            $table->string('login', 60)->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_users');
    }
};
