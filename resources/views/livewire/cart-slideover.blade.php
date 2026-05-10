<div>
    <div
        class="fixed inset-0 z-50 transition {{ $isOpen ? '' : 'pointer-events-none' }}"
        aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
    >
        <div
            class="absolute inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity {{ $isOpen ? 'opacity-100' : 'opacity-0' }}"
            wire:click="close"
        ></div>

        <div class="absolute inset-x-0 bottom-0 flex w-full items-end md:inset-y-0 md:right-0 md:bottom-auto md:w-96 md:items-stretch">
            <div
                class="relative h-[85vh] w-full transition-transform duration-300 {{ $isOpen ? 'translate-y-0 md:translate-x-0' : 'translate-y-full md:translate-x-full' }} md:h-full"
            >
                <div class="flex h-full flex-col overflow-hidden rounded-t-3xl border-t border-slate-200 bg-white shadow-2xl md:rounded-none md:border-l md:border-t-0 md:border-slate-200">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 md:px-6 md:py-5">
                        <div>
                            <p class="text-[11px] font-semibold tracking-wider text-slate-500">{{ __('common.cart') }}</p>
                            <h3 class="mt-1 text-xl font-semibold tracking-tight text-slate-950">{{ __('common.your_cart') }}</h3>
                        </div>
                        <button
                            type="button"
                            wire:click="close"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-xs font-semibold tracking-wide text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                        >
                            ✕
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto px-4 pb-6 md:px-6">
                        @if ($items->isEmpty())
                            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                                {{ __('common.cart_empty_detail') }}
                            </div>
                        @else
                            <div class="mt-6 space-y-4">
                                @foreach ($items as $item)
                                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                        <div class="h-20 w-20 overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                            <img
                                                src="{{ $item['product']->showcase_image_url }}"
                                                alt=""
                                                class="h-full w-full object-cover"
                                                loading="lazy"
                                            />
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold text-slate-950">{{ $item['name'] }}</p>
                                                    <p class="mt-1 text-xs text-slate-600">
                                                        {{ $item['brand'] ?? 'FLO' }} · {{ $item['color'] }} · {{ __('common.size') }}: {{ $item['size'] }}
                                                    </p>
                                                </div>

                                                <button
                                                    type="button"
                                                    wire:click="remove({{ $item['size_id'] }})"
                                                    class="shrink-0 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-[11px] font-semibold tracking-wide text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                                                >
                                                    {{ __('common.remove') }}
                                                </button>
                                            </div>

                                            <div class="mt-3 flex items-end justify-between">
                                                <div class="text-xs text-slate-600">
                                                    {{ __('common.quantity') }}: <span class="font-semibold text-slate-900">{{ $item['qty'] }}</span>
                                                </div>
                                                <div class="text-sm font-semibold text-slate-950">
                                                    ₼{{ number_format((float) ($item['price'] * $item['qty']), 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-200 bg-white px-4 py-4 md:px-6 md:py-5">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">{{ __('common.subtotal') }}</span>
                            <span class="font-semibold text-slate-950">₼{{ number_format((float) $subtotal, 2) }}</span>
                        </div>
                        <button
                            type="button"
                            class="mt-4 h-12 w-full rounded-2xl bg-flo-orange-500 px-4 text-sm font-semibold tracking-wide text-white transition hover:bg-flo-orange-600"
                        >
                            {{ __('common.checkout') }}
                        </button>
                        <p class="mt-3 text-[11px] leading-4 text-slate-500">
                            {{ __('common.checkout_note') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
