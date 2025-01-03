<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class DoughnutChart extends ChartWidget
{
    protected static ?string $heading = 'Deposit / Withdraw';

    protected function getData(): array
    {
        $allTransactions = Transaction::get();

        $depositCount = $allTransactions
            ->where('type', TransactionType::DEPOSIT)
            ->count();

        $withdrawCount = $allTransactions
            ->where('type', TransactionType::WITHDRAW)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Transactions',
                    'data' => [$depositCount, $withdrawCount],
                    'backgroundColor' => ['#36A2EB', '#FF6384'],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Deposit', 'Withdraw'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false, // Remove x-axis grid lines
                    ],
                    'ticks' => [
                        'display' => false, // Remove x-axis labels
                    ],
                ],
                'y' => [
                    'grid' => [
                        'display' => false, // Remove y-axis grid lines
                    ],
                    'ticks' => [
                        'display' => false, // Remove x-axis labels
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
