<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditPublicProfile extends Component
{
    use WithFileUploads;

    public $business_id;
    
    // Basic Info
    public $name, $slug, $phone, $email, $address, $city, $state;
    public $logo, $newLogo;

    // Header
    public $header_title, $header_subtitle;
    public $header_images = []; 
    public $new_header_images = []; 

    // Social
    public $facebook, $instagram;

    // Dynamic Sections
    public $page_sections = []; 

    public function mount()
    {
        $business = Business::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => Auth::user()->name . "'s Business",
                'slug' => Str::slug(Auth::user()->name . '-' . uniqid()),
                'email' => Auth::user()->email,
                'is_active' => true
            ]
        );

        $this->business_id = $business->id;
        $this->name = $business->name;
        $this->slug = $business->slug;
        $this->phone = $business->phone;
        $this->email = $business->email;
        $this->address = $business->address;
        $this->city = $business->city;
        $this->state = $business->state;
        $this->logo = $business->logo;

        $this->header_title = $business->header_title;
        $this->header_subtitle = $business->header_subtitle;
        $this->header_images = $business->header_images ?? [];

        // SAFETY FIX: Check if it's a string, if so, decode it. If it's null, default to []
        $hImages = $business->header_images;
        if (is_string($hImages)) $hImages = json_decode($hImages, true);
        $this->header_images = $hImages ?? [];

        $this->facebook = $business->facebook;
        $this->instagram = $business->instagram;
        
        // Load sections and ensure they have a unique ID for the frontend
        // SAFETY FIX: Ensure page_sections is strictly an array before looping
        $pSections = $business->page_sections;
        if (is_string($pSections)) $pSections = json_decode($pSections, true);
        $this->page_sections = $pSections ?? [];
        
        // Now it is safe to loop because we forced it into an array
        foreach($this->page_sections as $k => $v) {
            if(!isset($v['id'])) $this->page_sections[$k]['id'] = Str::random(10);
        }
    }

    public function addSection()
    {
        $this->page_sections[] = [
            'id' => Str::random(10), // Unique ID prevents UI bugs
            'title' => '',
            'description' => '',
            'image_path' => null,
            'new_image' => null, 
        ];
    }

    public function removeSection($index)
    {
        unset($this->page_sections[$index]);
        $this->page_sections = array_values($this->page_sections);
    }

    public function removeHeaderImage($index)
    {
        unset($this->header_images[$index]);
        $this->header_images = array_values($this->header_images);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'slug' => 'required|alpha_dash|unique:businesses,slug,' . $this->business_id,
            'new_header_images.*' => 'image|max:2048',
            'page_sections.*.new_image' => 'nullable|image|max:2048',
        ]);

        $business = Business::find($this->business_id);

        if ($this->newLogo) {
            $business->logo = $this->newLogo->store('logos', 'public');
        }

        // Header Images
        $currentImages = $this->header_images;
        if (!empty($this->new_header_images)) {
            foreach ($this->new_header_images as $img) {
                $currentImages[] = $img->store('banners', 'public');
            }
        }

        // Section Images
        foreach ($this->page_sections as $key => $section) {
            if (isset($section['new_image']) && $section['new_image']) {
                $path = $section['new_image']->store('sections', 'public');
                $this->page_sections[$key]['image_path'] = $path;
                unset($this->page_sections[$key]['new_image']); 
            }
            // Remove the temporary ID before saving to DB to keep JSON clean (optional, but good practice)
            // unset($this->page_sections[$key]['id']); 
        }

        $business->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'header_title' => $this->header_title,
            'header_subtitle' => $this->header_subtitle,
            'header_images' => $currentImages,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            // 'page_sections' => $this->page_sections, 
            'page_sections' => $updatedSections,
        ]);

        $this->new_header_images = [];
        $this->newLogo = null;
        $this->header_images = $currentImages;

        session()->flash('message', 'Public page updated successfully!');
        return redirect()->route('vendor.profile');
    }

    public function render()
    {
        return view('livewire.edit-public-profile')->layout('layouts.app');
    }
}