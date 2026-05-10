<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'city',
        'address',
        'lat',
        'lng',
        'is_active',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'is_active' => 'bool',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(StoreInventory::class);
    }
}
