<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Store\Pages\Dashboard as StoreDashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

final class StorePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('store')
            ->path('_disabled-store')
            ->login()
            ->brandName('FLO (Disabled)')
            ->colors([
                'primary' => Color::Orange,
            ])
            ->pages([
                StoreDashboard::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
