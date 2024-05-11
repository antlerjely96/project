<?php

namespace App\Livewire\Forms;

use App\Models\ClassStudent;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClassStudentForm extends Form
{
    public ?ClassStudent $classStudent;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $major_id;

    #[Validate('required')]
    public $school_year_id;

    public function setClassStudent(ClassStudent $classStudent)
    {
        $this->classStudent = $classStudent;
        $this->name = $classStudent->name;
        $this->major_id = $classStudent->major_id;
        $this->school_year_id = $classStudent->school_year_id;
    }

    public function store(): void
    {
        $this->validate();

        ClassStudent::create([
            'name' => $this->name,
            'major_id' => $this->major_id,
            'school_year_id' => $this->school_year_id,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->classStudent->update([
            'name' => $this->name,
            'major_id' => $this->major_id,
            'school_year_id' => $this->school_year_id,
        ]);

        $this->reset();
    }
}
