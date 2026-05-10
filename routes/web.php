<?php

use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    $locale = strtolower($locale);
    if (! in_array($locale, ['az', 'ru', 'en'], true)) {
        $locale = 'az';
    }

    session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');

Route::get('/', \App\Livewire\Homepage::class)->name('home');

Route::get('/p/{slug}', \App\Livewire\ProductShow::class)->name('product.show');

Route::get('/categories', \App\Livewire\Categories::class)->name('categories');

Route::get('/profile', \App\Livewire\Profile::class)->name('profile');
