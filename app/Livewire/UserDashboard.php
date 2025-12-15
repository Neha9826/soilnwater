<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Property;

class UserDashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Fetch data based on WHO the user is
        $myProducts = [];
        $myProperties = [];

        // Currently, we don't have a 'user_id' in products/properties table yet. 
        // We will need to add that next to make this work fully.
        // For now, let's just set up the view logic.

        return view('livewire.user-dashboard', [
            'user' => $user
        ]);
    }
}