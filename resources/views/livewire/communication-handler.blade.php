<div>
    <form wire:submit="create">

        {{ $this->form }}

        <x-filament::button class="mt-4" type="submit">
            Submit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
