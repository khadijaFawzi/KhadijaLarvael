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
        Schema::create('super_markets', function (Blueprint $table) {

            $table->id();
            $table->foreignId('User_id')->constrained()->onDelete('cascade');
            $table->string('SupermarketName');          // كما هو
            $table->string('Location')->nullable();     // كما هو
            $table->string('ContactNumber')->nullable(); // كما هو
            $table->text('description')->nullable();     // من التطبيق
            $table->string('bank_account')->nullable();  // من التطبيق
            $table->string('profile_image')->nullable(); // كما هو
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_markets');
    }
};
