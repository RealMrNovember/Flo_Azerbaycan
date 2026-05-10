<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\SuperAdminSnapshot;
use Filament\Pages\Dashboard as BaseDashboard;

final class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $title = 'Admin Dashboard';

    public function getWidgets(): array
    {
        return [
            SuperAdminSnapshot::class,
        ];
    }
}

