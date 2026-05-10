<?php

declare(strict_types=1);

namespace App\Filament\Store\Pages;

use App\Filament\Store\Widgets\StoreTodayOrders;
use Filament\Pages\Dashboard as BaseDashboard;

final class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $title = 'Store Dashboard';

    public function getWidgets(): array
    {
        return [
            StoreTodayOrders::class,
        ];
    }
}

