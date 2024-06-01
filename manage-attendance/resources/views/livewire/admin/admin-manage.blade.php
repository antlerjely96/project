<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @include('livewire.header')

    <x-card>
        <x-table :headers="$headers" :rows="$admins">
            @scope('actions', $admin)
            <x-button icon="o-pencil" wire:click="edit({{ $admin->id }})" spinner class="btn-ghost btn-sm text-green-500" />
            <x-button icon="o-key" wire:click="changePassword({{ $admin->id }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="modalEdit" title="Change information" separator>
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="form.name" />
            <x-input label="Phone" wire:model="form.phone" />
            <x-radio label="Gender" wire:model="form.gender" :options="
                [
                    ['id' => 'Male', 'name' => 'Male'],
                    ['id' => 'Female', 'name' => 'Female'],
                ]
            " />
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
