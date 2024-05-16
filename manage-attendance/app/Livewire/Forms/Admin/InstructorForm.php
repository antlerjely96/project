<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Account;
use App\Models\Instructor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InstructorForm extends Form
{
    public ?Instructor $instructor;

    #[Validate([
        'required',
        'string',
        'max:255'
    ])]
    public $name;

    #[Validate([
        'required',
        'string',
        'max:13',
        'regex:/^0[0-9]{9}$/'
    ])]
    public $phone;

    #[Validate([
        'required',
        'email',
        'string',
        'max:255',
        'unique:accounts,email'
    ])]
    public $email;

    #[Validate('required')]
    public $password = '123456';

    #[Validate('required')]
    public $major_id;

    public $account_id;

    public function setInstructor(Instructor $instructor): void
    {
        $this->instructor = $instructor;
        $this->name = $instructor->name;
        $this->phone = $instructor->phone;
        $this->email = $instructor->account->email;
        $this->password = $instructor->account->password;
        $this->major_id = $instructor->major_id;
        $this->account_id = $instructor->account_id;
    }

    public function store(): void
    {
        $this->validate();

        Account::create([
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => '2',
            'locked' => '0',
        ]);

        $this->account_id = Account::where('email', $this->email)->first()->id;

        Instructor::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'account_id' => $this->account_id,
            'major_id' => $this->major_id,
        ]);
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:13', 'regex:/^0[0-9]{9}$/'],
            'major_id' => ['required']
        ]);

        $this->instructor->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'major_id' => $this->major_id,
        ]);
    }
}
