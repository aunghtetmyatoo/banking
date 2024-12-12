<div class="flex flex-col items-center justify-center h-screen w-1/2 mx-auto">
    <div class="py-5">
        <span class="text-2xl"> {{ $this->getTitle() }}</span>
    </div>
    <div class="flex justify-center">
        <x-filament-panels::form wire:submit="submit" class="self-center w-full mx-5 sm:w-1/2 lg:w-1/3">
            {{ $this->form }}
            <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
        </x-filament-panels::form>
    </div>
</div>
