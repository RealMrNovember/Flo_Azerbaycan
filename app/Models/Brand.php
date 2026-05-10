<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'color_hex',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'bool',
    ];

    protected $appends = [
        'name_default',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function nameFor(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $name = is_array($this->name) ? $this->name : [];

        return (string) ($name[$locale] ?? $name['az'] ?? $name['en'] ?? $name['ru'] ?? '');
    }

    public function getNameDefaultAttribute(): string
    {
        return $this->nameFor();
    }
}
