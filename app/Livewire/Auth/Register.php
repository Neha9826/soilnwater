<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    // Basic Fields
    public $name, $email, $password;
    
    // Role Selection
    public $role = 'customer'; // Default
    
    // Dynamic Fields (Vendor/Dealer)
    public $store_name;
    public $service_category;
    public $contact_phone;

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            // Conditional Validation
            'store_name' => $this->role !== 'customer' ? 'required' : 'nullable',
        ]);

        // Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'profile_type' => $this->role,
            'store_name' => $this->store_name,
            'service_category' => $this->service_category,
            // Generate Slug automatically if they have a store name
            'store_slug' => $this->store_name ? \Illuminate\Support\Str::slug($this->store_name) : null,
            'is_vendor' => $this->role !== 'customer', // Auto-mark as vendor partner
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}