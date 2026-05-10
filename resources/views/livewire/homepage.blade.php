<div>
    <section
        x-data="{
            active: 0,
            timer: null,
            slides: [
                { image: 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1600&q=80', title: '{{ __('common.hero_title_1') }}', subtitle: '{{ __('common.hero_subtitle_1') }}', cta: '{{ __('common.hero_cta_1') }}' },
                { image: 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1600&q=80', title: '{{ __('common.hero_title_2') }}', subtitle: '{{ __('common.hero_subtitle_2') }}', cta: '{{ __('common.hero_cta_2') }}' },
                { image: 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1600&q=80', title: '{{ __('common.hero_title_3') }}', subtitle: '{{ __('common.hero_subtitle_3') }}', cta: '{{ __('common.hero_cta_3') }}' },
            ],
            start() {
                this.stop();
                this.timer = setInterval(() => {
                    this.next();
                }, 5000);
            },
            next() {
                this.active = (this.active + 1) % this.slides.length;
            },
            prev() {
                this.active = (this.active - 1 + this.slides.length) % this.slides.length;
            },
            stop() {
                if (this.timer) clearInterval(this.timer);
                this.timer = null;
            }
        }"
        x-init="start()"
        @mouseenter="stop()"
        @mouseleave="start()"
        class="relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] w-screen overflow-hidden bg-white shadow-sm sm:left-auto sm:right-auto sm:ml-0 sm:mr-0 sm:w-full sm:rounded-2xl sm:border sm:border-gray-200"
    >
        <div class="relative">
            <template x-for="(slide, idx) in slides" :key="idx">
                <div
                    x-show="active === idx"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-[0.985]"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-400"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-[0.985]"
                    class="relative"
                >
                    <div class="relative aspect-[16/6] w-full bg-gray-100">
                        <img
                            :src="slide.image"
                            alt=""
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out"
                            :class="active === idx ? 'scale-[1.04]' : 'scale-100'"
                            loading="eager"
                        />
                        <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/25 to-transparent"></div>
                    </div>

                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full px-5 sm:px-8">
                            <div class="max-w-xl">
                                <p class="text-xs font-semibold tracking-wide text-white/85">
                                    {{ __('common.free_shipping_over', ['amount' => 500]) }}
                                </p>
                                <h2 class="mt-2 text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl" x-text="slide.title"></h2>
                                <p class="mt-2 text-sm text-white/85 sm:text-base" x-text="slide.subtitle"></p>
                                <div class="mt-5 flex items-center gap-3">
                                    <a
                                        href="#products"
                                        class="inline-flex items-center justify-center rounded-lg bg-[#ff7a00] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#ff7a00]/90"
                                        x-text="slide.cta"
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <button
                type="button"
                class="absolute left-4 top-1/2 hidden -translate-y-1/2 items-center justify-center rounded-full bg-white/10 px-3 py-3 text-white backdrop-blur-sm transition hover:bg-white/15 sm:inline-flex"
                @click="prev(); start()"
                aria-label="Previous"
            >
                ←
            </button>
            <button
                type="button"
                class="absolute right-4 top-1/2 hidden -translate-y-1/2 items-center justify-center rounded-full bg-white/10 px-3 py-3 text-white backdrop-blur-sm transition hover:bg-white/15 sm:inline-flex"
                @click="next(); start()"
                aria-label="Next"
            >
                →
            </button>

            <div class="absolute bottom-4 right-4 flex items-center gap-2">
                <template x-for="(slide, idx) in slides" :key="idx">
                    <button
                        type="button"
                        class="h-2 w-2 rounded-full transition"
                        :class="active === idx ? 'bg-[#ff7a00]' : 'bg-white/60 hover:bg-white/80'"
                        @click="active = idx"
                        aria-label="Slide"
                    ></button>
                </template>
            </div>
        </div>
    </section>

    <section id="categories" class="mt-6">
        <div class="grid grid-cols-4 gap-2 md:grid-cols-2 md:gap-4">
            @php
                $categoryCards = [
                    ['label' => __('common.women'), 'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=1200&q=80'],
                    ['label' => __('common.men'), 'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=1200&q=80'],
                    ['label' => __('common.kids'), 'image' => 'https://images.unsplash.com/photo-1514090458221-65bb69cf63e6?auto=format&fit=crop&w=1200&q=80'],
                    ['label' => __('common.sport'), 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=1200&q=80'],
                ];
            @endphp

            @foreach ($categoryCards as $card)
                <a href="#" class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
                    <img src="{{ $card['image'] }}" alt="" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-black/10"></div>

                    <div class="relative flex aspect-square flex-col items-center justify-center px-2 py-2 text-center md:min-h-[240px] md:px-5 md:py-8 lg:min-h-[280px]">
                        <div class="text-[11px] font-extrabold tracking-wide text-white md:text-3xl md:tracking-widest">
                            {{ $card['label'] }}
                        </div>
                        <div class="mt-2 hidden opacity-0 transition duration-300 group-hover:opacity-100 md:block">
                            <span class="inline-flex items-center justify-center rounded-full bg-[#ff7a00] px-6 py-2.5 text-sm font-semibold text-white shadow-lg">
                                {{ __('common.discover') }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <div class="rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-xl font-bold tracking-tight text-gray-900">{{ __('common.footer_categories') }}</h1>
                <p class="mt-1 text-sm text-gray-600">{{ __('common.search') }} · Livewire</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select
                    wire:model.live="sort"
                    class="h-11 rounded-lg border border-gray-200 bg-white px-3 text-sm outline-none transition focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/15"
                >
                    <option value="new">Yeni</option>
                    <option value="price_asc">Qiymət (artan)</option>
                    <option value="price_desc">Qiymət (azalan)</option>
                </select>

                <button
                    type="button"
                    wire:click="clearFilters"
                    class="h-11 rounded-lg border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    {{ __('common.reset_filters') }}
                </button>
            </div>
        </div>

        <div class="mt-5 grid gap-4 lg:grid-cols-2">
            <div class="flex gap-2 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-2 lg:flex-wrap lg:overflow-visible lg:pb-0">
                @foreach ($categories as $category)
                    <button
                        type="button"
                        wire:click="$set('categoryId', {{ $category->id }})"
                        class="h-11 whitespace-nowrap snap-start rounded-full border px-4 text-xs font-semibold transition
                            {{ (int) $categoryId === (int) $category->id ? 'border-[#ff7a00] bg-[#ff7a00] text-white' : 'border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:bg-gray-50' }}"
                    >
                        {{ $category->name_default }}
                    </button>
                @endforeach
            </div>

            <div class="flex gap-2 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-2 lg:flex-wrap lg:justify-end lg:overflow-visible lg:pb-0">
                @foreach ($brands as $brand)
                    <button
                        type="button"
                        wire:click="$set('brandId', {{ $brand->id }})"
                        class="h-11 whitespace-nowrap snap-start rounded-full border px-4 text-xs font-semibold transition
                            {{ (int) $brandId === (int) $brand->id ? 'border-[#ff7a00] bg-white text-[#ff7a00]' : 'border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:bg-gray-50' }}"
                    >
                        {{ $brand->name_default }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div id="products" class="mt-6">
        <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($products as $product)
                @php
                    $img = $product->showcase_image_url;
                    $price = (float) ($product->price_min ?? 0);
                    $old = $price > 0 ? $price * 1.25 : null;
                    $brandName = $product->brand?->name_default ?? 'FLO';
                @endphp

                <article class="group relative overflow-hidden rounded-xl border border-gray-100 bg-white transition hover:-translate-y-0.5 hover:shadow-lg">
                    <a href="/p/{{ $product->slug }}" class="absolute inset-0 z-10" aria-label="{{ $product->name_default }}"></a>
                    <div class="relative z-0">
                        <div class="relative aspect-[1/1] bg-white">
                            <img src="{{ $img }}" alt="{{ $product->name_default }}" class="h-full w-full object-contain p-3 sm:p-5" loading="lazy" />
                        </div>

                        <div class="px-3 pb-3 sm:px-4 sm:pb-4">
                            <div class="text-xs font-bold text-gray-900 sm:text-[14px]">
                                {{ $brandName }}
                            </div>

                            <h3 class="mt-1 line-clamp-2 min-h-[2.25rem] text-xs font-normal leading-4 text-gray-800 sm:text-[13px]">
                                {{ $product->name_default }}
                            </h3>

                            <div class="mt-3">
                                @if ($old)
                                    <div class="text-xs text-gray-400 line-through">₼{{ number_format((float) $old, 2) }}</div>
                                @endif
                                <div class="text-sm font-extrabold text-[#ff7a00] sm:text-[16px]">
                                    ₼{{ $price > 0 ? number_format($price, 2) : '—' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pointer-events-none absolute inset-x-4 bottom-4 opacity-0 transition group-hover:opacity-100">
                        <a
                            href="/p/{{ $product->slug }}"
                            class="pointer-events-auto relative z-20 flex h-11 w-full items-center justify-center rounded-lg bg-[#ff7a00] px-4 text-sm font-semibold text-white transition hover:bg-[#ff7a00]/90"
                        >
                            {{ __('common.add_to_cart') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

</div>
