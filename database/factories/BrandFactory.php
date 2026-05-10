<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $brands = [
            ['name' => 'Kinetix', 'color_hex' => '#111827'],
            ['name' => 'Lumberjack', 'color_hex' => '#111827'],
            ['name' => 'Polaris', 'color_hex' => '#111827'],
            ['name' => 'Nike', 'color_hex' => '#111111'],
            ['name' => 'adidas', 'color_hex' => '#111111'],
            ['name' => 'Puma', 'color_hex' => '#111111'],
            ['name' => 'Skechers', 'color_hex' => '#111111'],
            ['name' => 'New Balance', 'color_hex' => '#c8102e'],
            ['name' => 'Hummel', 'color_hex' => '#e11d48'],
            ['name' => 'Reebok', 'color_hex' => '#111111'],
            ['name' => 'Vans', 'color_hex' => '#d00000'],
            ['name' => 'Crocs', 'color_hex' => '#16a34a'],
            ['name' => 'Calvin Klein', 'color_hex' => '#111111'],
            ['name' => 'Vicco', 'color_hex' => '#111827'],
            ['name' => 'Dockers by Gerli', 'color_hex' => '#111827'],
            ['name' => 'U.S. Polo Assn.', 'color_hex' => '#1d4ed8'],
            ['name' => 'İgor', 'color_hex' => '#111827'],
            ['name' => 'İnci', 'color_hex' => '#111827'],
            ['name' => 'Nine West', 'color_hex' => '#111111'],
            ['name' => 'Lotto', 'color_hex' => '#0ea5e9'],
            ['name' => 'Slazenger', 'color_hex' => '#16a34a'],
        ];

        $picked = $this->faker->unique()->randomElement($brands);
        $name = (string) $picked['name'];

        return [
            'slug' => Str::slug($name),
            'name' => [
                'az' => $name,
                'ru' => $name,
                'en' => $name,
            ],
            'color_hex' => $picked['color_hex'],
            'is_active' => true,
        ];
    }
}
