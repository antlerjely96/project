<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Mary\View\Components\Toast;
use PhpParser\Node\Stmt\Return_;

class AccountForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public $email;

    #[Validate(['required', 'string', 'max:255'])]
    public $password;

    public function login(){
        $this->validate();
        $account = [
            'email' => $this->email,
            'password' => $this->password
        ];
        if(Auth::guard('login')->attempt($account)){
            $user = Auth::guard('login')->user();
            Auth::guard('login')->login($user);
            session()->put('user', $user);
            return redirect()->route('admin.majors');
        } else {
            return Redirect::back()->with('error');
        }
    }
}
