<div>
    @include('livewire.header')
    <x-card>
        <x-form>
            <x-select
                label="Select major (do not choose a major if it is a general subject)"
                wire:model.live="selectedMajor"
                :options="$majors"
                placeholder="Select Major"
                placeholder-value="0"
            />
            <x-select
                label="Select school year"
                wire:model.live="selectedSchoolYear"
                :options="$schoolYears"
                placeholder="Select School year"
                placeholder-value="0"
            />
            <x-select
                label="Select class"
                wire:model.live="selectedClass"
                :options="$this->classes"
                placeholder="Select class"
                placeholder-value="0"
                wire:change="handleClassChange"
            />
        </x-form>

    </x-card>
    @if($divisionTable)
        <x-card>
            <x-button label="+" @click="$wire.showModal()" class="btn-primary" />
            <x-table :headers="$headers" :rows="$this->divisions" wire:model="divisionTable" with-pagination>
                @scope('actions', $division)
                <x-button icon="o-pencil" wire:click="edit({{ $division->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                <x-button icon="o-eye" wire:click="viewDetail({{ $division->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                @if($division->status == 'Active')
                    <x-button icon="s-stop-circle" wire:click="changeStatus({{ $division->id }})" spinner class="btn-ghost btn-sm text-red-500"/>
                @else
                    <x-button icon="m-play-circle" wire:click="changeStatus({{ $division->id }})" spinner class="btn-ghost btn-sm text-red-500"/>
                @endif
                @endscope
            </x-table>
        </x-card>
    @endif

    <x-modal wire:model="createDivisionModal" title="Division information" separator>
        <x-form wire:submit="save">
{{--            <x-input wire:model="form.admin_id" wire:value="{{ session()->get('user')->id }}" type="hidden"/>--}}
            <x-select
                label="Class"
                wire:model.live="selectedClass"
                :options="$this->classes"
                placeholder="Select class"
                placeholder-value="0"
            />
            <x-select
                label="Subject"
                wire:model="selectedSubject"
                :options="$this->subjects"
                placeholder="Select Subject"
                placeholder-value="0"
            />
            <x-select
                label="Instructor"
                wire:model.live="selectedInstructor"
                :options="$this->instructors"
                placeholder="Select instructor"
                placeholder-value="0"
            />
            <x-input label="Time each day" wire:model="form.time_day"/>
            <x-datetime label="Start date" wire:model="form.start_date" type="date" min="{{\Carbon\Carbon::now()->toDateString()}}"/>
            <table>
                <tr>
                    <td>
                        <x-checkbox label="Monday" wire:model.live="form.day_of_week.1" value="1"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[1]) && $form->day_of_week[1])
                            <x-datetime label="Start time" wire:model="form.start_time.1" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <x-checkbox label="Tuesday" wire:model.live="form.day_of_week.2" value="2"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[2]) && $form->day_of_week[2])
                            <x-datetime label="Start time" wire:model="form.start_time.2" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <x-checkbox label="Wednesday" wire:model.live="form.day_of_week.3" value="3"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[3]) && $form->day_of_week[3])
                            <x-datetime label="Start time" wire:model="form.start_time.3" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <x-checkbox label="Thursday" wire:model.live="form.day_of_week.4" value="4"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[4]) && $form->day_of_week[4])
                            <x-datetime label="Start time" wire:model="form.start_time.4" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <x-checkbox label="Friday" wire:model.live="form.day_of_week.5" value="5"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[5]) && $form->day_of_week[5])
                            <x-datetime label="Start time" wire:model="form.start_time.5" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <x-checkbox label="Saturday" wire:model.live="form.day_of_week.6" value="6"/>
                    </td>
                    <td>
                        @if(isset($form->day_of_week[6]) && $form->day_of_week[6])
                            <x-datetime label="Start time" wire:model="form.start_time.1" type="time"/>
                        @else
                            <x-datetime label="Start time" type="time" disabled=""/>
                        @endif
                    </td>
                </tr>
            </table>
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.createDivisionModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-modal wire:model="editDivisionModal" title="Change instructor" separator>
        <x-form wire:submit="save">
            <x-select
                label="Instructor"
                wire:model="form.instructor_id"
                :options="$this->instructors"
                placeholder="Select instructor"
                placeholder-value="0"
            />
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.editDivisionModal = false"/>
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-modal wire:model="viewDetailDivisionModal" title="Planned Class Schedule" separator>
        <x-table :headers="$headersDetail" :rows="$divisionDetails">

        </x-table>
    </x-modal>
</div>
