<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditBusinessPage extends Component
{
    use WithFileUploads;

    // Basic Info
    public $store_name, $store_slug, $address, $facebook, $instagram;
    public $header_title, $header_subtitle;
    
    // Images
    public $store_logo; // New Upload
    public $existing_logo; // Saved
    public $header_images = []; // New Uploads
    public $existing_headers = []; // Saved
    
    // Dynamic Sections
    public $sections = []; // Array of [title, description, image(temp), image_path(saved)]

    public function mount()
    {
        $user = Auth::user();
        if($user->profile_type === 'customer') return redirect()->route('dashboard');

        $this->store_name = $user->store_name;
        $this->store_slug = $user->store_slug;
        $this->address = $user->address;
        $this->facebook = $user->facebook;
        $this->instagram = $user->instagram;
        
        $this->header_title = $user->header_title;
        $this->header_subtitle = $user->header_subtitle;
        $this->existing_logo = $user->store_logo;
        $this->existing_headers = $user->header_images ?? [];
        
        // Load existing sections or start with one empty one
        $this->sections = $user->page_sections ?? [['title' => '', 'description' => '', 'image_path' => null]];
    }

    public function addSection()
    {
        $this->sections[] = ['title' => '', 'description' => '', 'image_path' => null];
    }

    public function removeSection($index)
    {
        unset($this->sections[$index]);
        $this->sections = array_values($this->sections); // Re-index
    }

    public function save()
    {
        $this->validate([
            'store_name' => 'required|min:3',
            'header_images.*' => 'image|max:2048',
            'store_logo' => 'nullable|image|max:1024',
            'sections.*.title' => 'nullable|string',
            'sections.*.description' => 'nullable|string',
            'sections.*.new_image' => 'nullable|image|max:2048', // Validation for section images
        ]);

        $user = Auth::user();

        // 1. Handle Logo
        if ($this->store_logo) {
            $user->store_logo = $this->store_logo->store('uploads', 'public');
        }

        // 2. Handle Header Images
        $headerPaths = $this->existing_headers;
        foreach ($this->header_images as $img) {
            $headerPaths[] = $img->store('vendor-headers', 'public');
        }

        // 3. Handle Dynamic Section Images
        // We loop through sections to see if a NEW image was uploaded
        $processedSections = $this->sections;
        
        foreach ($processedSections as $key => $section) {
            // Check if there is a 'new_image' uploaded in this section
            if (isset($section['new_image']) && !empty($section['new_image'])) {
                // Store the image
                $path = $section['new_image']->store('section-images', 'public');
                
                // Save the path to 'image_path'
                $processedSections[$key]['image_path'] = $path;
                
                // Remove the temporary file object so we don't try to save it to DB
                unset($processedSections[$key]['new_image']);
            }
        }

        $user->update([
            'store_name' => $this->store_name,
            'store_slug' => Str::slug($this->store_name),
            'address' => $this->address,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'header_title' => $this->header_title,
            'header_subtitle' => $this->header_subtitle,
            'header_images' => $headerPaths,
            'page_sections' => $processedSections, // Save the processed array
        ]);

        session()->flash('message', 'Your website has been published successfully!');
        
        // Refresh state
        $this->header_images = [];
        $this->existing_headers = $headerPaths;
        $this->sections = $processedSections; // Update local state to show new images
    }

    public function removeHeaderImage($index)
    {
        unset($this->existing_headers[$index]);
        $this->existing_headers = array_values($this->existing_headers);
    }

    public function render()
    {
        return view('livewire.vendor.edit-business-page');
    }
}