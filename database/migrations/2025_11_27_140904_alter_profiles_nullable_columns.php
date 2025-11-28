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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('avatar')->nullable()->change();
            $table->integer('JP_level')->nullable()->change();
            $table->integer('EN_level')->nullable()->change();
            $table->longText('bio')->nullable()->change();
            $table->boolean('hidden')->default(true)->change();
            $table->boolean('age_hidden')->default(true)->change();
            $table->boolean('country_hidden')->default(true)->change();
            $table->boolean('region_hidden')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('avatar')->nullable(false)->change();
            $table->integer('JP_level')->nullable(false)->change();
            $table->integer('EN_level')->nullable(false)->change();
            $table->longText('bio')->nullable(false)->change();
            $table->boolean('hidden')->default(false)->change();
            $table->boolean('age_hidden')->default(false)->change();
            $table->boolean('country_hidden')->default(false)->change();
            $table->boolean('region_hidden')->default(false)->change();
        });
    }
};
