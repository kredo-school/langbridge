<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_violation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // ReportCategory E（例: 'message', 'profile'）
            $table->string('name_JP');
            $table->string('name_EN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_violation_reasons');
    }
};
