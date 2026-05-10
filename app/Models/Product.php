<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

final class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'brand_id',
        'slug',
        'name',
        'description',
        'product_type',
        'gender',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected $appends = [
        'name_default',
        'showcase_image_url',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_cover', true)->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-gallery')
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

    public function nameFor(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return (string) ($this->getTranslation('name', $locale)
            ?: $this->getTranslation('name', 'az')
            ?: $this->getTranslation('name', 'en')
            ?: $this->getTranslation('name', 'ru'));
    }

    public function getNameDefaultAttribute(): string
    {
        return $this->nameFor();
    }

    public function getShowcaseImageUrlAttribute(): string
    {
        $images = [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=600&q=80',
        ];

        $index = (int) $this->id % count($images);

        return $images[$index];
    }
}
