<div>
    {{-- The Master doesn't talk, he acts. --}}
    @include('livewire.header')

    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

    <x-card>
        <x-table :headers="$headers" :rows="$schoolYears" :sortBy="$sortBy" with-pagination>
            @scope('actions', $schoolYear)
            <x-button icon="o-pencil" wire:click="edit({{ $schoolYear->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-trash" wire:click="delete({{ $schoolYear->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="schoolYearModal" title="School year information" separator>
        <x-form wire:submit="save">
            <x-input label="School year name" wire:model="form.name" />
            <x-input label="Start year" wire:model="form.start_year" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.schoolYearModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
