<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use App\Models\StoreInventory;
use App\Models\VariantSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

final class ShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $bakuMall = Store::query()->firstOrCreate(
            ['code' => 'BAKUMALL'],
            [
                'name' => 'Baku Mall',
                'city' => 'Bakı',
                'address' => 'Baku Mall, Bakı',
                'is_active' => true,
            ],
        );

        $brands = [
            'Kinetix' => '#FF6A00',
            'Nike' => '#111827',
            'Polaris' => '#2F79FF',
        ];

        $brandModels = [];
        foreach ($brands as $brandName => $hex) {
            $brandModels[$brandName] = Brand::query()->firstOrCreate(
                ['slug' => Str::slug($brandName)],
                [
                    'name' => [
                        'az' => $brandName,
                        'ru' => $brandName,
                        'en' => $brandName,
                    ],
                    'color_hex' => $hex,
                    'is_active' => true,
                ],
            );
        }

        $categoryTree = [
            'qadin' => [
                'name' => ['az' => 'QADIN', 'ru' => 'ЖЕНСКОЕ', 'en' => 'WOMEN'],
                'children' => [
                    'sneaker' => ['az' => 'Sneaker', 'ru' => 'Кроссовки', 'en' => 'Sneakers'],
                    'gundelik' => ['az' => 'Gündəlik', 'ru' => 'Повседневные', 'en' => 'Casual'],
                    'bot' => ['az' => 'Bot', 'ru' => 'Ботинки', 'en' => 'Boots'],
                ],
            ],
            'kisi' => [
                'name' => ['az' => 'KİŞİ', 'ru' => 'МУЖСКОЕ', 'en' => 'MEN'],
                'children' => [
                    'sneaker' => ['az' => 'Sneaker', 'ru' => 'Кроссовки', 'en' => 'Sneakers'],
                    'gundelik' => ['az' => 'Gündəlik', 'ru' => 'Повседневные', 'en' => 'Casual'],
                    'bot' => ['az' => 'Bot', 'ru' => 'Ботинки', 'en' => 'Boots'],
                ],
            ],
            'usaq' => [
                'name' => ['az' => 'UŞAQ', 'ru' => 'ДЕТСКОЕ', 'en' => 'KIDS'],
                'children' => [
                    'sneaker' => ['az' => 'Sneaker', 'ru' => 'Кроссовки', 'en' => 'Sneakers'],
                    'idman' => ['az' => 'İdman', 'ru' => 'Спорт', 'en' => 'Sport'],
                ],
            ],
            'idman' => [
                'name' => ['az' => 'İDMAN', 'ru' => 'СПОРТ', 'en' => 'SPORT'],
                'children' => [
                    'qacis' => ['az' => 'Qaçış', 'ru' => 'Бег', 'en' => 'Running'],
                    'telim' => ['az' => 'Təlim', 'ru' => 'Тренировки', 'en' => 'Training'],
                ],
            ],
        ];

        $categoryModels = [];
        $sort = 0;
        foreach ($categoryTree as $parentSlug => $parent) {
            $sort++;
            $parentModel = Category::query()->firstOrCreate(
                ['slug' => $parentSlug],
                [
                    'parent_id' => null,
                    'name' => $parent['name'],
                    'sort_order' => $sort,
                    'is_active' => true,
                ],
            );
            $categoryModels[$parentSlug] = $parentModel;

            $childSort = 0;
            foreach ($parent['children'] as $childSlug => $childName) {
                $childSort++;
                $fullSlug = $parentSlug.'-'.$childSlug;
                $categoryModels[$fullSlug] = Category::query()->firstOrCreate(
                    ['slug' => $fullSlug],
                    [
                        'parent_id' => $parentModel->id,
                        'name' => $childName,
                        'sort_order' => $childSort,
                        'is_active' => true,
                    ],
                );
            }
        }

        $heroSources = [
            'hero-1.jpg' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04',
            'hero-2.jpg' => 'https://images.unsplash.com/photo-1552346154-21d32810baa3',
        ];

        foreach ($heroSources as $fileName => $url) {
            $targetPath = 'banners/'.$fileName;
            try {
                $response = Http::retry(2, 500)
                    ->timeout(60)
                    ->get($url.'?auto=format&fit=crop&w=2200&q=80');

                if ($response->successful()) {
                    Storage::disk('public')->put($targetPath, $response->body());
                } elseif ($fileName === 'hero-2.jpg') {
                    $fallback = Http::retry(2, 500)
                        ->timeout(60)
                        ->get('https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=2200&q=80');

                    if ($fallback->successful()) {
                        Storage::disk('public')->put($targetPath, $fallback->body());
                    }

                    if (! Storage::disk('public')->exists($targetPath) && Storage::disk('public')->exists('banners/hero-1.jpg')) {
                        Storage::disk('public')->copy('banners/hero-1.jpg', $targetPath);
                    }
                }
            } catch (Throwable) {
            }
        }

        $productSources = [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
            'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2',
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a',
            'https://images.unsplash.com/photo-1608231387042-66d1773070a5',
            'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519',
        ];

        $products = [
            ['brand' => 'Nike', 'type' => 'Sneaker', 'gender' => 'men', 'name' => 'Air Court Low', 'cats' => ['kisi', 'kisi-sneaker']],
            ['brand' => 'Nike', 'type' => 'Running Shoe', 'gender' => 'men', 'name' => 'Flow Runner', 'cats' => ['idman', 'idman-qacis']],
            ['brand' => 'Nike', 'type' => 'Sneaker', 'gender' => 'women', 'name' => 'City Minimal', 'cats' => ['qadin', 'qadin-sneaker']],
            ['brand' => 'Kinetix', 'type' => 'Sneaker', 'gender' => 'unisex', 'name' => 'Kinetix Pulse', 'cats' => ['idman', 'idman-telim']],
            ['brand' => 'Kinetix', 'type' => 'Casual', 'gender' => 'men', 'name' => 'Trail Lite', 'cats' => ['kisi', 'kisi-gundelik']],
            ['brand' => 'Kinetix', 'type' => 'Boot', 'gender' => 'women', 'name' => 'Winter Edge', 'cats' => ['qadin', 'qadin-bot']],
            ['brand' => 'Polaris', 'type' => 'Sneaker', 'gender' => 'unisex', 'name' => 'Studio Runner', 'cats' => ['idman', 'idman-qacis']],
            ['brand' => 'Polaris', 'type' => 'Sneaker', 'gender' => 'men', 'name' => 'Street Shell', 'cats' => ['kisi', 'kisi-sneaker']],
            ['brand' => 'Polaris', 'type' => 'Boot', 'gender' => 'men', 'name' => 'Outdoor Boot', 'cats' => ['kisi', 'kisi-bot']],
            ['brand' => 'Nike', 'type' => 'Sneaker', 'gender' => 'unisex', 'name' => 'Shadow High', 'cats' => ['idman', 'idman-telim']],
            ['brand' => 'Nike', 'type' => 'Sneaker', 'gender' => 'women', 'name' => 'Samba Light', 'cats' => ['qadin', 'qadin-sneaker']],
            ['brand' => 'Kinetix', 'type' => 'Running Shoe', 'gender' => 'unisex', 'name' => 'Sprint', 'cats' => ['idman', 'idman-qacis']],
            ['brand' => 'Polaris', 'type' => 'Casual', 'gender' => 'unisex', 'name' => 'Terra Grip', 'cats' => ['idman', 'idman-telim']],
            ['brand' => 'Kinetix', 'type' => 'Sneaker', 'gender' => 'men', 'name' => 'Black Edition', 'cats' => ['kisi', 'kisi-sneaker']],
            ['brand' => 'Polaris', 'type' => 'Sneaker', 'gender' => 'women', 'name' => 'Cream Green', 'cats' => ['qadin', 'qadin-sneaker']],
            ['brand' => 'Polaris', 'type' => 'Sneaker', 'gender' => 'kids', 'name' => 'Mini Runner', 'cats' => ['usaq', 'usaq-sneaker']],
        ];

        $colors = [
            ['name' => ['az' => 'Qara', 'ru' => 'Чёрный', 'en' => 'Black'], 'hex' => '#0B0F19'],
            ['name' => ['az' => 'Ağ', 'ru' => 'Белый', 'en' => 'White'], 'hex' => '#F8FAFC'],
            ['name' => ['az' => 'Mavi', 'ru' => 'Синий', 'en' => 'Blue'], 'hex' => '#2F79FF'],
            ['name' => ['az' => 'Narıncı', 'ru' => 'Оранжевый', 'en' => 'Orange'], 'hex' => '#FF6A00'],
        ];

        foreach ($products as $i => $p) {
            $slug = Str::slug($p['brand'].' '.$p['name']).'-'.Str::lower(Str::random(6));

            $descriptionAz = 'Yüngül gündəlik rahatlıq üçün dizayn edilib: nəfəs alan üst hissə, yumşaq içlik və dayanıqlı altlıq. Şəhər ritminə uyğun — həm iş günündə, həm də həftəsonu kombinlərində ideal seçimdir.';
            $descriptionRu = 'Создано для комфорта на каждый день: дышащий верх, мягкая стелька и устойчивый протектор. Отличный выбор для городского ритма — и в будни, и на выходные.';
            $descriptionEn = 'Built for everyday comfort: breathable upper, soft insole, and durable outsole. A versatile pick for city life—weekday to weekend.';

            $product = Product::query()->create([
                'brand_id' => $brandModels[$p['brand']]->id,
                'slug' => $slug,
                'name' => [
                    'az' => $p['name'],
                    'ru' => $p['name'],
                    'en' => $p['name'],
                ],
                'description' => [
                    'az' => $descriptionAz,
                    'ru' => $descriptionRu,
                    'en' => $descriptionEn,
                ],
                'product_type' => $p['type'],
                'gender' => $p['gender'],
                'is_active' => true,
            ]);

            $product->categories()->sync(
                collect($p['cats'])->map(fn (string $c) => $categoryModels[$c]->id)->all(),
            );

            $selected = Arr::random($productSources, 2);
            $selected = is_array($selected) ? $selected : [$selected];

            $product->clearMediaCollection('product-gallery');
            foreach ($selected as $src) {
                try {
                    $product
                        ->addMediaFromUrl($src.'?auto=format&fit=crop&w=1600&q=80')
                        ->toMediaCollection('product-gallery');
                } catch (Throwable) {
                }
            }

            $variantColors = Arr::random($colors, 2);
            foreach ($variantColors as $vIndex => $c) {
                $price = (float) random_int(6999, 22999) / 100;
                $hasCompareAt = random_int(0, 100) < 55;
                $compareAt = $hasCompareAt ? round($price * ((float) random_int(120, 160) / 100), 2) : null;

                $variant = ProductVariant::query()->create([
                    'product_id' => $product->id,
                    'sku' => strtoupper(Str::slug($p['brand'].'-'.$p['name'].'-'.$vIndex)).'-'.strtoupper(Str::random(6)),
                    'color_name' => $c['name'],
                    'color_hex' => $c['hex'],
                    'barcode' => 'BRC'.random_int(1000000, 9999999),
                    'price' => $price,
                    'compare_at_price' => $compareAt,
                    'is_active' => true,
                ]);

                $sizes = match ($p['gender']) {
                    'kids' => [28, 29, 30, 31, 32, 33, 34, 35],
                    default => [36, 37, 38, 39, 40, 41, 42, 43, 44, 45],
                };

                foreach ($sizes as $size) {
                    $sizeModel = VariantSize::query()->create([
                        'product_variant_id' => $variant->id,
                        'size_label' => (string) $size,
                        'size_value' => (float) $size,
                        'stock_total' => random_int(0, 24),
                        'is_active' => true,
                    ]);

                    StoreInventory::query()->updateOrCreate(
                        [
                            'store_id' => $bakuMall->id,
                            'variant_size_id' => $sizeModel->id,
                        ],
                        [
                            'stock' => min(random_int(0, 8), (int) $sizeModel->stock_total),
                        ],
                    );
                }
            }
        }
    }
}
