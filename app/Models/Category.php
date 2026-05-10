<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'parent_id',
        'slug',
        'name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public array $translatable = [
        'name',
    ];

    protected $appends = [
        'name_default',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
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
}
