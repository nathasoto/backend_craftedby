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
        Schema::create('shops', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->text('history')->nullable();
            $table->text('production_methods')->nullable();
            $table->string('specialties')->nullable();
            $table->string('zip_code')->nullable();
            $table->text("description",300)->nullable();
            $table->foreignid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('theme_id')->constrained('themes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
