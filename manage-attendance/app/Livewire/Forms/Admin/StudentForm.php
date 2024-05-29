<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Account;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StudentForm extends Form
{
    public ?Student $student;

    #[Validate([
        'required',
        'unique:students,code',
    ])]
    public $code;

    #[Validate([
        'required',
        'string',
        'max:255',
        'regex:/^[a-zA-Z ]+$/',
    ])]
    public $name;

    #[Validate([
        'required',
        'string',
        'max:10',
        'regex:/^0[0-9]{9}$/'
    ])]
    public $phone;

    #[Validate([
        'required',
        'string',
        'max:255',
        'email',
        'unique:accounts,email'
    ])]
    public $email;

    #[Validate('required')]
    public $password = '123456';

    #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $gender;

    #[Validate(['required'])]
    public $date_of_birth;

    #[Validate('required')]
    public $class_student_id;

//    #[Validate('required', 'numeric')]
    public $account_id;

    public $file;
    public function setStudent(Student $student): void
    {
        $this->student = $student;
        $this->code = $student->code;
        $this->name = $student->name;
        $this->phone = $student->phone;
        $this->email = $student->account->email;
        $this->password = $student->account->password;
        $this->address = $student->address;
        $this->gender = $student->gender;
        $this->date_of_birth = $student->date_of_birth;
        $this->class_student_id = $student->class_student_id;
        $this->account_id = $student->account_id;
    }

    public function store(): void
    {
        $this->validate();
        // Execution doesn't reach here if validation fails.
        Account::create([
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => '3',
            'locked' => '0',
        ]);

        $this->account_id = Account::where('email', $this->email)->first()->id;

        Student::create(
            [
                'code' => $this->code,
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'class_student_id' => $this->class_student_id,
                'account_id' => $this->account_id,
            ]
        );

        $this->reset();
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]+$/'],
            'phone' => ['required', 'string', 'max:10', 'regex:/^0[0-9]{9}$/'],
            'address' => ['required'],
            'gender' => ['required'],
            'date_of_birth' => ['required'],
            'class_student_id' => ['required'],
        ]);
        // Execution doesn't reach here if validation fails.
        $this->student->update(
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'class_student_id' => $this->class_student_id,
            ]
        );

        $this->reset();
    }


}
