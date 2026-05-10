<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->json('color_name')->nullable();
            $table->char('color_hex', 7)->nullable();
            $table->string('barcode')->nullable()->index();
            $table->decimal('price', 12, 2)->index();
            $table->decimal('compare_at_price', 12, 2)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('variant_sizes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('size_label');
            $table->decimal('size_value', 5, 2)->nullable()->index();
            $table->unsignedInteger('stock_total')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->unique(['product_variant_id', 'size_label']);
        });

        Schema::create('product_images', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->cascadeOnUpdate()->nullOnDelete();
            $table->string('url');
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_cover')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('variant_sizes');
        Schema::dropIfExists('product_variants');
    }
};
