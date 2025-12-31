<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public function mount()
    {
        // 1. Security Check: Redirect Super Admin to the Admin Panel
        // Since Admins shouldn't be using the Customer Dashboard
        if (Auth::check() && Auth::user()->email === 'admin@soilnwater.com') {
            return redirect('/admin');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // 2. Return the View with the Layout
        return view('livewire.user-dashboard', [
            'user' => $user
        ])->layout('layouts.app'); 
    }
}