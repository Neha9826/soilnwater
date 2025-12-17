<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Register extends Component
{
    // 1. Define Properties
    public $name, $email, $password;
    public $role = 'customer'; 
    public $store_name, $contact_phone, $service_category;

    // 2. Register Function
    public function register()
    {
        // Validation
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:customer,vendor,dealer,consultant,hotel',
            
            // Conditional Rules
            'store_name' => $this->role !== 'customer' ? 'required|min:3' : 'nullable',
            'contact_phone' => $this->role !== 'customer' ? 'required|numeric|digits:10' : 'nullable',
            'service_category' => $this->role === 'consultant' ? 'required' : 'nullable',
        ]);

        // Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'profile_type' => $this->role,
            
            // Business Details
            'phone' => $this->contact_phone,
            'store_name' => $this->store_name,
            'service_category' => $this->service_category,
            'store_slug' => $this->store_name ? \Illuminate\Support\Str::slug($this->store_name) : null,
            
            'is_vendor' => $this->role !== 'customer', 
        ]);

        // Login & Redirect
        Auth::login($user);
        
        return app(LoginResponse::class)->toResponse(request());
    }

    // 3. Render Function
    public function render()
    {
        return view('livewire.auth.register');
    }
}