<?php

namespace App\Livewire\Instructor;

use App\Livewire\Forms\Instructor\AttendanceForm;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\ClassStudent;
use App\Models\Division;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Mary\Traits\Toast;

class AttendanceManage extends Component
{
    use Toast;
    public string $title = 'Attendances';
    public $selectedClass = null;
    public $selectedStatus = null;
    public $selectedDivision = null;
    public bool $viewDetail = false;
    public $class_student_id;
    public $subject_id;
    public $instructor_id;
    public $student_id;
    public $selectedTab = 'statistics-tab';
    public AttendanceForm $form;
    public bool $modalAddAttendance = false;
    public bool $modalEditAttendance = false;
    public $attendance_date;
    public bool $modalEditStatus = false;

    public array $headersAttendanceDetail = [
        ['key' => 'code', 'label' => 'Student code', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Student name', 'class' => 'text-black'],
        ['key' => 'attendance_rate', 'label' => 'Rate (%)', 'class' => 'text-black'],
        ['key' => 'total_attended', 'label' => 'Attended', 'class' => 'text-black'],
        ['key' => 'total_absences_without_permission', 'label' => 'Absences without permission', 'class' => 'text-black'],
        ['key' => 'total_late', 'label' => 'Late', 'class' => 'text-black'],
        ['key' => 'total_absences_with_permission', 'label' => 'Absences with permission', 'class' => 'text-black'],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        if($this->viewDetail == false){
            return view('livewire.instructor.attendance-manage');
        } else {
            return view('livewire.instructor.attendance-detail-manage', [
                'attendanceDetails' => $this->attendanceDetail($this->class_student_id, $this->subject_id, $this->instructor_id),
                'subjectDurations' => $this->getSubjectDuration($this->class_student_id, $this->subject_id, $this->instructor_id),
                'instructorAndStatus' => $this->getInstructorAndStatus($this->class_student_id, $this->subject_id, $this->instructor_id),
                'countLessons' => $this->getCountLesson($this->class_student_id, $this->subject_id),
                'students' => $this->getStudent($this->class_student_id),
                'attendanceStatusDetails' => $this->getAttendanceStatus(),
                'classes' => $this->getClass()
            ]);
        }
    }

    #[Computed]
    public function classes(): \Illuminate\Database\Eloquent\Collection
    {
        return ClassStudent::all();
    }

    #[Computed]
    public function divisions(): \Illuminate\Database\Eloquent\Collection
    {
        $instructor_id = Instructor::where('account_id', Auth::guard('login')->user()->id)->first()->id;
//        dd($instructor_id);
        if($this->selectedClass != null){
            if($this->selectedStatus == null){
                return Division::with('classStudent', 'subject', 'instructor')
                    ->whereHas('classStudent', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->selectedClass . '%');
                    })
                    ->where('divisions.status', 'Active')
                    ->where('divisions.instructor_id', $instructor_id)
                    ->get();
            } else {
                return Division::with('classStudent', 'subject', 'instructor')
                    ->whereHas('classStudent', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->selectedClass . '%');
                    })
                    ->where('status', $this->selectedStatus)
                    ->where('divisions.instructor_id', $instructor_id)
                    ->get();
            }

        } else {
            if($this->selectedStatus == null){
                return Division::with('classStudent', 'subject', 'instructor')
                    ->where('status', 'Active')
                    ->where('divisions.instructor_id', $instructor_id)
                    ->get();
            } else {
                return Division::with('classStudent', 'subject', 'instructor')
                    ->where('status', $this->selectedStatus)
                    ->where('divisions.instructor_id', $instructor_id)
                    ->get();
            }
        }
    }

    public function getDetail($class_student_id, $subject_id, $instructor_id): void
    {
        $this->viewDetail = true;
        $this->class_student_id = $class_student_id;
        $this->subject_id = $subject_id;
        $this->instructor_id = $instructor_id;
    }

    public function attendanceDetail($class_student_id, $subject_id, $instructor_id): \Illuminate\Database\Eloquent\Collection
    {
        return Student::select('students.id', 'students.code', 'students.name', 'attendances.subject_id')
            ->leftJoin('attendance_details', 'students.id', '=', 'attendance_details.student_id')
            ->leftJoin('attendances', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->where('students.class_student_id', $class_student_id)
            ->where('attendances.subject_id', $subject_id)
            ->groupBy('students.id', 'students.code', 'students.name', 'attendances.subject_id')
            ->selectRaw('COUNT(attendance_details.attendance_id) AS total_session')
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'attended' THEN 1 ELSE NULL END) AS total_attended")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'absences_without_permission' THEN 1 ELSE NULL END) AS total_absences_without_permission")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'late' THEN 1 ELSE NULL END) AS total_late")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'absences_with_permission' THEN 1 ELSE NULL END) AS total_absences_with_permission")
            ->selectRaw("ROUND((((COUNT(CASE WHEN attendance_details.attendance_status = 'attended' THEN 1 ELSE NULL END) + COUNT(CASE WHEN attendance_details.attendance_status = 'late' THEN 1 ELSE NULL END) / 3 + COUNT(CASE WHEN attendance_details.attendance_status = 'late' THEN 1 ELSE NULL END) / 3) / COUNT(attendance_details.attendance_id)) * 100), 2) AS attendance_rate")
            ->get();
    }

    public function getSubjectDuration($class_student_id, $subject_id, $instructor_id): \Illuminate\Database\Eloquent\Collection
    {
        $data = Attendance::select([
                'attendances.subject_id',
                'attendances.class_student_id',
                'subjects.name AS subject_name',
                'class_students.name AS class_name',
                'subjects.duration',
                DB::raw('SUM(HOUR(TIMEDIFF(attendances.end_time, attendances.start_time))) AS total_time'),
                DB::raw('(subjects.duration - SUM(HOUR(TIMEDIFF(attendances.end_time, attendances.start_time)))) AS remaining_duration')
            ])
            ->join('subjects', 'subjects.id', '=', 'attendances.subject_id')
            ->join('class_students', 'class_students.id', '=', 'attendances.class_student_id')
            ->where('attendances.class_student_id', $this->class_student_id)
            ->where('attendances.subject_id', $this->subject_id)
            ->groupBy('attendances.subject_id', 'attendances.class_student_id', 'subjects.name', 'class_students.name', 'subjects.duration')
            ->get();
        if($data->count() == 0){
            return Subject::where('id', $this->subject_id)->get();
//            return ClassStudent::where('id', $this->class_student_id)->get();
//            return $arrayData;
        } else {
            return $data;
        }
    }

    public function getInstructorAndStatus($class_student_id, $subject_id, $instructor_id): \Illuminate\Database\Eloquent\Collection
    {
        return Instructor::select([
                'instructors.name',
                'divisions.status'
            ])
            ->join('divisions', 'divisions.instructor_id', '=', 'instructors.id')
            ->where('divisions.instructor_id', $instructor_id)
            ->where('divisions.class_student_id', $class_student_id)
            ->where('divisions.subject_id', $subject_id)
            ->get();
    }

    public function getCountLesson($class_student_id, $subject_id){
        return Attendance::where('class_student_id', $class_student_id)
            ->where('subject_id', $subject_id)
            ->select([
                'id',
                'attendance_date',
                'start_time',
                'end_time'
            ])
            ->get();
    }

    public function getStudent($class_student_id){
        return Student::where('class_student_id', $class_student_id)->get();
    }

    public function getAttendanceStatus(): \Illuminate\Database\Eloquent\Collection|array
    {
        $data = array();
        $attendances = Attendance::join('attendance_details', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->where('class_student_id', $this->class_student_id)
            ->where('subject_id', $this->subject_id)
            ->select([
                'attendances.attendance_date',
                'attendances.start_time',
                'attendances.end_time',
                'attendance_details.student_id',
                'attendance_details.attendance_status'
            ])
            ->get();
        foreach ($attendances as $attendance){
            $data[$attendance->student_id][$attendance->attendance_date] = [
                'attendance_status' => $attendance->attendance_status
            ];
        }

        return $data;
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->modalAddAttendance = true;
    }

    public function save(): void
    {
        $temp = 0;
        $countAttendance = \App\Models\Attendance::where('class_student_id', $this->class_student_id)
            ->where('subject_id', $this->subject_id)
            ->where('attendance_date', date('Y-m-d'))
            ->count();
//        dd($countAttendance);
        if($countAttendance != 1){
            $this->form->validate([
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            if(Carbon::createFromFormat('H:i:s', $this->form->start_time) < Carbon::createFromFormat('H:i:s', $this->form->end_time)){
                foreach ($this->getStudent($this->class_student_id) as $key => $student){
                    if(!Arr::exists($this->form->status, $student->id)){
                        $temp++;
                    }
                }
                if($temp != 0){
                    $this->error("Please fill all the status of students.");
                } else {
                    Attendance::create([
                        'attendance_date' => date('Y-m-d'),
                        'start_time' => $this->form->start_time,
                        'end_time' => $this->form->end_time,
                        'class_student_id' => $this->class_student_id,
                        'subject_id' => $this->subject_id,
                        'account_id' => Auth::guard('login')->user()->id,
                    ]);

                    $attendanceId = Attendance::where('attendance_date', date('Y-m-d'))
                        ->where('class_student_id', $this->class_student_id)
                        ->where('subject_id', $this->subject_id)
                        ->first()
                        ->id;

                    foreach ($this->form->status as $student_id => $status){
                        AttendanceDetail::create([
                            'attendance_id' => $attendanceId,
                            'student_id' => $student_id,
                            'attendance_status' => $status,
                            'note' => $this->form->note[$student_id] ?? "",
                        ]);
                    }
                }
                $this->success("This attendance has been added successfully.");
            } else {
                $this->error("The start time must be less than the end time.");
            }
            $this->modalAddAttendance = false;
        } else {
            $this->error("This attendance already exists.");
            $this->modalAddAttendance = false;
        }
    }

    public function edit($id): void
    {
        $attendance = Attendance::find($id);
        $this->form->setAttendance($attendance);
        $this->modalEditAttendance = true;
    }

    public function update(): void
    {
        if(Carbon::createFromFormat('H:i:s', $this->form->start_time) < Carbon::createFromFormat('H:i:s', $this->form->end_time)){
            $this->form->update();
            $this->modalEditAttendance = false;
            $this->success('Updated Attendance');
        }
    }

    public function editStatus($attendance_date, $student_id): void
    {
        $this->attendance_date = $attendance_date;
        $this->student_id = $student_id;
        $this->modalEditStatus = true;
    }

    public function updateStatus(): void
    {
        if($this->form->status[$this->student_id]){
            AttendanceDetail::join('attendances', 'attendance_details.attendance_id', '=', 'attendances.id')
                ->where('attendances.attendance_date', $this->attendance_date)
                ->where('attendance_details.student_id', $this->student_id)
                ->update([
                    'attendance_details.attendance_status' => $this->form->status[$this->student_id]
                ]);
            $this->success("This attendance has been updated successfully.");
            $this->modalEditStatus = false;
        }
        else {
            $this->error("Please fill the status of student.");
        }
    }

    public function getClass(){
        return ClassStudent::where('id', $this->class_student_id)->get();
    }
}
