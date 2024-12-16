<?php

namespace App\Filament\User\Widgets;

use App\Enums\TransactionType;
use Filament\Widgets\ChartWidget;

class LineChart extends ChartWidget
{
    protected static ?string $heading = 'Transactions';

    protected function getData(): array
    {
        $user = auth()->guard('user')->user();

        $transactions = $user->allTransactions()
            ->groupBy(fn ($transaction) => $transaction->created_at->format('M'));

        $depositData = array_fill(0, 12, 0);
        $withdrawData = array_fill(0, 12, 0);
        $transferData = array_fill(0, 12, 0);

        foreach ($transactions as $month => $monthlyTransactions) {
            $monthIndex = (int) date('m', strtotime($month)) - 1; // Convert month to zero-based index
            foreach ($monthlyTransactions as $transaction) {
                switch ($transaction->type) {
                    case TransactionType::DEPOSIT:
                        $depositData[$monthIndex] += 1;
                        break;
                    case TransactionType::WITHDRAW:
                        $withdrawData[$monthIndex] += 1;
                        break;
                    case TransactionType::TRANSFER:
                        $transferData[$monthIndex] += 1;
                        break;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Deposit',
                    'data' => $depositData,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'fill' => false,
                ],
                [
                    'label' => 'Withdrawal',
                    'data' => $withdrawData,
                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FF6384',
                    'fill' => false,
                ],
                [
                    'label' => 'Transfer',
                    'data' => $transferData,
                    'backgroundColor' => '#FFCE56',
                    'borderColor' => '#FFCE56',
                    'fill' => false,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
