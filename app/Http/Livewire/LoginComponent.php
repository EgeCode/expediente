<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $username = "";
    public $password = "";

    public function render()
    {

        return view('livewire.login-component')->layout('layouts.appLogin');

    }

    public function login(){
        
        $this->validate([
            'username' => 'required',
            'password'=> 'required'
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password, 'active' => 1])) 
            return redirect(route('home'));
        else
            $this->addError('credentials', 'Error de credenciales, favor de verificar');
        
    }
}
