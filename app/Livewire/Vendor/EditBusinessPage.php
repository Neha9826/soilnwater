<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditBusinessPage extends Component
{
    use WithFileUploads;

    public $store_name, $store_slug, $address, $facebook, $instagram;
    public $header_title, $header_subtitle;
    
    public $store_logo; 
    public $existing_logo; 
    
    // Initialize as Empty Arrays
    public $header_images = []; 
    public $existing_headers = []; 
    public $sections = []; 

    public function mount()
    {
        $user = Auth::user();

        $this->store_name = $user->store_name ?? $user->name . "'s Business";
        $this->store_slug = $user->store_slug;
        $this->address = $user->address;
        $this->facebook = $user->facebook;
        $this->instagram = $user->instagram;
        
        $this->header_title = $user->header_title;
        $this->header_subtitle = $user->header_subtitle;
        $this->existing_logo = $user->store_logo;

        // CRITICAL FIX: Ensure existing_headers is ALWAYS an array
        if (!empty($user->header_images)) {
            $decoded = is_string($user->header_images) ? json_decode($user->header_images, true) : $user->header_images;
            $this->existing_headers = is_array($decoded) ? $decoded : [];
        } else {
            $this->existing_headers = [];
        }

        // CRITICAL FIX: Ensure sections is ALWAYS an array
        if (!empty($user->page_sections)) {
            $decodedSec = is_string($user->page_sections) ? json_decode($user->page_sections, true) : $user->page_sections;
            $this->sections = is_array($decodedSec) ? $decodedSec : [];
        } else {
            $this->sections = [['title' => '', 'description' => '', 'image_path' => null]];
        }
    }

    public function addSection()
    {
        $this->sections[] = ['title' => '', 'description' => '', 'image_path' => null];
    }

    public function removeSection($index)
    {
        unset($this->sections[$index]);
        $this->sections = array_values($this->sections);
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
        ]);

        $user = Auth::user();

        if ($this->store_logo) {
            $user->store_logo = $this->store_logo->store('uploads', 'public');
        }

        $headerPaths = $this->existing_headers;
        foreach ($this->header_images as $img) {
            $headerPaths[] = $img->store('vendor-headers', 'public');
        }

        $processedSections = $this->sections;
        foreach ($processedSections as $key => $section) {
            if (isset($section['new_image']) && !empty($section['new_image'])) {
                $path = $section['new_image']->store('section-images', 'public');
                $processedSections[$key]['image_path'] = $path;
                unset($processedSections[$key]['new_image']);
            }
        }

        $user->update([
            'store_name' => $this->store_name,
            'store_slug' => Str::slug($this->store_name),
            'header_title' => $this->header_title,
            'header_subtitle' => $this->header_subtitle,
            'header_images' => $headerPaths, 
            'page_sections' => $processedSections, 
        ]);

        session()->flash('message', 'Website updated successfully!');
        
        $this->mount(); 
        $this->reset(['store_logo', 'header_images']); 
    }

    public function render()
    {
        return view('livewire.vendor.edit-business-page', [
            'current_slug' => Auth::user()->store_slug
        ])->layout('layouts.app');
    }
}