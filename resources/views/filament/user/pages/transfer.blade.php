<x-filament-panels::page>
    <div class="flex flex-col justify-between md:flex-row gap-x-3 md:gap-x-12">
        <div class="flex flex-col w-1/2 gap-y-5">
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
