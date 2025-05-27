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
        Schema::create('food_baskets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supermarket_id'); // ربط السلة بالسوبرماركت
            $table->string('name'); // اسم السلة
            $table->string('image')->nullable(); // الصورة (مسار/رابط)
            $table->text('description')->nullable(); // الوصف
            $table->decimal('price', 10, 2);
            $table->date('start_date'); // تاريخ البداية
            $table->date('end_date');   // تاريخ النهاية
            $table->timestamps();

            // المفتاح الأجنبي
            $table->foreign('supermarket_id')->references('id')->on('super_markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_baskets');
    }
};
