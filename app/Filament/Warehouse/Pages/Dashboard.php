<?php

declare(strict_types=1);

namespace App\Filament\Warehouse\Pages;

use App\Filament\Warehouse\Widgets\WarehousePendingTransfers;
use Filament\Pages\Dashboard as BaseDashboard;

final class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $title = 'Warehouse Dashboard';

    public function getWidgets(): array
    {
        return [
            WarehousePendingTransfers::class,
        ];
    }
}

