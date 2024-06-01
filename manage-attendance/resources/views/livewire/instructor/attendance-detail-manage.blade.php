<div>
    @include('livewire.header')

    <x-card>
        <table class="table">
            <tr>
                <td>Class: {{ $subjectDurations[0]->class_name }}</td>
                <td>Status: {{ $instructorAndStatus[0]->status }}</td>
                <td>Subject: {{ $subjectDurations[0]->subject_name }} </td>
                <td>Instructor: {{ $instructorAndStatus[0]->name }}</td>
            </tr>
            <tr>
                <td>Duration: {{ $subjectDurations[0]->duration }}</td>
                <td>Time Learned: {{ $subjectDurations[0]->total_time }} h</td>
                <td>Remaining duration: {{ $subjectDurations[0]->remaining_duration }} h </td>
                <td></td>
            </tr>
        </table>
    </x-card>


    <x-card>
        <x-tabs wire:model="selectedTab">
            <x-tab name="statistics-tab" label="Statistics" icon="o-presentation-chart-line">
                <x-table :headers="$headersAttendanceDetail" :rows="$attendanceDetails" />
            </x-tab>
            <x-tab name="attendances-tab" label="Attendances" icon="o-sparkles">
                <x-button label="+ Add attendance" @click="$wire.showModal()" class="btn-primary"/>
                <x-grid-detail-attendance :items="$countLessons" />
            </x-tab>
            <x-tab name="overview-tab" label="Overview" icon="o-sun" class="overflow-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Student code</th>
                        <th>Student name</th>
                        @foreach($countLessons as $countLesson)
                            <th>
                                {{$countLesson->attendance_date}} <br>
                                {{$countLesson->start_time}} - {{$countLesson->end_time}}
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{ $student->code }}
                            </td>
                            <td>
                                {{ $student->name }}
                            </td>
                            @foreach($attendanceStatusDetails as $student_id => $attendanceStatusDetail)
                                {{--                                    {{ dd($attendanceStatusDetail) }}--}}
                                @if($student->id == $student_id)
                                    @foreach($countLessons as $countLesson)
                                        @if(isset($attendanceStatusDetail[$countLesson->attendance_date]))
                                            <td @click="$wire.editStatus('{{$countLesson->attendance_date}}', {{$student_id}})" class="hover:bg-amber-200">
                                                @if($attendanceStatusDetail[$countLesson->attendance_date]['attendance_status'] == 'attended')
                                                    <span> - </span>
                                                @elseif($attendanceStatusDetail[$countLesson->attendance_date]['attendance_status'] == 'absences_without_permission')
                                                    <span> N </span>
                                                @elseif($attendanceStatusDetail[$countLesson->attendance_date]['attendance_status'] == 'late')
                                                    <span> L </span>
                                                @elseif($attendanceStatusDetail[$countLesson->attendance_date]['attendance_status'] == 'absences_with_permission')
                                                    <span> P </span>
                                                @endif
                                            </td>
                                        @else
                                            <td>
                                                CN
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-tab>
        </x-tabs>
    </x-card>

    <x-modal wire:model="modalAddAttendance" title="Add Attendances" separator class="w-screen">
        <x-card>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="4">Note:</th>
                </tr>
                <tr>
                    <td> -: Attended </td>
                    <td> N: Absences without permission </td>
                    <td> L: Late </td>
                    <td> P: Absences with permission </td>
                </tr>
                </thead>
            </table>
        </x-card>
        <x-card>
            <x-form wire:submit="save">
                <x-input label="Date" wire:model="form.attendance_date" placeholder="{{ \Carbon\Carbon::now()->toDateString() }}" readonly/>
                <x-select
                    label="Start time"
                    wire:model="form.start_time"
                    :options="[
                        ['id' => '08:00:00', 'name' => '08:00:00'],
                        ['id' => '09:00:00', 'name' => '09:00:00'],
                        ['id' => '10:00:00', 'name' => '10:00:00'],
                        ['id' => '11:00:00', 'name' => '11:00:00'],
                        ['id' => '13:30:00', 'name' => '13:30:00'],
                        ['id' => '14:30:00', 'name' => '14:30:00'],
                        ['id' => '15:30:00', 'name' => '15:30:00'],
                        ['id' => '16:30:00', 'name' => '16:30:00'],
                    ]"
                    placeholder="Select start time"
                />
                <x-select
                    label="End time"
                    wire:model="form.end_time"
                    :options="[
                        ['id' => '09:00:00', 'name' => '09:00:00'],
                        ['id' => '10:00:00', 'name' => '10:00:00'],
                        ['id' => '11:00:00', 'name' => '11:00:00'],
                        ['id' => '12:00:00', 'name' => '12:00:00'],
                        ['id' => '14:30:00', 'name' => '14:30:00'],
                        ['id' => '15:30:00', 'name' => '15:30:00'],
                        ['id' => '16:30:00', 'name' => '16:30:00'],
                        ['id' => '17:30:00', 'name' => '17:30:00'],
                    ]"
                    placeholder="Select end time"
                />
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th> - </th>
                        <th> N </th>
                        <th> L </th>
                        <th> P </th>
                        <th>Note</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{ $student->code }}
                            </td>
                            <td>
                                {{ $student->name }}
                            </td>
                            <td>
                                <input type="radio" wire:model="form.status.{{$student->id}}" class="radio radio-primary w-4 h-4" value="attended" checked />
                            </td>
                            <td>
                                <input type="radio" wire:model="form.status.{{$student->id}}" class="radio radio-primary w-4 h-4" value="absences_without_permission"/>
                            </td>
                            <td>
                                <input type="radio" wire:model="form.status.{{$student->id}}" class="radio radio-primary w-4 h-4" value="late"/>
                            </td>
                            <td>
                                <input type="radio" wire:model="form.status.{{$student->id}}" class="radio radio-primary w-4 h-4" value="absences_with_permission"/>
                            </td>
                            <td>
                                <x-input lable="Note" wire:model="form.note.{{$student->id}}"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modalAddAttendance = false"/>
                    <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>

    <x-modal wire:model="modalEditAttendance" title="Edit Attendances" separator class="w-screen">
        <x-card>
            <x-form wire:submit="update">
                <x-datetime label="Date" wire:model="form.attendance_date" max="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                <x-select
                    label="Start time"
                    wire:model="form.start_time"
                    :options="[
                        ['id' => '08:00:00', 'name' => '08:00:00'],
                        ['id' => '09:00:00', 'name' => '09:00:00'],
                        ['id' => '10:00:00', 'name' => '10:00:00'],
                        ['id' => '11:00:00', 'name' => '11:00:00'],
                        ['id' => '13:30:00', 'name' => '13:30:00'],
                        ['id' => '14:30:00', 'name' => '14:30:00'],
                        ['id' => '15:30:00', 'name' => '15:30:00'],
                        ['id' => '16:30:00', 'name' => '16:30:00'],
                    ]"
                    placeholder="Select start time"
                />
                <x-select
                    label="End time"
                    wire:model="form.end_time"
                    :options="[
                        ['id' => '09:00:00', 'name' => '09:00:00'],
                        ['id' => '10:00:00', 'name' => '10:00:00'],
                        ['id' => '11:00:00', 'name' => '11:00:00'],
                        ['id' => '12:00:00', 'name' => '12:00:00'],
                        ['id' => '14:30:00', 'name' => '14:30:00'],
                        ['id' => '15:30:00', 'name' => '15:30:00'],
                        ['id' => '16:30:00', 'name' => '16:30:00'],
                        ['id' => '17:30:00', 'name' => '17:30:00'],
                    ]"
                    placeholder="Select end time"
                />
                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modalEditAttendance = false"/>
                    <x-button label="Save" class="btn-primary" type="submit" spinner="update" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>

    <x-modal wire:model="modalEditStatus" title="Update Status" separator class="w-screen">
        <x-card>
            <x-form wire:submit="updateStatus">
                <x-select
                    label="Status"
                    wire:model="form.status.{{$this->student_id}}"
                    :options="[
                        ['id' => 'attended', 'name' => '-'],
                        ['id' => 'absences_without_permission', 'name' => 'N'],
                        ['id' => 'late', 'name' => 'L'],
                        ['id' => 'absences_with_permission', 'name' => 'P'],
                    ]"
                    placeholder="Select status"
                />
                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modalEditStatus = false"/>
                    <x-button label="Save" class="btn-primary" type="submit" spinner="updateStatus" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>
</div>
@push('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#attendance-menu-instructor").addClass("mary-active-menu bg-base-300");
        });
    </script>
@endpush
