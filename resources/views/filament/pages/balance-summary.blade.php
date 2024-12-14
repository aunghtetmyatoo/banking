<?php

use App\Models\SystemBalance;
use App\Models\User;

$systemBalance = SystemBalance::first()->balance;
$userBalance = User::sum('balance');
$totalBalance = $systemBalance + $userBalance;

?>

<x-filament-panels::page>
    <div class="flex flex-col justify-between md:flex-row gap-x-3 md:gap-x-12">
        <div
            class="flex flex-col w-full *:py-2 *:inline-flex *:justify-between *:border-b gap-y-5 *:border-b-gray-600 *:dark:border-b-gray-600 *:px-2">
            <div>
                <span>{{ __('System Balance') }}</span> {{ number_format($systemBalance) }}
            </div>
            <div>
                <span>{{ __('User Balance') }}</span> {{ number_format($userBalance) }}
            </div>
            <div class="font-bold border-none text-primary-200 dark:text-primary-500">
                <b>{{ __('Total balance') }}</b> {{ number_format($totalBalance) }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
