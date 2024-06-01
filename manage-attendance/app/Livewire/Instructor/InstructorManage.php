<?php

namespace App\Livewire\Instructor;

use App\Livewire\Forms\Instructor\InstructorForm;
use App\Models\Instructor;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class InstructorManage extends Component
{
    use Toast;
    public string $title = "Personal Information";
    public bool $modalEdit = false;
    public string $mode = "";
    public InstructorForm $form;
    public bool $modalChangePassword = false;

    public array $headers = [
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'account.email', 'label' => 'Email', 'class' => 'text-black'],
        ['key' => 'phone', 'label' => 'Phone', 'class' => 'text-black'],
        ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.instructor.instructor-manage', [
            'instructors' => $this->instructor(),
            'majors' => $this->majors(),
        ]);
    }

    public function instructor(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Instructor::with('account', 'major')
            ->where('account_id', Auth::guard('login')->user()->id)
            ->get();
    }

    public function majors(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Major::all();
    }

    public function edit($id): void
    {
        $instructor = Instructor::find($id);
        $this->form->setInstructor($instructor);
        $this->mode = "edit";
        $this->modalEdit = true;
    }

    public function changePassword($id): void
    {
        $this->modalChangePassword = true;
        $this->mode = "changePassword";
    }

    public function save(): void
    {
        if($this->mode == "edit"){
            $this->form->update();
            $this->modalEdit = false;
            $this->success("Update successfully");
        } else if($this->mode == "changePassword"){
            $this->form->changePassword();
            $this->modalChangePassword = false;
            $this->success("Change password successfully");
        }
    }
}
