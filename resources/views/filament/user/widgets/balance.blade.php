<?php

use App\Models\SubAgent;
use Filament\Facades\Filament;

$authUser = auth()->guard('user')->user();
$show = true;

$balance = $authUser->balance;

?>

@if ($show)
    <x-heroicon-o-currency-dollar class="w-5 h-5 md:inline" />
    <span x-data="{ open: false }"
        class="inline-flex items-center gap-1 p-3 text-sm border rounded-md border:bg-gray-100 dark:border-gray-700">

        <span x-show="open">
            {{ $balance }}
        </span>
        <span x-show="!open">
            ****
        </span>
        <span class="inline w-3 h-3 cursor-pointer md:w-5 md:h-5">
            <x-heroicon-o-eye x-on:click="open = true" x-show="!open" />
            <x-heroicon-o-eye-slash x-on:click="open = false" x-show="open" />
        </span>
    </span>
@endif
