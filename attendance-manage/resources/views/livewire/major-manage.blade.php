<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @include('livewire.header')

{{--    Add Major Button Open Modal--}}
    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

{{--  Major Table--}}
    <x-card>
        <x-table :headers="$headers" :rows="$majors" :sortBy="$sortBy" with-pagination>
            @scope('actions', $major)
            <x-button icon="o-pencil" wire:click="edit({{ $major->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-trash" wire:click="delete({{ $major->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

{{--    Major Modal--}}
    <x-modal wire:model="majorModal" title="Major information" separator>
        <x-form wire:submit="save">
            <x-input label="Major name" wire:model="form.name" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.majorModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
