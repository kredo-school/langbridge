<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id'); // users.id を参照
            $table->string('category'); // ReportCategory E
            $table->unsignedBigInteger('violation_reason_id'); // report_violation_reasons.id を参照予定
            $table->text('detail')->nullable();
            $table->string('file')->nullable(); // 添付ファイルのパス
            $table->string('reported_content_id'); // 通報対象のID（例: message.id）
            $table->string('reported_content_type'); // 通報対象のタイプ（例: 'message'）
            $table->string('action_status')->default('pending'); // ActionStatus E
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
