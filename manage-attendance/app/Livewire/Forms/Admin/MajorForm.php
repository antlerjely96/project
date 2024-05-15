<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Major;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MajorForm extends Form
{
    public ?Major $major;

    #[Validate('required')]
    public $name;

    public function setMajor(Major $major): void
    {
        $this->major = $major;
        $this->name = $major->name;
    }

    public function store(): void
    {
        $this->validate();

        Major::create([
            'name' => $this->name,
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->major->update([
            'name' => $this->name,
        ]);

        $this->reset();
    }
}
