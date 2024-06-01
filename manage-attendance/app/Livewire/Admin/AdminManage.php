<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\AdminForm;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class AdminManage extends Component
{
    use Toast;
    public string $title = "Personal Information";
    public array $headers = [
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'phone', 'label' => 'Phone', 'class' => 'text-black'],
        ['key' => 'gender', 'label' => 'Gender', 'class' => 'text-black'],
        ['key' => 'email', 'label' => 'Email', 'class' => 'text-black'],
    ];

    public bool $modalEdit = false;
    public bool $modalChangePassword = false;

    public string $mode = "";

    public AdminForm $form;

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.admin-manage', [
            'admins' => $this->admin()
        ]);
    }

    public function admin()
    {
         return Admin::join('accounts', 'admins.account_id', '=', 'accounts.id')
            ->where('admins.account_id', Auth::guard('login')->user()->id)
            ->get();
    }

    public function changePassword($id): void
    {
        $this->modalChangePassword = true;
        $this->mode = "changePassword";
    }

    public function edit($id): void
    {
        $admin = Admin::find($id);
        $this->form->setAdmin($admin);
        $this->mode = "edit";
        $this->modalEdit = true;
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
