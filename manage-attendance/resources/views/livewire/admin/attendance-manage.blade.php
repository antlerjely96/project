<div>
    {{-- Do your work, then step back. --}}
    @include('livewire.header')

    <x-card>
        <x-form>
            <x-input label="Class" wire:model="form.classes" />
            <x-input label="Status" wire:model="form.status" />
        </x-form>
    </x-card>
</div>
