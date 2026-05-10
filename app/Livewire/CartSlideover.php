<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\VariantSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

final class CartSlideover extends Component
{
    public bool $isOpen = false;

    #[On('cart:open')]
    public function open(): void
    {
        $this->isOpen = true;
    }

    #[On('cart:add')]
    public function add(int $productId, int $variantId, ?int $sizeId = null): void
    {
        $this->isOpen = true;

        if ($sizeId === null) {
            return;
        }

        $items = session()->get('cart.items', []);
        $key = (string) $sizeId;

        $items[$key] = [
            'size_id' => $sizeId,
            'qty' => (int) (($items[$key]['qty'] ?? 0) + 1),
        ];

        session()->put('cart.items', $items);
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function remove(int $sizeId): void
    {
        $items = session()->get('cart.items', []);
        unset($items[(string) $sizeId]);
        session()->put('cart.items', $items);
    }

    public function items(): Collection
    {
        $items = session()->get('cart.items', []);
        $sizeIds = collect(array_keys($items))->map(fn (string $id) => (int) $id)->values();

        $sizes = VariantSize::query()
            ->whereIn('id', $sizeIds)
            ->with([
                'variant',
                'variant.product',
                'variant.product.coverImage',
            ])
            ->get()
            ->keyBy('id');

        return $sizeIds->map(function (int $sizeId) use ($items, $sizes) {
            $size = $sizes->get($sizeId);
            if ($size === null) {
                return null;
            }

            $qty = (int) ($items[(string) $sizeId]['qty'] ?? 1);
            $variant = $size->variant;
            $product = $variant->product;

            return [
                'size_id' => $sizeId,
                'qty' => $qty,
                'product' => $product,
                'name' => $product->name_default,
                'brand' => $product->brand?->name_default,
                'color' => $variant->color_name_default,
                'size' => $size->size_label,
                'price' => (float) $variant->price,
            ];
        })->filter();
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum(fn (array $i) => $i['price'] * $i['qty']);
    }

    public function render(): View
    {
        return view('livewire.cart-slideover', [
            'items' => $this->items(),
            'subtotal' => $this->subtotal(),
        ]);
    }
}
