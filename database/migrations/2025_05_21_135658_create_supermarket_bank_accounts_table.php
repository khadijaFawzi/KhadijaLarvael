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
        Schema::create('supermarket_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supermarket_id')->constrained('super_markets')->onDelete('cascade');
            $table->string('bank_name');               // اسم البنك
            $table->string('account_number');          // رقم الحساب
            $table->string('iban')->nullable();        // رقم الآيبان (اختياري)
            $table->string('account_holder_name')->nullable(); // اسم صاحب الحساب (اختياري)
            $table->string('bank_logo')->nullable();   // شعار البنك (اختياري)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supermarket_bank_accounts');
    }
};
