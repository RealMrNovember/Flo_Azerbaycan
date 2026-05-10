<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;

final class SuperAdminSnapshot extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [];
    }
}

