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
        Schema::create('user_trons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('address');
            $table->text('encrypted_payload');    
            // $table->text('phrase');
            // $table->text('privateKey');
            // $table->text('publicKey');
            // $table->text('entropy');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_trons');
    }
};
