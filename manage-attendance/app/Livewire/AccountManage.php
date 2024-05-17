<?php

namespace App\Livewire;

use App\Livewire\Forms\AccountForm;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Mary\Traits\Toast;

class AccountManage extends Component
{
    use Toast;
    use Authenticatable;
    public AccountForm $form;

    public function render()
    {
        return view('livewire.account-manage')->layout('components.layouts.auth');
    }

    public function login(){
        $this->validate();
        $account = [
            'email' => $this->form->email,
            'password' => $this->form->password
        ];
        if(Auth::guard('login')->attempt($account)){
            $user = Auth::guard('login')->user();
            Auth::guard('login')->login($user);
            session()->put('user', $user);
            return redirect()->route('admin.majors');
        } else {
            $this->error('Invalid email or password');
        }
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('login')->logout();
        session()->forget('user');
        return redirect()->route('login');
    }
}
