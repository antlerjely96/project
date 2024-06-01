<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @include('livewire.header')

    <x-card>
        <x-table :headers="$headers" :rows="$instructors">
            @scope('actions', $instructor)
            <x-button icon="o-pencil" wire:click="edit({{ $instructor->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
            <x-button icon="o-key" wire:click="changePassword({{ $instructor->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="modalEdit">
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="form.name" />
            <x-input label="Phone" wire:model="form.phone"/>
            <x-select
                wire:model="form.major_id"
                label="Major"
                :options="$majors"
            />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modalEdit = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-modal wire:model="modalChangePassword" title="Change password" separator>
        <x-form wire:submit="save">
            <x-input label="Password" wire:model="form.password" type="password"/>
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modalChangePassword = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
