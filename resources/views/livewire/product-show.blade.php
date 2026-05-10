<div class="min-h-screen bg-white pb-40 md:pb-0">
    @php
        $imageUrls = collect([
            $product->showcase_image_url,
            $product->showcase_image_url,
            $product->showcase_image_url,
        ]);

        $compareAt = (float) ($variant?->compare_at_price ?? 0);
        $price = (float) ($variant?->price ?? 0);
        $hasDiscount = $variant !== null && $compareAt > 0 && $compareAt > $price;
        $discountPercent = $hasDiscount ? (int) round((1 - ($price / $compareAt)) * 100) : 0;

        $locale = app()->getLocale();
        $description = (string) ($product->description[$locale]
            ?? $product->description['az']
            ?? $product->description['en']
            ?? $product->description['ru']
            ?? '');
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-6">
            <a href="{{ url()->previous() ?: '/' }}" class="text-xs font-semibold tracking-wide text-slate-600 transition hover:text-slate-900">
                ← {{ __('common.back') }}
            </a>
            <div class="text-xs font-semibold tracking-wide text-slate-500">
                {{ $product->brand?->name_default ?? 'FLO' }}
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="lg:col-span-7" x-data="{ active: 0, images: @js($imageUrls->values()) }">
                <div class="-mx-4 overflow-hidden bg-white shadow-sm sm:mx-0 sm:rounded-2xl sm:border sm:border-slate-200">
                    <div class="relative aspect-square bg-slate-100">
                        <img :src="images[active]" alt="{{ $product->name_default }}" class="h-full w-full object-cover" loading="eager" />

                        @if ($hasDiscount)
                            <div class="absolute left-4 top-4 rounded-full bg-flo-orange-500 px-3 py-1.5 text-[11px] font-bold tracking-wide text-white shadow-lg">
                                -{{ $discountPercent }}%
                            </div>
                        @endif
                    </div>

                    @if ($imageUrls->count() > 1)
                        <div class="flex items-center justify-center gap-2 py-3 sm:hidden">
                            <template x-for="(img, idx) in images" :key="idx">
                                <button
                                    type="button"
                                    class="h-2 w-2 rounded-full transition"
                                    :class="active === idx ? 'bg-flo-orange-500' : 'bg-slate-300/80'"
                                    @click="active = idx"
                                    aria-label="Image"
                                ></button>
                            </template>
                        </div>

                        <div class="hidden grid-cols-5 gap-3 border-t border-slate-200 p-4 sm:grid sm:grid-cols-6">
                            @foreach ($imageUrls->take(12) as $idx => $url)
                                <button
                                    type="button"
                                    class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100 transition hover:border-slate-300"
                                    x-on:click="active = {{ (int) $idx }}"
                                >
                                    <img src="{{ $url }}" alt="" class="h-16 w-full object-cover" loading="lazy" />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="lg:sticky lg:top-6">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-6">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold tracking-wide text-slate-700">{{ $product->brand?->name_default ?? 'FLO' }}</p>
                                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                                    {{ $product->name_default }}
                                </h1>
                            </div>
                            <div class="shrink-0 text-right">
                                @if ($variant)
                                    <div class="text-2xl font-extrabold tracking-tight text-slate-950">
                                        ₼{{ number_format((float) $variant->price, 2) }}
                                    </div>
                                    @if ($hasDiscount)
                                        <div class="mt-1 text-sm font-semibold text-slate-500 line-through">
                                            ₼{{ number_format((float) $variant->compare_at_price, 2) }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-2xl font-extrabold tracking-tight text-slate-950">₼—</div>
                                @endif
                            </div>
                        </div>

                        @if ($variant?->sku)
                            <div class="mt-4 text-xs text-slate-500">
                                {{ __('common.sku') }}: <span class="font-semibold text-slate-700">{{ $variant->sku }}</span>
                            </div>
                        @endif

                        <div class="mt-6">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs font-bold tracking-wide text-slate-700">{{ __('common.color') }}</p>
                                <p class="text-xs text-slate-500">{{ $variant?->color_name_default }}</p>
                            </div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($product->variants as $v)
                                    <button
                                        type="button"
                                        wire:click="$set('variantId', {{ $v->id }})"
                                        class="inline-flex items-center gap-2 rounded-full border px-3 py-2 text-xs font-semibold tracking-wide transition
                                            {{ (int) $variantId === (int) $v->id ? 'border-flo-orange-500 bg-flo-orange-500/10 text-slate-950' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50' }}"
                                    >
                                        @if ($v->color_hex)
                                            <span class="h-2.5 w-2.5 rounded-full bg-slate-200 ring-1 ring-slate-300"></span>
                                        @else
                                            <span class="h-2.5 w-2.5 rounded-full bg-slate-200"></span>
                                        @endif
                                        {{ $v->color_name_default ?: __('common.variant') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs font-bold tracking-wide text-slate-700">{{ __('common.size') }}</p>
                                <p class="text-xs text-slate-500">
                                    @if ($size)
                                        {{ $size->size_label }}
                                    @endif
                                </p>
                            </div>

                            <div class="mt-3 grid grid-cols-5 gap-2">
                                @foreach (($variant?->sizes ?? collect()) as $s)
                                    @php
                                        $isSelected = (int) $sizeId === (int) $s->id;
                                        $isInStock = (int) $s->stock_total > 0;
                                    @endphp
                                    <button
                                        type="button"
                                        @if ($isInStock)
                                            wire:click="$set('sizeId', {{ $s->id }})"
                                        @else
                                            disabled
                                        @endif
                                        class="rounded-xl border px-2 py-2 text-center text-xs font-semibold tracking-wide transition
                                            {{ $isSelected ? 'border-slate-950 bg-slate-950 text-white' : ($isInStock ? 'border-slate-200 bg-white text-slate-800 hover:border-slate-300 hover:bg-slate-50' : 'border-slate-200 bg-slate-50 text-slate-400 line-through') }}"
                                    >
                                        <div>{{ $s->size_label }}</div>
                                        <div class="mt-1 text-[10px] {{ $isInStock ? 'text-emerald-700' : 'text-slate-400' }}">
                                            {{ $isInStock ? __('common.in_stock') : __('common.out_of_stock') }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 hidden items-center gap-3 md:flex">
                            @php
                                $canAddToCart = $size !== null && (int) $size->stock_total > 0;
                            @endphp
                            <button
                                type="button"
                                wire:click="addToCart"
                                @if (! $canAddToCart) disabled @endif
                                class="h-12 flex-1 rounded-2xl px-4 text-sm font-semibold tracking-wide transition
                                    {{ $canAddToCart ? 'bg-flo-orange-500 text-white hover:bg-flo-orange-600' : 'bg-slate-200 text-slate-500' }}"
                            >
                                {{ __('common.add_to_cart') }}
                            </button>

                            <button
                                type="button"
                                class="h-12 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold tracking-wide text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                            >
                                ♡
                            </button>
                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-700">
                            {{ __('common.free_shipping_over', ['amount' => '50']) }}
                        </div>

                        <div class="mt-6" x-data="{ open: 'description' }">
                            <div class="flex flex-wrap gap-2">
                                <button
                                    type="button"
                                    x-on:click="open = 'description'"
                                    class="rounded-full border px-4 py-2 text-xs font-semibold tracking-wide transition"
                                    :class="open === 'description' ? 'border-slate-950 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50'"
                                >
                                    {{ __('common.product_description') }}
                                </button>
                                <button
                                    type="button"
                                    x-on:click="open = 'delivery'"
                                    class="rounded-full border px-4 py-2 text-xs font-semibold tracking-wide transition"
                                    :class="open === 'delivery' ? 'border-slate-950 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50'"
                                >
                                    {{ __('common.delivery_info') }}
                                </button>
                                <button
                                    type="button"
                                    x-on:click="open = 'store'"
                                    class="rounded-full border px-4 py-2 text-xs font-semibold tracking-wide transition"
                                    :class="open === 'store' ? 'border-slate-950 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50'"
                                >
                                    {{ __('common.find_in_store') }}
                                </button>
                            </div>

                            <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-4">
                                <div x-show="open === 'description'" x-cloak class="text-sm leading-6 text-slate-700">
                                    {{ $description }}
                                </div>

                                <div x-show="open === 'delivery'" x-cloak class="space-y-2 text-sm text-slate-700">
                                    <div>{{ __('common.delivery_line_1') }}</div>
                                    <div>{{ __('common.delivery_line_2') }}</div>
                                    <div>{{ __('common.delivery_line_3') }}</div>
                                </div>

                                <div x-show="open === 'store'" x-cloak>
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                        <button
                                            type="button"
                                            wire:click="checkBakuMallStock"
                                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold tracking-wide text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                                        >
                                            {{ __('common.check_baku_mall') }}
                                        </button>
                                        <div class="flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                            {{ $bakuMallStockMessage ?? __('common.select_size_and_check') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $canAddToCart = $size !== null && (int) $size->stock_total > 0;
    @endphp

    <div class="fixed inset-x-0 bottom-16 z-[60] border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur md:hidden">
        <div class="mx-auto flex max-w-7xl items-center gap-3">
            <div class="min-w-0">
                <div class="text-[11px] font-semibold tracking-wide text-slate-500">{{ __('common.cart') }}</div>
                <div class="text-lg font-extrabold tracking-tight text-slate-950">
                    @if ($variant)
                        ₼{{ number_format((float) $variant->price, 2) }}
                    @else
                        ₼—
                    @endif
                </div>
            </div>

            <button
                type="button"
                wire:click="addToCart"
                @if (! $canAddToCart) disabled @endif
                class="h-12 flex-1 rounded-2xl px-4 text-sm font-semibold tracking-wide transition
                    {{ $canAddToCart ? 'bg-flo-orange-500 text-white hover:bg-flo-orange-600' : 'bg-slate-200 text-slate-500' }}"
            >
                Səbətə at
            </button>
        </div>
    </div>

</div>
