<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class ManageBranches extends Component
{
    public $myBusinesses;

    public function mount()
    {
        $this->myBusinesses = Business::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.vendor.manage-branches')->layout('layouts.app');
    }
}