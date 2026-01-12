<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CreateBranch extends Component
{
    use WithFileUploads;

    // Form Fields
    public $company_name, $contact_person, $phone, $whatsapp_number, $email;
    public $address, $city, $state, $pincode, $country = 'India';
    public $pan_number, $gst_number, $category_type, $custom_category, $description;
    
    // Media
    public $logo;
    public $images = []; 
    // public $video;

    public $dbCategories = [];
    public $userRole;

    public function mount()
    {
        $this->userRole = Auth::user()->profile_type; // e.g., 'vendor'
        $this->contact_person = Auth::user()->name; // Auto-fill owner name
        $this->phone = Auth::user()->phone; // Auto-fill phone if available
        $this->email = Auth::user()->email; // Auto-fill email

        // Load categories suitable for this role (Optional filtering)
        $this->dbCategories = Category::all();
    }

    public function saveBranch()
    {
        $this->validate([
            'company_name' => 'required|min:3',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'category_type' => 'required',
            'logo' => 'nullable|image|max:2048',
            'images.*' => 'image|max:2048', // Validate gallery
        ]);

        $user = Auth::user();

        // 1. Upload Logo
        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('business_logos', 'public');
        }

        // 2. Upload Gallery
        $galleryPaths = [];
        if (!empty($this->images)) {
            foreach ($this->images as $img) {
                $galleryPaths[] = $img->store('business_gallery', 'public');
            }
        }

        // 3. Create Record
        Business::create([
            'user_id' => $user->id,
            'name' => $this->company_name,
            'slug' => \Illuminate\Support\Str::slug($this->company_name) . '-' . uniqid(),
            'profile_type' => $this->userRole, // Lock to current user role
            
            // Contact
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp_number,
            'email' => $this->email,
            
            // Location
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'country' => $this->country,
            
            // Legal
            'pan_number' => $this->pan_number,
            'gst_number' => $this->gst_number,
            
            // Details
            'category' => $this->category_type === 'Other' ? $this->custom_category : $this->category_type,
            'description' => $this->description,
            
            // Media
            'logo' => $logoPath,
            'images' => $galleryPaths,
            
            'is_active' => true,
        ]);

        session()->flash('message', 'New branch created successfully!');
        
        return redirect()->route('vendor.branches');
    }

    public function render()
    {
        return view('livewire.vendor.create-branch')->layout('layouts.app');
    }
}