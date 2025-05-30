<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('comment_likes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('comment_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();

        // علاقات الربط
        $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->unique(['comment_id', 'user_id']); // لمنع تكرار الإعجاب لنفس المستخدم على نفس التعليق
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_likes');
    }
};
