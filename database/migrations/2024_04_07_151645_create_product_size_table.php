<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//Pivot
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_size', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignUuid('size_id')->constrained('sizes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_size');
    }
};
