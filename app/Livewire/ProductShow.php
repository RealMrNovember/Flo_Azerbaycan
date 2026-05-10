<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use App\Models\StoreInventory;
use App\Models\VariantSize;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProductShow extends Component
{
    public Product $product;

    public ?int $variantId = null;

    public ?int $sizeId = null;

    public ?string $bakuMallStockMessage = null;

    public function mount(string $slug): void
    {
        $this->product = Product::query()
            ->where('slug', $slug)
            ->with([
                'brand',
                'images',
                'variants' => fn ($q) => $q->where('is_active', true)->orderBy('id'),
                'variants.sizes' => fn ($q) => $q->where('is_active', true)->orderBy('size_value'),
                'variants.images',
            ])
            ->firstOrFail();

        $this->variantId = (int) ($this->product->variants->first()?->id ?? 0) ?: null;
        $this->sizeId = $this->firstAvailableSizeId($this->selectedVariant());
    }

    public function updatedVariantId(): void
    {
        $this->sizeId = $this->firstAvailableSizeId($this->selectedVariant());
        $this->bakuMallStockMessage = null;
    }

    public function updatedSizeId(): void
    {
        $this->bakuMallStockMessage = null;
    }

    public function selectedVariant(): ?ProductVariant
    {
        if ($this->variantId === null) {
            return null;
        }

        return $this->product->variants->firstWhere('id', $this->variantId);
    }

    public function selectedSize(): ?VariantSize
    {
        $variant = $this->selectedVariant();
        if ($variant === null || $this->sizeId === null) {
            return null;
        }

        return $variant->sizes->firstWhere('id', $this->sizeId);
    }

    public function firstAvailableSizeId(?ProductVariant $variant): ?int
    {
        if ($variant === null) {
            return null;
        }

        $inStock = $variant->sizes->first(fn (VariantSize $s): bool => $s->stock_total > 0);

        return (int) ($inStock?->id ?? 0) ?: null;
    }

    public function checkBakuMallStock(): void
    {
        if ($this->sizeId === null) {
            $this->bakuMallStockMessage = __('common.select_size_first');

            return;
        }

        $store = Store::query()->where('code', 'BAKUMALL')->first();
        if ($store === null) {
            $this->bakuMallStockMessage = __('common.store_stock_unknown');

            return;
        }

        $stock = (int) (StoreInventory::query()
            ->where('store_id', $store->id)
            ->where('variant_size_id', $this->sizeId)
            ->value('stock') ?? 0);

        $this->bakuMallStockMessage = $stock > 0
            ? __('common.store_stock_available', ['store' => $store->name, 'count' => $stock])
            : __('common.store_stock_unavailable', ['store' => $store->name]);
    }

    public function addToCart(): void
    {
        if ($this->variantId === null) {
            return;
        }

        if ($this->sizeId === null) {
            $this->sizeId = $this->firstAvailableSizeId($this->selectedVariant());
        }

        $size = $this->selectedSize();
        if ($size === null || $size->stock_total <= 0) {
            return;
        }

        $this->dispatch('cart:add', productId: $this->product->id, variantId: $this->variantId, sizeId: $this->sizeId);
    }

    public function render(): View
    {
        $variant = $this->selectedVariant();
        $size = $this->selectedSize();

        $images = collect();
        if ($variant !== null && $variant->images->isNotEmpty()) {
            $images = $variant->images;
        } elseif ($this->product->images->isNotEmpty()) {
            $images = $this->product->images;
        }

        return view('livewire.product-show', [
            'variant' => $variant,
            'size' => $size,
            'images' => $images,
        ]);
    }
}
