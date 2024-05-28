<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Attendance;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttendanceForm extends Form
{
    public ?Attendance $attendance;
    public $attendance_date;

    public $start_time;
    public $end_time;

    public array $status = [];
    public $note;

    public function setAttendance(Attendance $attendance): void
    {
        $this->attendance = $attendance;
        $this->attendance_date = $attendance->attendance_date;
        $this->start_time = $attendance->start_time;
        $this->end_time = $attendance->end_time;
    }
}
