<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\VariantSize;
use Illuminate\Database\Eloquent\Factories\Factory;

final class VariantSizeFactory extends Factory
{
    protected $model = VariantSize::class;

    public function definition(): array
    {
        $sizes = [
            ['label' => '36', 'value' => 36.0],
            ['label' => '36.5', 'value' => 36.5],
            ['label' => '37', 'value' => 37.0],
            ['label' => '37.5', 'value' => 37.5],
            ['label' => '38', 'value' => 38.0],
            ['label' => '38.5', 'value' => 38.5],
            ['label' => '39', 'value' => 39.0],
            ['label' => '40', 'value' => 40.0],
            ['label' => '40.5', 'value' => 40.5],
            ['label' => '41', 'value' => 41.0],
            ['label' => '42', 'value' => 42.0],
            ['label' => '42.5', 'value' => 42.5],
            ['label' => '43', 'value' => 43.0],
            ['label' => '44', 'value' => 44.0],
            ['label' => '45', 'value' => 45.0],
        ];

        $picked = $this->faker->randomElement($sizes);

        return [
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->value('id'),
            'size_label' => $picked['label'],
            'size_value' => $picked['value'],
            'stock_total' => $this->faker->numberBetween(0, 18),
            'is_active' => true,
        ];
    }
}
