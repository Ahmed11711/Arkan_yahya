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
        Schema::create('ranks', function (Blueprint $table) {
                  $table->id();
            $table->string('name'); //  
            $table->text('desc')->nullable(); //  
            $table->integer('count_direct')->default(0); //  
            $table->integer('count_undirect')->default(0); // 
            $table->decimal('profit_g1', 10, 2)->default(0); //  
            $table->decimal('profit_g2', 10, 2)->default(0); // 
            $table->decimal('profit_g3', 10, 2)->default(0); //  
            $table->decimal('profit_g4', 10, 2)->default(0); //  
            $table->decimal('profit_g5', 10, 2)->default(0); //  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};
