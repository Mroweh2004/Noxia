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
            $table->id();
            $table->string('name');
            $table->text('details')->nullable();
            $table->string('serial_number')->unique();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('price_after_sale', 10, 2)->nullable();
            $table->string('product_image')->nullable();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->enum('gender', ['male', 'female', 'unisex'])->default('unisex');
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->enum('status', ['out_of_stock', 'active'])->default('active');
            $table->timestamps();
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
