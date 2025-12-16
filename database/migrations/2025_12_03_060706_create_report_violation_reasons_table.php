<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_violation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->timestamps(); // 必要なら追加（作成日時・更新日時）
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_violation_reasons');
    }
};
