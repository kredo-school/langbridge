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

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 送信者ID
            $table->unsignedBigInteger('to_user_id'); // 送信相手ID
            $table->text('content')->nullable(); // メッセージ本文
            $table->string('image_path')->nullable(); // 画像パス
            $table->string('emoji')->nullable(); // 絵文字
            $table->boolean('is_read')->default(false); // 既読フラグ
            $table->timestamp('sent_at')->nullable(); // 送信時刻
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
