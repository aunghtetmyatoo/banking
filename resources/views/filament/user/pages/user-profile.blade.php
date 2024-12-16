<?php

$user = auth()->guard('user')->user();

?>

<x-filament-panels::page>
    <div class="flex flex-col justify-between md:flex-row gap-x-3 md:gap-x-12">
        <div
            class="flex flex-col w-full *:py-2 *:inline-flex *:justify-between *:border-b gap-y-5 *:border-b-gray-600 *:dark:border-b-gray-600 *:px-2">
            <div>
                <span>{{ __('Name') }}</span> {{ $user->name }}
            </div>
            <div>
                <span>{{ __('Username') }}</span> {{ $user->username }}
            </div>
            <div>
                <span>{{ __('Email') }}</span> {{ $user->email }}
            </div>
            <div>
                <span>{{ __('Mobile') }}</span> {{ $user->mobile }}
            </div>
            <div>
                <span>{{ __('Banking Number') }}</span> {{ $user->banking_number }}
            </div>
            <div>
                <span>{{ __('Balance') }}</span> {{ $user->balance }}
            </div>
            <div>
                <span>{{ __('State') }}</span> {{ $user->state->name }}
            </div>
            <div>
                <span>{{ __('Township') }}</span> {{ $user->township->name }}
            </div>
            <div>
                <span>{{ __('Address') }}</span> {{ $user->address }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
