<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttendanceForm extends Form
{
    public ?Attendance $attendance;
    public $attendance_date;

    public $start_time;
    public $end_time;

    public array $status = [];
    public array $note = [];

//    public Collection $attendanceDetails;

//    public function setAttendance(Attendance $attendance)
//    {
//        $this->attendance = $attendance;
//        $this->attendance_date = $attendance->attendance_date;
//        $this->start_time = $attendance->start_time;
//        $this->end_time = $attendance->end_time;
//        $this->attendanceDetails = $attendance->attendanceDetails;
////        foreach($attendance->attendanceDetails as $key => $attendanceDetail) {
////            $this->status[$attendanceDetail->student_id] = $attendanceDetail->status;
////            $this->note[$attendanceDetail->student_id] = $attendanceDetail->note ?? '';
////        }
//    }
}
