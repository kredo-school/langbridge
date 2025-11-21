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
        Schema::table('users', function (Blueprint $table) {
        $table->date('birthday')->nullable()->after('email');
        $table->string('target_language')->nullable()->after('birthday');
        $table->string('country')->nullable()->after('target_language');
        $table->string('region')->nullable()->after('country');
        $table->boolean('suspended')->default(false)->after('region');
        $table->softDeletes()->after('suspended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birthday',
                'target_language',
                'country',
                'region',
                'suspended',
                'deleted_at'
            ]);
        });
    }
};
