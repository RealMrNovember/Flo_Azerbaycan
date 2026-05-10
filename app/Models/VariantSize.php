<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class VariantSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'size_label',
        'size_value',
        'stock_total',
        'is_active',
    ];

    protected $casts = [
        'size_value' => 'decimal:2',
        'is_active' => 'bool',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function storeInventories(): HasMany
    {
        return $this->hasMany(StoreInventory::class);
    }
}
