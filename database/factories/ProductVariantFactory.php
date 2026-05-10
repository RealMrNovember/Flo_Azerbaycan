<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        $colors = [
            ['name' => 'Black', 'hex' => '#111827'],
            ['name' => 'White', 'hex' => '#f8fafc'],
            ['name' => 'Navy', 'hex' => '#0f2b63'],
            ['name' => 'Beige', 'hex' => '#e7d7c1'],
            ['name' => 'Grey', 'hex' => '#94a3b8'],
            ['name' => 'Orange', 'hex' => '#ff6a00'],
        ];

        $picked = $this->faker->randomElement($colors);
        $price = $this->faker->randomFloat(2, 29, 299);
        $compare = $this->faker->boolean(35) ? $price + $this->faker->randomFloat(2, 10, 80) : null;

        return [
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'sku' => strtoupper($this->faker->unique()->bothify('FLO-??-#####')),
            'color_name' => [
                'az' => $picked['name'],
                'ru' => $picked['name'],
                'en' => $picked['name'],
            ],
            'color_hex' => $picked['hex'],
            'barcode' => $this->faker->optional()->ean13(),
            'price' => $price,
            'compare_at_price' => $compare,
            'is_active' => true,
        ];
    }
}
