<?php

namespace App\Livewire\Forms;

use App\Models\Major;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MajorForm extends Form
{
    public ?Major $major;
//    attributes
    #[Validate('required')]
    public $name;

    public function setMajor(Major $major): void
    {
        $this->major = $major;
        $this->name = $major->name;
    }
//function to store data
    public function store(): void
    {
        $this->validate();

        Major::create([
            'name' => $this->name,
        ]);

        $this->reset();
    }

//    function to update data
    public function update(): void
    {
        $this->validate();

        $this->major->update([
            'name' => $this->name,
        ]);

        $this->reset();
    }


}
