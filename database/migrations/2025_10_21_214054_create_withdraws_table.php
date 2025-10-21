<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('transaction_id')->unique();
            $table->string('address');
            $table->string('symbol');
            $table->decimal('amount', 30, 6);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();

             $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
