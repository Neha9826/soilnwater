<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\PageSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditBusinessPage extends Component
{
    use WithFileUploads;

    public $business_id;
    
    // Header & Branding
    public $header_title, $header_subtitle;
    public $store_logo, $existing_logo;
    public $header_images = []; // New uploads
    public $existing_headers = []; // Old paths
    
    // Contact
    public $store_name, $address, $facebook, $instagram;

    // Sections (Array of arrays)
    public $sections = [];

    public function mount($id) // <--- Add $id here
    {
        // Find the SPECIFIC business matching the ID and the User
        $business = Business::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $this->business_id = $business->id;

        // ... (Keep the rest of your loading logic the same) ...
        $this->header_title = $business->header_title;
        $this->header_subtitle = $business->header_subtitle;
        $this->existing_logo = $business->logo;
        $this->store_name = $business->name;
        $this->address = $business->address;
        $this->facebook = $business->facebook_link ?? '';
        $this->instagram = $business->instagram_link ?? '';
        $this->existing_headers = $business->header_images ?? [];

        foreach($business->sections as $section) {
            $this->sections[] = [
                'id' => $section->id,
                'title' => $section->title,
                'description' => $section->description,
                'image_path' => $section->image_path,
                'new_image' => null,
            ];
        }
    }

    public function addSection()
    {
        $this->sections[] = [
            'id' => null, // New section
            'title' => '',
            'description' => '',
            'image_path' => null,
            'new_image' => null,
        ];
    }

    public function removeSection($index)
    {
        $section = $this->sections[$index];
        
        // If it exists in DB, delete it
        if (!empty($section['id'])) {
            PageSection::find($section['id'])->delete();
        }
        
        unset($this->sections[$index]);
        $this->sections = array_values($this->sections); // Re-index array
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
            'header_title' => 'nullable|max:100',
        ]);

        $business = Business::find($this->business_id);

        // 1. Handle Logo
        if ($this->store_logo) {
            $logoPath = $this->store_logo->store('logos', 'public');
            $business->logo = $logoPath;
        }

        // 2. Handle Header Images
        $finalHeaderImages = $this->existing_headers;
        foreach ($this->header_images as $img) {
            $finalHeaderImages[] = $img->store('headers', 'public');
        }

        // 3. Update Business Main Data
        $business->update([
            'name' => $this->store_name,
            'header_title' => $this->header_title,
            'header_subtitle' => $this->header_subtitle,
            'address' => $this->address,
            'facebook_link' => $this->facebook,
            'instagram_link' => $this->instagram,
            'header_images' => $finalHeaderImages,
        ]);

        // 4. Handle Dynamic Sections
        foreach ($this->sections as $index => $data) {
            
            // Upload new section image if present
            $imagePath = $data['image_path'];
            if (isset($data['new_image']) && $data['new_image']) {
                $imagePath = $data['new_image']->store('sections', 'public');
            }

            // Create or Update
            PageSection::updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'business_id' => $this->business_id,
                    'title' => $data['title'],
                    'description' => $data['description'], // Trix content
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]
            );
        }

        session()->flash('message', 'Website updated successfully!');
        return redirect()->route('dashboard'); // Or stay on page
    }

    public function render()
    {
        return view('livewire.edit-business-page')->layout('layouts.app');
    }
}