<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('city')->index();
            $table->string('address')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('store_inventories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('variant_size_id')->constrained('variant_sizes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('stock')->default(0)->index();
            $table->timestamps();

            $table->unique(['store_id', 'variant_size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_inventories');
        Schema::dropIfExists('stores');
    }
};
