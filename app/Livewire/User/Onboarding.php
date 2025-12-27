<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Onboarding extends Component
{
    use WithFileUploads;

    public $name, $phone, $address, $pan_number, $adhaar_number;
    public $gst_number, $license_number;
    public $logo;
    
    // We store the user's fixed role here
    public $userRole;

    public function mount()
    {
        $this->userRole = Auth::user()->profile_type;

        // Security: If still a customer, force them to choose a role first
        if ($this->userRole === 'customer') {
            return redirect()->route('join.partner');
        }
    }

    protected $rules = [
        'name' => 'required|min:3',
        'phone' => 'required|numeric|digits:10',
        'pan_number' => 'required',
        'address' => 'required',
        'logo' => 'nullable|image|max:1024',
    ];

    public function registerBusiness()
    {
        $this->validate();

        // Specific Validation based on Role
        if ($this->userRole === 'vendor') {
            $this->validate(['gst_number' => 'required']);
        }
        
        $logoPath = $this->logo ? $this->logo->store('logos', 'public') : null;

        Business::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'type' => $this->userRole, // <--- LOCKED TO USER ROLE
            'phone' => $this->phone,
            'address' => $this->address,
            'pan_number' => $this->pan_number,
            'adhaar_number' => $this->adhaar_number,
            'gst_number' => $this->gst_number,
            'license_number' => $this->license_number,
            'logo' => $logoPath,
        ]);

        return redirect()->route('dashboard')->with('message', 'New Branch Created Successfully!');
    }

    public function render()
    {
        return view('livewire.user.onboarding')->layout('layouts.app');
    }
}