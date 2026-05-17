<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('sku', 100)->unique()->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable(); // original price before discount
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('primary_image')->nullable();
            $table->json('gallery_images')->nullable();          // additional product images
            $table->decimal('weight', 8, 3)->nullable();         // in kg
            $table->string('brand', 150)->nullable();
            $table->json('attributes')->nullable();              // color, size, material etc.
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('category_id');
            $table->index(['price', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
