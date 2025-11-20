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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('handle')->unique();
            $table->string('nickname');
            $table->string('avatar');
            $table->integer('JP_level');
            $table->integer('EN_level');
            $table->longText('bio');
            $table->boolean('hidden');
            $table->boolean('age_hidden');
            $table->boolean('country_hidden');
            $table->boolean('region_hidden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
