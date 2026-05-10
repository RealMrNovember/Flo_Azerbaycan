<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Warehouse\Pages\Dashboard as WarehouseDashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

final class WarehousePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('warehouse')
            ->path('_disabled-warehouse')
            ->login()
            ->brandName('FLO (Disabled)')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->pages([
                WarehouseDashboard::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
