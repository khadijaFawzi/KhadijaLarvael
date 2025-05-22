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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supermarket_id')->constrained('super_markets')->onDelete('cascade')->default(false);
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->string('Description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_ai_processed')->default(false);
            $table->text('extracted_text')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
       
    }
};
