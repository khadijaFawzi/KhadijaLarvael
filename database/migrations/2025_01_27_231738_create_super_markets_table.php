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
            $table->string('SupermarketName');
            $table->string('Location')->nullable();
            $table->string('ContactNumber')->nullable();
            $table->text('description')->nullable();
            $table->string('profile_image')->nullable();
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
