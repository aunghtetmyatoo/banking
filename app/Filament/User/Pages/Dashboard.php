<?php

namespace App\Filament\User\Pages;

use App\Filament\User\Widgets\BarChart;
use App\Filament\User\Widgets\DoughnutChart;
use App\Filament\User\Widgets\LineChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?int $navigationSort = -10;

    public function getWidgets(): array
    {
        $widgets = [
            BarChart::make(),
            LineChart::make(),
            DoughnutChart::make(),
        ];

        return $widgets;
    }
}
