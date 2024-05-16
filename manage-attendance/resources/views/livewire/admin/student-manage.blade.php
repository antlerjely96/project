<div>
    {{-- The whole world belongs to you. --}}
    @include('livewire.header')

    <x-button label="+" @click="$wire.showModal()" class="btn-primary"/>

    <x-card>
        <x-table :headers="$headers" :rows="$students" :sort-by="$sortBy" with-pagination>
            @scope('actions', $student)
                <x-button icon="o-pencil" wire:click="edit({{ $student->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                <x-button icon="o-finger-print" wire:click="resetPassword({{ $student->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                @if($student->account->locked == 0)
                    <x-button icon="o-lock-closed" wire:click="lockedAccount({{ $student->id }})" spinner class="btn-ghost btn-sm text-red-500" />
                @else
                    <x-button icon="o-lock-open" wire:click="unlockedAccount({{ $student->id }})" spinner class="btn-ghost btn-sm text-red-500" />
                @endif
                <x-button icon="o-trash" wire:click="delete({{ $student['id'] }})" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="studentModal" title="Student information" separator>
        <x-form wire:submit="save">
            <x-select
                label="Major"
                wire:model.live="selectedMajor"
                :options="$majors"
                placeholder="Select Major"
                placeholder-value="0"
            />
            <x-select
                label="School year"
                wire:model.live="selectedSchoolYear"
                :options="$schoolYears"
                placeholder="Select School year"
                placeholder-value="0"
            />
            <x-select
                label="Class"
                wire:model="form.class_student_id"
                :options="$this->classes"
                placeholder="Select class"
                placeholder-value="0"
            />
            @if($this->editMode == false)
                <x-input label="Student code" wire:model="form.code" />
            @endif
            <x-input label="Student name" wire:model="form.name" />
            <x-input label="Phone" wire:model="form.phone"/>
            <x-input label="Address" wire:model="form.address" />
            <x-radio label="Gender" wire:model="form.gender" :options="
                [
                    ['id' => 'Male', 'name' => 'Male'],
                    ['id' => 'Female', 'name' => 'Female'],
                ]
            " />
            <x-datetime label="Birthday" wire:model="form.date_of_birth" icon="o-calendar" />
            @if($this->editMode == false)
                <x-input label="Email" wire:model="form.email" type="email"/>
            @endif
            {{--            <x-input label="Password" wire:model="form.password" type="password"/>--}}
            {{--            <x-input label="Duration" wire:model="form.duration" />--}}
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.studentModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    @include('livewire.filter-drawer')
</div>
