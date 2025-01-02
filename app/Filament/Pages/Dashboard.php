<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BarChart;
use App\Filament\Widgets\DoughnutChart;
use App\Filament\Widgets\LineChart;
use App\Filament\Widgets\PieChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?int $navigationSort = -10;

    public function getWidgets(): array
    {
        $widgets = [
            BarChart::make(),
            LineChart::make(),
            // PieChart::make(),
            DoughnutChart::make(),
        ];

        return $widgets;
    }
}
