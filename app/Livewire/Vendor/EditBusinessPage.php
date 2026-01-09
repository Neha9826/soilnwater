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
    public $store_logo; 
    public $existing_logo; 
    public $header_images = []; 
    public $existing_headers = []; 
    
    // Dynamic Sections
    public $sections = []; 

    // FIX IS HERE: No $id parameter needed anymore!
    public function mount()
    {
        $user = Auth::user();

        // Load data from USER table
        $this->store_name = $user->store_name ?? $user->name . "'s Business";
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

    public function removeHeaderImage($index)
    {
        unset($this->existing_headers[$index]);
        $this->existing_headers = array_values($this->existing_headers);
    }

    public function save()
    {
        $this->validate([
            'store_name' => 'required|min:3',
            'header_images.*' => 'image|max:2048',
            'store_logo' => 'nullable|image|max:1024',
            'sections.*.title' => 'nullable|string',
            'sections.*.description' => 'nullable|string',
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
        $processedSections = $this->sections;
        foreach ($processedSections as $key => $section) {
            if (isset($section['new_image']) && !empty($section['new_image'])) {
                $path = $section['new_image']->store('section-images', 'public');
                $processedSections[$key]['image_path'] = $path;
                unset($processedSections[$key]['new_image']);
            }
        }

        // 4. Save to User Table
        $user->update([
            'store_name' => $this->store_name,
            'store_slug' => Str::slug($this->store_name),
            'address' => $this->address,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'header_title' => $this->header_title,
            'header_subtitle' => $this->header_subtitle,
            'header_images' => $headerPaths,
            'page_sections' => $processedSections, 
        ]);

        session()->flash('message', 'Your website has been published successfully!');
        
        // Refresh state
        $this->mount(); // Reload data
        $this->reset(['store_logo', 'header_images']); // Clear inputs
    }

    public function render()
    {
        return view('livewire.vendor.edit-business-page', [
            // Pass the slug for the Preview button
            'current_slug' => Auth::user()->store_slug
        ])->layout('layouts.app');
    }
}