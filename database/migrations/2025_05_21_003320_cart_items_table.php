<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            // تأكدي من استخدام InnoDB لدعم المفاتيح الخارجية
            $table->engine = 'InnoDB';

            $table->id(); // BIGINT UNSIGNED

            // foreign key إلى carts.id
            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->onDelete('cascade');

            // foreign key إلى products.id
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // foreign key إلى offers.id (اختياري)
            $table->foreignId('offer_id')
                  ->nullable()
                  ->constrained('offers')
                  ->onDelete('cascade');

            // foreign key إلى super_markets.id
            // نستخدم foreignId لأن جدول super_markets معرف بـ $table->id() (bigIncrements)
            $table->foreignId('supermarket_id')
                  ->constrained('super_markets')
                  ->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            // total_price يحسب ضرب quantity في price تلقائياً
            $table->decimal('total_price', 12, 2)
                  ->storedAs('quantity * price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
