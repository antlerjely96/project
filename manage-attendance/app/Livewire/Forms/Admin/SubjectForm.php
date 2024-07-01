<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Subject;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectForm extends Form
{
    public ?Subject $subject;

    #[Validate('required')]
    public $name;

    public $major_id;

    #[Validate([
        'required',
        'integer'
    ])]
    public $duration;

    public function setSubject(Subject $subject): void
    {
        $this->subject = $subject;
        $this->name = $subject->name;
        $this->major_id = $subject->major_id;
        $this->duration = $subject->duration;
    }

    public function store(): void
    {
        $this->validate();

        Subject::create([
            'name' => $this->name,
            'major_id' => $this->major_id,
            'duration' => $this->duration,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->subject->update([
            'name' => $this->name,
            'major_id' => $this->major_id,
            'duration' => $this->duration,
        ]);

        $this->reset();
    }
}
