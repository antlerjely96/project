<?php

namespace App\Livewire\Forms\Admin;

use App\Models\ClassStudent;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClassStudentForm extends Form
{
    public ?ClassStudent $classes;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $major_id;

    #[Validate('required')]
    public $school_year_id;

    public function setClassStudent(ClassStudent $classes)
    {
        $this->classes = $classes;
        $this->name = $classes->name;
        $this->major_id = $classes->major_id;
        $this->school_year_id = $classes->school_year_id;
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

        $this->classes->update([
            'name' => $this->name,
            'major_id' => $this->major_id,
            'school_year_id' => $this->school_year_id,
        ]);

        $this->reset();
    }
}
