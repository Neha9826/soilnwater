<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();

        // 1. Check for Super Admin
        if ($user->email === 'admin@demo.com') { 
            return redirect('/admin'); 
        }

        // 2. If User is a 'customer', send to Home Page
        if ($user->profile_type === 'customer') {
            return redirect('/'); 
        }

        // 3. All other types (vendor, builder, etc.) go to Dashboard
        return redirect()->route('dashboard'); 
    }

    public function render()
    {
        // Use the safe CDN layout
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}