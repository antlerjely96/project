<?php

namespace App\Livewire\Forms\Instructor;

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
    public array $note = [];

    public function setAttendance(Attendance $attendance): void
    {
        $this->attendance = $attendance;
        $this->attendance_date = $attendance->attendance_date;
        $this->start_time = $attendance->start_time;
        $this->end_time = $attendance->end_time;
    }

    public function update(): void
    {
        $this->validate([
            'attendance_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $this->attendance->update([
            'attendance_date' => $this->attendance_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->reset();
    }
}
