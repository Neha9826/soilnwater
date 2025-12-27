<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    // 1. Define Public Properties
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    // 2. The Register Logic
    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users', 
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'profile_type' => 'customer', // Default role
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // 3. CRITICAL: The Render Method (This was missing!)
    public function render()
    {
        return view('livewire.auth.register'); 
    }
}