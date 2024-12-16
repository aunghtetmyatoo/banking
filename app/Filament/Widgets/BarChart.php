<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class BarChart extends ChartWidget
{
    protected static ?string $heading = 'Transfer';

    protected function getData(): array
    {
        $transactions = Transaction::get()
            ->groupBy(fn ($transaction) => $transaction->created_at->format('M'));

        $transferData = array_fill(0, 12, 0);

        foreach ($transactions as $month => $monthlyTransactions) {
            $monthIndex = (int) date('m', strtotime($month)) - 1; // Convert month to zero-based index
            foreach ($monthlyTransactions as $transaction) {
                switch ($transaction->type) {
                    case TransactionType::TRANSFER:
                        $transferData[$monthIndex] += 1;
                        break;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transfer',
                    'data' => $transferData,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'fill' => false,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
