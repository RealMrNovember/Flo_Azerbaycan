<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleFromSession
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = (string) $request->session()->get('locale', config('app.locale', 'az'));
        $locale = strtolower($locale);

        if (! in_array($locale, ['az', 'ru', 'en'], true)) {
            $locale = 'az';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}

