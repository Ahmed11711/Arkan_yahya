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
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('wallet_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['active', 'expired', 'pending', 'cancelled'])->default('active');
            $table->decimal('price', 10, 2);
            $table->boolean('commission_distributed')->default(false);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plans');
    }
};
