<?php

use App\Models\Order;
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
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 8, 2)->default(0.00);
            $table->string('color_id')->default('N/A');
            $table->string('size_id')->default('N/A');
            $table->foreignUuId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignUuId('product_id')->constrained('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
