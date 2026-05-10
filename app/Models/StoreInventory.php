<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StoreInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'variant_size_id',
        'stock',
    ];

    protected $casts = [
        'stock' => 'int',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function variantSize(): BelongsTo
    {
        return $this->belongsTo(VariantSize::class);
    }
}
