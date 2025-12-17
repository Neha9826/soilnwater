<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // For uploading logos
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfile extends Component
{
    use WithFileUploads;

    public $name, $email, $new_password;
    public $store_name, $store_slug, $service_category, $service_charge;
    public $store_logo; // Temporary upload
    public $existing_logo; // To show current image
    
    public $is_business_account = false;

    public function mount()
    {
        $user = Auth::user();
        
        // Basic Info
        $this->name = $user->name;
        $this->email = $user->email;
        
        // Check if they are a "Pro" user (Vendor, Consultant, Dealer)
        if (in_array($user->profile_type, ['vendor', 'consultant', 'dealer'])) {
            $this->is_business_account = true;
            $this->store_name = $user->store_name;
            $this->store_slug = $user->store_slug;
            $this->service_category = $user->service_category;
            $this->service_charge = $user->service_charge;
            $this->existing_logo = $user->store_logo;
        }
    }

    public function updateProfile()
    {
        $user = Auth::user();

        // 1. Validation
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'store_name' => $this->is_business_account ? 'required|max:255' : 'nullable',
            'store_logo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        // 2. Update Basic Info
        $user->name = $this->name;
        $user->email = $this->email;

        // 3. Update Password (Only if typed)
        if (!empty($this->new_password)) {
            $user->password = Hash::make($this->new_password);
        }

        // 4. Update Business Info (If applicable)
        if ($this->is_business_account) {
            $user->store_name = $this->store_name;
            $user->store_slug = $this->store_slug;
            $user->service_category = $this->service_category;
            $user->service_charge = $this->service_charge;

            // Handle Logo Upload
            if ($this->store_logo) {
                $path = $this->store_logo->store('uploads', 'public');
                $user->store_logo = $path;
            }
        }

        $user->save();

        session()->flash('message', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}