<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nameEn = $this->faker->randomElement([
            'Sneakers',
            'Boots',
            'Outdoor',
            'Running',
            'Training',
            'Sandals',
            'Slippers',
        ]);

        return [
            'parent_id' => null,
            'slug' => Str::slug($nameEn),
            'name' => [
                'az' => $nameEn,
                'ru' => $nameEn,
                'en' => $nameEn,
            ],
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
