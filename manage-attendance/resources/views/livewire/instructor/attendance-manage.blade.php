<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    @include('livewire.header')

    <x-card>
        <x-form>
            <x-input label="Class" wire:model.live="selectedClass" />
            {{--            <x-input label="Status" wire:model="" />--}}
            <x-select
                label="Status"
                wire:model.live="selectedStatus"
                :options="
                    [
                        ['id' => 'Active', 'name' => 'Active'],
                        ['id' => 'Inactive', 'name' => 'Inactive'],
                    ]
                "/>
        </x-form>
    </x-card>

    <x-grid-component
        wire:model="selectedDivision"
        :items="$this->divisions"
        :columns="
            [
                ['id' => 'class', 'name' => 'Class'],
                ['id' => 'subject', 'name' => 'Subject'],
                ['id' => 'instructor', 'name' => 'Instructor'],
                ['id' => 'status', 'name' => 'Status'],
            ]
        "
    />
</div>
