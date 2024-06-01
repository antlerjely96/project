<?php

namespace App\Livewire\Forms\Instructor;

use App\Models\Account;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InstructorForm extends Form
{
    public ?Instructor $instructor;

    #[Validate('required', 'string', 'max:255')]
    public $name;

    #[Validate('required', 'string', 'max:10', 'regex:/^0[0-9]{9}$/')]
    public $phone;

    #[Validate('required')]
    public $major_id;

    public $password;

    public function setInstructor(Instructor $instructor): void
    {
        $this->instructor = $instructor;
        $this->name = $instructor->name;
        $this->phone = $instructor->phone;
        $this->major_id = $instructor->major_id;
    }

    public function update(): void
    {
        $this->validate();
        $this->instructor->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'major_id' => $this->major_id,
        ]);
        $this->reset();
    }

    public function changePassword(): void
    {
        $this->validate([
            'password' => 'required|string|min:6'
        ]);
        Account::where('id', Auth::guard('login')->user()->id)
                ->update([
                    'password' => bcrypt($this->password)
                ]);
        $this->reset();
    }
}
