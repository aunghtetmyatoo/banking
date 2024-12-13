<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionType implements HasLabel
{
    case DEPOSIT;
    case WITHDRAW;

    case TRANSFER;

    public function getLabel(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Deposit',
            self::WITHDRAW => 'Withdraw',
            self::TRANSFER => 'Transfer',
        };
    }

    public function getPrefix(): string
    {
        return match ($this) {
            self::DEPOSIT => 'DP',
            self::WITHDRAW => 'WD',
            self::TRANSFER => 'TF',
        };
    }
}
