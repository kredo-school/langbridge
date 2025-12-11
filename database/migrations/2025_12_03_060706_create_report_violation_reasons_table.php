<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_violation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // ReportCategory E（例: 'message', 'profile'）
            $table->string('name');
        });


        DB::table('report_violation_reasons')->insert([
            // --- user category ---
            [
                'category' => 'user',
                'name' => 'Inappropriate or false information'
            ],
            [
                'category' => 'user',
                'name' => 'External links or social media promotion'
            ],
            [
                'category' => 'user',
                'name' => 'Self-promotion or solicitation'
            ],
            [
                'category' => 'user',
                'name' => 'Offensive or inappropriate language'
            ],
            [
                'category' => 'user',
                'name' => 'Other'
            ],

            // --- chat category ---
            [
                'category' => 'chat',
                'name' => 'Content unrelated to language exchange'
            ],
            [
                'category' => 'chat',
                'name' => 'Offensive or aggressive remarks'
            ],
            [
                'category' => 'chat',
                'name' => 'Solicitation, promotion, or spam'
            ],
            [
                'category' => 'chat',
                'name' => 'Sending inappropriate images or links'
            ],
            [
                'category' => 'chat',
                'name' => 'Other'
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('report_violation_reasons');
    }
};
