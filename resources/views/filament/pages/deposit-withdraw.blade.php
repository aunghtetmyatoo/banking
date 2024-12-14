<x-filament-panels::page>
    <div class="flex flex-col justify-between md:flex-row gap-x-3 md:gap-x-12">
        <div class="flex flex-col w-1/2 gap-y-5">
            {{-- <div class="inline-flex justify-between p-2 font-bold">
                <b>{{ __('Partner') . ' ' . __('Balance') }}</b> {{ number_format($partnerBalance) }}
            </div>
            <div @class([
                'py-3 text-gray-100 dark:text-gray-800 rounded-lg px-4',
                'bg-red-500' => $difference < 0,
                'bg-warning-500' => $difference > 0,
                'bg-success-500' => $difference == 0,
            ])>
                <div class="inline-flex justify-between w-full py-4 font-bold text-md md:text-2xl md:justify-around">
                    <span>{{ __('Partner') . ' ' . __('Balance') }}</span>
                    <span>{{ $sign }}</span>
                    <span>{{ __('Total balance') }}</span>
                </div>
                @if ($difference)
                    <span
                        class="inline-flex flex-col w-full gap-3 p-3 text-gray-900 bg-white text-md md:text-lg dark:bg-gray-800 dark:text-gray-100">
                        <span class="inline-flex justify-between md:justify-around">
                            <span>{{ number_format($partnerBalance) }}</span>
                            <span>{{ $sign }}</span>
                            <span>{{ number_format($totalBalance) }}</span>
                        </span>
                        <span class="inline-flex items-center justify-center gap-4 text-sm align-middle">
                            <span>{{ __('Difference') }} : </span>
                            <span class="text-danger-600 dark:text-danger-400">{{ $difference }}</span>
                        </span>
                    </span>
                @endif
            </div> --}}
            <div class="form-container">
                <form wire:submit.prevent="submit">
                    {{ $this->form }}

                    <div class="pt-4">
                        <x-filament::button type="submit">
                            {{ __('Submit') }}
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-filament-panels::page>
