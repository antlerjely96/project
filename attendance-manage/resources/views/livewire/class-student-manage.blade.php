<div>
    {{-- Success is as dangerous as failure. --}}
    @include('livewire.header')

    {{--    Add Class Student Button Open Modal--}}
    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

{{--    Class Student Table--}}
    <x-card>
        <x-table :headers="$headers" :rows="$classes" :sortBy="$sortBy" with-pagination>
            @scope('actions', $class)
            <x-button icon="o-pencil" wire:click="edit({{ $class->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-trash" wire:click="delete({{ $class->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    {{--    Classes Modal--}}
    <x-modal wire:model="classModal" title="Add a Class" separator>
        <x-form wire:submit="save">
            <x-select
                label="School year"
                wire:model="form.school_year_id"
                :options="$schoolYears"
                placeholder="Select a school year"
                placeholder-value="0"
            />
            <x-select
                label="Major"
                wire:model="form.major_id"
                :options="$majors"
                placeholder="Select a major"
                placeholder-value="0"
            />
            <x-input label="Class name" wire:model="form.name" />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.classModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
