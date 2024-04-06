<div class="max-w-lg">
    <form wire:submit="create">
        {{ $this->form }}

        <hr class="my-4" />

        <x-filament::button type="submit">
            Submit
        </x-filament::button>
    </form>
</div>
