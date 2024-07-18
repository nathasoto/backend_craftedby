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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->float('price')->unsigned()->nullable();//valores positivos
            $table->integer('weight')->nullable();
            $table->integer('stock')->nullable();
            $table->string('material')->nullable();
            $table->text('history')->nullable();
            $table->string('image_path')->nullable();
            $table->text("description",300);
            $table->foreignUuid('categories_id')->constrained('categories');
            $table->foreignUuid('shop_id')->constrained('shops')->onDelete('cascade');
            $table->foreignid('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
