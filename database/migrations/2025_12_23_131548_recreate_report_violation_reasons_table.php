<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 既存テーブルを削除
        Schema::dropIfExists('report_violation_reasons');

        // 新しい構造で再作成
        Schema::create('report_violation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // ロールバック時はテーブルを削除
        Schema::dropIfExists('report_violation_reasons');
    }
};
