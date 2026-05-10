<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class Homepage extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $q = '';

    #[Url(history: true)]
    public ?int $brandId = null;

    #[Url(history: true)]
    public ?int $categoryId = null;

    #[Url(history: true)]
    public string $sort = 'new';

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingBrandId(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryId(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->q = '';
        $this->brandId = null;
        $this->categoryId = null;
        $this->sort = 'new';
        $this->resetPage();
    }

    public function render(): View
    {
        $products = Product::query()
            ->active()
            ->when($this->q !== '', function (Builder $query): void {
                $needle = mb_strtolower(trim($this->q));
                $query->where(function (Builder $q) use ($needle): void {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.az"))) LIKE ?', ["%{$needle}%"])
                        ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.ru"))) LIKE ?', ["%{$needle}%"])
                        ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.en"))) LIKE ?', ["%{$needle}%"]);
                });
            })
            ->when($this->brandId, fn (Builder $query) => $query->where('brand_id', $this->brandId))
            ->when($this->categoryId, function (Builder $query): void {
                $query->whereHas('categories', fn (Builder $q) => $q->whereKey($this->categoryId));
            })
            ->with(['brand', 'coverImage'])
            ->withMin(['variants as price_min' => fn (Builder $q) => $q->where('is_active', true)], 'price')
            ->withMax(['variants as price_max' => fn (Builder $q) => $q->where('is_active', true)], 'price')
            ->tap(function (Builder $query): void {
                match ($this->sort) {
                    'price_asc' => $query->orderBy('price_min'),
                    'price_desc' => $query->orderByDesc('price_min'),
                    default => $query->latest('id'),
                };
            })
            ->paginate(12);

        $brands = Brand::query()
            ->where('is_active', true)
            ->orderBy('slug')
            ->get(['id', 'name', 'slug']);

        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        return view('livewire.homepage', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
