<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JoinPartner extends Component
{
    use WithFileUploads;

    public $selectedRole = null; // null = Show Grid, 'vendor' = Show Form

    // Common Fields
    public $company_name, $contact_person, $address, $city, $state, $pincode, $country = 'India';
    public $phone, $whatsapp_number, $email, $pan_number;
    public $logo, $description;
    
    // Role Specific
    public $gst_number; // Mandatory for Vendor, Builder, Hotel
    public $category_type; // Dropdown for Vendor Type, Service Type, etc.
    
    // Uploads
    public $images = []; // Min 3 images
    public $video;
    public $social_facebook, $social_instagram, $social_linkedin;

    // Validation Rules (Dynamic)
    protected function rules()
    {
        $rules = [
            'company_name' => 'required|min:3',
            'contact_person' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|numeric',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'pan_number' => 'required',
            'logo' => 'required|image|max:1024', // 1MB Max
            'description' => 'required|min:20',
        ];

        // Role Specific Logic 
        if (in_array($this->selectedRole, ['vendor', 'builder', 'hotel'])) {
            $rules['gst_number'] = 'required';
        }

        if ($this->selectedRole !== 'vendor') {
             // Vendor doesn't strictly ask for images in PDF, but others do. 
             // We will make it required for all for better quality.
             $rules['images'] = 'required|array|min:3';
             $rules['images.*'] = 'image|max:2048';
        }

        return $rules;
    }

    public function selectRole($role)
    {
        $this->selectedRole = $role;
        $this->resetErrorBag(); // Clear old errors
    }

    public function backToGrid()
    {
        $this->selectedRole = null;
    }

    public function submitForm()
    {
        $this->validate();

        // 1. Upload Files
        $logoPath = $this->logo->store('logos', 'public');
        $videoPath = $this->video ? $this->video->store('videos', 'public') : null;
        
        $imagePaths = [];
        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('business_images', 'public');
        }

        // 2. Prepare Social Links
        $socials = [
            'facebook' => $this->social_facebook,
            'instagram' => $this->social_instagram,
            'linkedin' => $this->social_linkedin,
        ];

        // 3. Create Business (Verified = FALSE)
        Business::create([
            'user_id' => Auth::id(),
            'name' => $this->company_name,
            'type' => $this->selectedRole,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp_number' => $this->whatsapp_number,
            'contact_person' => $this->contact_person,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'pincode' => $this->pincode,
            'pan_number' => $this->pan_number,
            'gst_number' => $this->gst_number,
            'about_text' => $this->category_type, // Storing "Type" (Dropdown) here or create a new column
            'description' => $this->description,
            'logo' => $logoPath,
            'header_images' => $imagePaths,
            'video_path' => $videoPath,
            'social_links' => $socials,
            'is_verified' => false, // CRITICAL: Pending Approval
        ]);

        // 4. Update User Profile Type
        $user = User::find(Auth::id());
        $user->profile_type = $this->selectedRole;
        $user->save();

        return redirect()->route('dashboard')->with('message', 'Application Submitted! Waiting for Admin Approval.');
    }

    public function render()
    {
        return view('livewire.user.join-partner')->layout('layouts.app');
    }
}