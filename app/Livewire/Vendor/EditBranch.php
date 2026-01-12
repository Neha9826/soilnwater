<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class EditBranch extends Component
{
    use WithFileUploads;

    public $businessId;
    
    // Form Fields (Matching your Join Partner form)
    public $company_name, $contact_person, $phone, $whatsapp_number, $email;
    public $address, $city, $state, $pincode, $country = 'India';
    public $pan_number, $gst_number, $category_type, $custom_category, $description;
    
    // Media
    public $logo, $existing_logo;
    public $images = [], $existing_images = []; // Gallery
    public $video, $existing_video;

    public $dbCategories = [];

    public function mount($id)
    {
        $business = Business::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->businessId = $business->id;
        
        // Map DB columns to Form Fields
        $this->company_name = $business->name;
        $this->contact_person = $business->contact_person; // Ensure column exists
        $this->phone = $business->phone;
        $this->whatsapp_number = $business->whatsapp; // Ensure column exists
        $this->email = $business->email;
        $this->address = $business->address;
        $this->city = $business->city;
        $this->state = $business->state; // Ensure column exists
        $this->pincode = $business->pincode; // Ensure column exists
        $this->pan_number = $business->pan_number; // Ensure column exists
        $this->gst_number = $business->gst_number; // Ensure column exists
        $this->category_type = $business->category;
        $this->description = $business->description;

        // Media
        $this->existing_logo = $business->logo;
        $this->existing_images = is_string($business->images) ? json_decode($business->images, true) : ($business->images ?? []);
        // $this->existing_video = $business->video;

        $this->dbCategories = Category::all();
    }

    public function updateBranch()
    {
        $this->validate([
            'company_name' => 'required|min:3',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'category_type' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $business = Business::find($this->businessId);

        // Handle Logo Upload
        if ($this->logo) {
            $logoPath = $this->logo->store('business_logos', 'public');
            $business->logo = $logoPath;
        }

        // Handle Gallery Upload (Append new to existing)
        $currentImages = $this->existing_images ?? [];
        if (!empty($this->images)) {
            foreach ($this->images as $img) {
                $currentImages[] = $img->store('business_gallery', 'public');
            }
            $business->images = $currentImages;
        }

        // Update Text Fields
        $business->update([
            'name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp_number,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'pan_number' => $this->pan_number,
            'gst_number' => $this->gst_number,
            'category' => $this->category_type === 'Other' ? $this->custom_category : $this->category_type,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Branch details updated successfully!');
        
        // Refresh data
        $this->mount($this->businessId);
        $this->reset(['logo', 'images']);
    }

    public function deleteBranch()
    {
        $business = Business::find($this->businessId);
        if($business && $business->user_id == Auth::id()) {
            $business->delete();
            return redirect()->route('vendor.branches')->with('message', 'Branch deleted successfully.');
        }
    }

    public function removeGalleryImage($index)
    {
        unset($this->existing_images[$index]);
        $this->existing_images = array_values($this->existing_images);
        
        // Update DB immediately or wait for save? Let's save immediately for better UX
        Business::where('id', $this->businessId)->update(['images' => $this->existing_images]);
    }

    public function render()
    {
        return view('livewire.vendor.edit-branch')->layout('layouts.app');
    }
}