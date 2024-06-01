<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Account;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AdminForm extends Form
{
    public ?Admin $admin;

    #[Validate('required', 'string', 'max:255')]
    public $name;

    #[Validate('required', 'string', 'max:10', 'regex:/^0[0-9]{9}$/')]
    public $phone;

    #[Validate('required')]
    public $gender;

    public $password;

    public function setAdmin(Admin $admin): void
    {
        $this->admin = $admin;
        $this->name = $admin->name;
        $this->phone = $admin->phone;
        $this->gender = $admin->gender;
    }

    public function update(): void
    {
        $this->validate();
        $this->admin->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'gender' => $this->gender,
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
