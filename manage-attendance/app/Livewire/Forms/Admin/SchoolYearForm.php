<?php

namespace App\Livewire\Forms\Admin;

use App\Models\SchoolYear;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SchoolYearForm extends Form
{
    public ?SchoolYear $schoolYear;

    #[Validate('required')]
    public $name;

    #[Validate([
        'required',
        'integer'
    ])]
    public $start_year;
    public $end_year;

    public function setSchoolYear(SchoolYear $schoolYear): void
    {
        $this->schoolYear = $schoolYear;
        $this->name = $schoolYear->name;
        $this->start_year = $schoolYear->start_year;
        $this->end_year = $schoolYear->start_year + 3;
    }

    public function store(): void
    {
        $this->validate();

        SchoolYear::create([
            'name' => $this->name,
            'start_year' => $this->start_year,
            'end_year' => $this->start_year + 3,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->schoolYear->update([
            'name' => $this->name,
            'start_year' => $this->start_year,
            'end_year' => $this->start_year + 3,
        ]);

        $this->reset();
    }
}
