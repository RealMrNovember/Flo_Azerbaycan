<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class ProductVariant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'sku',
        'color_name',
        'color_hex',
        'barcode',
        'price',
        'compare_at_price',
        'is_active',
    ];

    protected $casts = [
        'color_name' => 'array',
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'bool',
    ];

    protected $appends = [
        'color_name_default',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(VariantSize::class, 'product_variant_id')->orderBy('size_value');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('variant-images')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif'])
            ->withResponsiveImages();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->quality(82)
            ->fit('crop', 640, 640)
            ->nonQueued();
    }

    public function colorNameFor(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $name = is_array($this->color_name) ? $this->color_name : [];

        return (string) ($name[$locale] ?? $name['az'] ?? $name['en'] ?? $name['ru'] ?? '');
    }

    public function getColorNameDefaultAttribute(): string
    {
        return $this->colorNameFor();
    }
}
