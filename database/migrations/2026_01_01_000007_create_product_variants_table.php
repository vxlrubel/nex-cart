<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('sku');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
