<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\User;
use App\Models\Category; // <--- IMPORTANT: Don't forget this import
use Illuminate\Support\Facades\Auth;

class JoinPartner extends Component
{
    use WithFileUploads;

    public $selectedRole = null; 

    // Common Fields
    public $company_name, $contact_person, $address, $city, $state, $pincode, $country = 'India';
    public $phone, $whatsapp_number, $email, $pan_number;
    public $logo, $description;
    
    // Role Specific
    public $gst_number; 
    public $category_type; 
    public $custom_category; // For "Other" Input
    
    // Uploads
    public $images = [];
    public $video;

    protected function rules()
    {
        $rules = [
            'company_name' => 'required|min:3',
            'contact_person' => 'required',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|numeric',
            'pan_number' => 'required',
            'logo' => 'required|image|max:1024',
            'description' => 'required|min:20',
            'category_type' => 'required',
        ];

        // 1. Validate Custom Category if "Other" is selected
        if ($this->category_type === 'Other') {
            $rules['custom_category'] = 'required|string|min:3|max:50';
        }

        if (in_array($this->selectedRole, ['vendor', 'builder', 'hotel'])) {
            $rules['gst_number'] = 'required';
        }

        if ($this->selectedRole !== 'vendor') {
             $rules['images'] = 'required|array|min:3';
             $rules['images.*'] = 'image|max:2048';
        }

        return $rules;
    }

    public function selectRole($role)
    {
        $this->selectedRole = $role;
        $this->category_type = ''; // Reset dropdown
        $this->custom_category = ''; // Reset custom input
        $this->resetErrorBag(); 
    }

    public function backToGrid()
    {
        $this->selectedRole = null;
    }

    public function submitForm()
    {
        $this->validate();

        // 2. Handle "Other" Logic
        $finalCategory = $this->category_type;

        if ($this->category_type === 'Other') {
            // Create the new category but set is_active = false (Requires Admin Approval)
            Category::create([
                'name' => $this->custom_category,
                'type' => $this->selectedRole,
                'is_active' => false 
            ]);

            // Use the custom name for this specific business
            $finalCategory = $this->custom_category;
        }

        // 3. File Uploads
        $logoPath = $this->logo->store('logos', 'public');
        $videoPath = $this->video ? $this->video->store('videos', 'public') : null;
        
        $imagePaths = [];
        if($this->images){
             foreach ($this->images as $img) {
                $imagePaths[] = $img->store('business_images', 'public');
            }
        }

        // 4. Create Business
        Business::create([
            'user_id' => Auth::id(),
            'name' => $this->company_name,
            'type' => $this->selectedRole,
            'about_text' => $finalCategory, // Storing the Category Name
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
            'description' => $this->description,
            'logo' => $logoPath,
            'header_images' => $imagePaths,
            'video_path' => $videoPath,
            'is_verified' => false,
        ]);

        $user = User::find(Auth::id());
        $user->profile_type = $this->selectedRole;
        $user->save();

        return redirect()->route('dashboard')->with('message', 'Application Submitted! Waiting for Admin Approval.');
    }

    public function render()
    {
        // 5. THIS IS THE MISSING PART CAUSING YOUR ERROR
        $categories = [];
        
        if($this->selectedRole) {
            // Fetch categories that match the selected role (e.g., 'builder')
            $categories = Category::where('type', $this->selectedRole)
                                  ->where('is_active', true) 
                                  ->orderBy('name')
                                  ->get();
        }

        return view('livewire.user.join-partner', [
            'dbCategories' => $categories // Sending the variable to the view
        ])->layout('layouts.app');
    }
}