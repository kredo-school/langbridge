<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id'); //refers users.id
            $table->string('category'); // ReportCategory E
            $table->unsignedBigInteger('violation_reason_id'); //refers report_violation_reasons.id 
            $table->text('detail')->nullable();
            $table->string('file')->nullable(); 
            $table->string('reported_content_id'); // ID of the reported content (e.g., message.id)
            $table->string('reported_content_type'); // type of (e.g., 'message')
            $table->string('action_status')->default('pending'); // ActionStatus E
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
