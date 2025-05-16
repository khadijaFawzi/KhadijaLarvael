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
           Schema::disableForeignKeyConstraints();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supermarket_id')->constrained('super_markets')->onDelete('cascade');
            $table-> foreignId('Category_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('Price');
            $table->string('Image');
            $table->text('Description');
              $table->string('barcode')->nullable()->index(); // ✅ هذا هو الكود الموحد الاختياري
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
