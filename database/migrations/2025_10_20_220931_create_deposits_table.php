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
        Schema::create('deposits', function (Blueprint $table) {
           $table->id();
            $table->string('transaction_id')->unique();  
            $table->string('address');                    
            $table->string('symbol');                     
            $table->decimal('amount', 30, 6);           
            $table->timestamps();
            
             $table->index(['address', 'symbol']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposites');
    }
};
