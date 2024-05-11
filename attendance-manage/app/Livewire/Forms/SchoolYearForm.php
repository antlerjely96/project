<?php

namespace App\Livewire\Forms;

use App\Models\SchoolYear;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SchoolYearForm extends Form
{
    public ?SchoolYear $schoolYear;

    #[Validate('required')]
    public $name;

    #[Validate('required', 'integer')]
    public $start_year;

    #[Validate('required', 'integer')]
    public $end_year;

    public function setSchoolYear(SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;
        $this->name = $schoolYear->name;
        $this->start_year = $schoolYear->start_year;
        $this->end_year = $schoolYear->end_year;
    }

    public function store(): void
    {
        $this->validate();

        SchoolYear::create([
            'name' => $this->name,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->schoolYear->update([
            'name' => $this->name,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
        ]);

        $this->reset();
    }
}
