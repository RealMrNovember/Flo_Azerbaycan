<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addNamespace('layouts', resource_path('views/layouts'));

        if (! $this->app->runningInConsole()) {
            $locale = (string) session()->get('locale', 'az');
            if (! in_array($locale, ['az', 'ru', 'en'], true)) {
                $locale = 'az';
            }

            app()->setLocale($locale);
        }
    }
}
