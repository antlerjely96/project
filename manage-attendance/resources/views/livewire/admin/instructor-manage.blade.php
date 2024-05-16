<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @include('livewire.header')

    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

    <x-card>
        <x-table :headers="$headers" :rows="$instructors" :sortBy="$sortBy" with-pagination>
            @scope('actions', $instructor)
                <x-button icon="o-pencil" wire:click="edit({{ $instructor->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
{{--            <x-button icon="o-trash" wire:click="delete({{ $instructor['id'] }})" spinner class="btn-ghost btn-sm text-red-500" />--}}
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="instructorModal" title="Instructor information" separator>
        <x-form wire:submit="save">
            <x-select
                label="Major"
                wire:model="form.major_id"
                :options="$majors"
                placeholder="Select Major"
                placeholder-value="0"
            />
            <x-input label="Instructor name" wire:model="form.name" />
            <x-input label="Phone" wire:model="form.phone"/>
            @if($this->editMode == false)
                <x-input label="Email" wire:model="form.email" type="email"/>
            @endif
            {{--            <x-input label="Password" wire:model="form.password" type="password"/>--}}
            {{--            <x-input label="Duration" wire:model="form.duration" />--}}
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.instructorModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
