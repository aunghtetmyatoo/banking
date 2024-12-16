<?php

namespace App\Filament\User\Widgets;

use App\Enums\TransactionType;
use Filament\Widgets\ChartWidget;

class DoughnutChart extends ChartWidget
{
    protected static ?string $heading = 'Deposit / Withdraw';

    protected function getData(): array
    {
        $user = auth()->guard('user')->user();

        $allTransactions = $user->allTransactions();

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

    protected function getType(): string
    {
        return 'doughnut';
    }
}
