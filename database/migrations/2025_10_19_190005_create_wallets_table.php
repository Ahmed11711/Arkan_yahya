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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->decimal('amount', 12, 2);
            $table->decimal('profit_rate', 5, 2); 
            $table->integer('profit_cycle');// take profit each 30 days
            $table->integer('duration_months')->nullable();
            $table->boolean('capital_return');
            $table->decimal('affiliate_commission_rate');
            $table->enum('status',['active','completed','pending'])->default('active');
            $table->decimal('early_withdraw_penalty')->nullable();
            $table->string('img')->nullable();
            $table->integer('service_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
