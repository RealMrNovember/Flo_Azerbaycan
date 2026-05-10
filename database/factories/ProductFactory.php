<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $titles = [
            'Nike Revolution 7',
            'Nike Star Runner 4 NN',
            'adidas Grand Court',
            'Reebok Classic Leather',
            'Skechers Uno Stand On Air',
            'New Balance 574',
            'Lumberjack Immortal',
            'Kinetix Skyfall TX WP',
            'Polaris Casual Sneaker',
            'Vans Old Skool',
            'Crocs Classic Clog',
        ];

        $base = $this->faker->randomElement($titles);
        $productType = $this->faker->randomElement(['sneaker', 'running', 'training', 'boot', 'outdoor', 'sandal', 'slipper']);
        $gender = $this->faker->randomElement(['women', 'men', 'kids', 'unisex']);

        $suffix = $this->faker->randomElement(['Black', 'White', 'Navy', 'Beige', 'Grey']);
        $nameEn = "{$base} {$suffix}";
        $slug = Str::slug($nameEn).'-'.$this->faker->unique()->numerify('####');

        return [
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'slug' => $slug,
            'name' => [
                'az' => $nameEn,
                'ru' => $nameEn,
                'en' => $nameEn,
            ],
            'description' => [
                'az' => 'Yüngül, rahat və şəhər ritminə uyğun.',
                'ru' => 'Лёгкая, удобная и создана для городского ритма.',
                'en' => 'Lightweight comfort, tuned for everyday city pace.',
            ],
            'product_type' => $productType,
            'gender' => $gender,
            'is_active' => true,
        ];
    }
}
