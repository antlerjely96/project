<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DivisionForm extends Form
{
    public ?Division $division;

    #[Validate('required')]
    public $selectedClass;

    #[Validate('required')]
    public $selectedSubject;

    #[Validate('required')]
    public $selectedInstructor;

//    #[Validate('required')]
    public $admin_id;

    #[Validate('required')]
    public $status = 0;

    #[Validate('required')]
    public array $start_time = [];

    #[Validate('required')]
    public $start_date;

    #[Validate('required')]
    public array $day_of_week = [];

    #[Validate('required')]
    public $time_day;

    #[Validate('required')]
    public $instructor_id;

    public function setDivision(Division $division): void
    {
        $this->division = $division;
        $this->selectedClass = $division->selectedClass;
        $this->selectedSubject = $division->selectedSubject;
        $this->selectedInstructor = $division->selectedInstructor;
        session()->get('user')->id = $division->admin_id;
        $this->status = $division->status;
        $this->start_date = $division->start_date;
        $this->time_day = $division->time_day;
        $this->start_time = $division->start_time;
        $this->day_of_week = $division->day_of_week;
    }

    public function setInstructorId(Division $division): void
    {
        $this->division = $division;
        $this->selectedInstructor = $division->selectedInstructor;
    }

    public function update(): void
    {
//        dd($this->instructor_id);
        $this->validate([
            'instructor_id' => 'required',
        ]);
        $this->division->update([
            'instructor_id' => $this->instructor_id,
        ]);
        $this->reset();
    }
}
