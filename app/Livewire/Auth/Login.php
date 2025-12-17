<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        request()->session()->regenerate();

        // Use the smart redirect logic we created earlier
        return app(LoginResponse::class)->toResponse(request());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}