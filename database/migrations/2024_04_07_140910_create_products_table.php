<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the 'products' table.
 * This table stores product information, including attributes, relationships, and indexes for optimization.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Defines the structure of the 'products' table, including primary key, columns,
     * foreign keys, and indexes for efficient queries.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();// UUID as primary key for unique identification
            $table->timestamps();
            // Product Attributes
            $table->string('name')->nullable()->index();// Product name (indexed for quick search)
            $table->float('price')->unsigned()->nullable();// Positive price values
            $table->integer('weight')->nullable();// Product weight
            $table->integer('stock')->nullable();// Stock quantity
            $table->string('material')->nullable(); // Material description
            $table->text('history')->nullable();// Product history or additional details
            $table->string('image_path')->nullable();// Path to product image
            $table->text("description",300);// Description text (up to 300 characters)
            // Foreign Keys
            $table->foreignUuid('categories_id')->constrained('categories');
            // References 'id' in the 'categories' table
            $table->foreignUuid('shop_id')->constrained('shops')->onDelete('cascade');
            // References 'id' in the 'shops' table with cascading deletes
            $table->foreignid('user_id')->constrained('users')->onDelete('cascade');
            // References 'id' in the 'users' table with cascading deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the 'products' table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
