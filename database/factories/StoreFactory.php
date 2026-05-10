<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $stores = [
            ['name' => 'Baku Mall', 'city' => 'Baku'],
            ['name' => 'Ganjlik Mall', 'city' => 'Baku'],
            ['name' => '28 Mall', 'city' => 'Baku'],
            ['name' => 'Deniz Mall', 'city' => 'Baku'],
            ['name' => 'Port Baku Mall', 'city' => 'Baku'],
        ];

        $picked = $this->faker->unique()->randomElement($stores);
        $code = Str::upper(Str::slug($picked['name'], '_'));

        return [
            'code' => $code,
            'name' => $picked['name'],
            'city' => $picked['city'],
            'address' => null,
            'lat' => null,
            'lng' => null,
            'is_active' => true,
        ];
    }
}
