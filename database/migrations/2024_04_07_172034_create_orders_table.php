<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines the structure of the 'orders' table, including primary key, columns,
     * foreign key constraints, and default values where necessary.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();// UUID used as the primary key for unique order identification
            $table->timestamps(); // Automatically adds 'created_at' and 'updated_at' columns
            // Order Attributes
            $table->decimal('total', 10, 2)->nullable();// Total amount for the order (10 digits, 2 decimals)
            $table->text('shipping_address');// Shipping address for the order
            $table->text('mobile_phone');// Mobile phone number of the customer
            $table->string('status')->default('pending'); // Order status, defaulting to 'pending'
            // Foreign Key
            $table->foreignid('user_id')->constrained('users')// References 'id' in 'users' table
                ->onDelete('cascade'); // Deletes related orders when the user is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method rolls back the migration by dropping the 'orders' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
