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
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->integer('generation');
            $table->boolean('active');
            $table->boolean('block')->default(false);
            $table->decimal('moony', 10, 2)->default(0);
            $table->timestamps();
            $table->index(['user_id', 'generation'], 'user_generation_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliates');
    }
};
