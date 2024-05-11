<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @include('livewire.header')

    {{--    Add Major Button Open Modal--}}
    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

    {{--  School year Table--}}
    <x-card>
        <x-table :headers="$headers" :rows="$schoolYears" :sortBy="$sortBy" with-pagination>
            @scope('actions', $schoolYear)
            <x-button icon="o-pencil" wire:click="edit({{ $schoolYear->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-trash" wire:click="delete({{ $schoolYear->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    {{--    School_year Modal--}}
    <x-modal wire:model="schoolYearModal" title="Add a School year" separator>
        <x-form wire:submit="save">
            <x-input label="School year name" wire:model="form.name" />
            <x-input label="Start year" wire:model="form.start_year" />
            <x-input label="End year" wire:model="form.end_year" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.schoolYearModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
