<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureWarehousePanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user === null || !method_exists($user, 'hasAnyRole')) {
            abort(403);
        }

        if (!$user->hasAnyRole(['Super Admin', 'Warehouse Staff'])) {
            abort(403);
        }

        return $next($request);
    }
}

