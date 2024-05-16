<div>
    {{-- Be like water. --}}
    @include('livewire.header')

    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

    <x-card>
        <x-table :headers="$headers" :rows="$subjects" :sortBy="$sortBy" with-pagination>
            @scope('actions', $subject)
            <x-button icon="o-pencil" wire:click="edit({{ $subject->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-trash" wire:click="delete({{ $subject->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    {{--  Modal--}}
    <x-modal wire:model="subjectModal" title="Subject information" separator>
        <x-form wire:submit="save">
            <x-select
                label="Major"
                wire:model="form.major_id"
                :options="$majors"
                placeholder="Select Major"
                placeholder-value="0"
            />
            <x-input label="Subject name" wire:model="form.name" />
            <x-input label="Duration" wire:model="form.duration" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.subjectModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
