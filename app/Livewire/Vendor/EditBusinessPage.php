<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class EditBusinessPage extends Component
{
    use WithFileUploads;

    public $store_name, $store_slug, $about_text, $address;
    public $facebook, $instagram;

    public $header_images = []; // New Uploads
    public $existing_headers = []; // Saved Images

    public function mount()
    {
        $user = Auth::user();

        // Security: Kick out regular customers
        if($user->profile_type === 'customer') {
            return redirect()->route('dashboard');
        }

        $this->store_name = $user->store_name;
        $this->store_slug = $user->store_slug;
        $this->about_text = $user->about_text;
        $this->address = $user->address;
        $this->facebook = $user->facebook;
        $this->instagram = $user->instagram;
        $this->existing_headers = $user->header_images ?? [];
    }

    public function save()
    {
        $this->validate([
            'store_name' => 'required|min:3',
            'about_text' => 'required|min:10',
            'header_images.*' => 'image|max:2048', // 2MB Max per image
        ]);

        $user = Auth::user();

        // 1. Handle New Image Uploads
        $imagePaths = $this->existing_headers; // Start with old ones

        foreach ($this->header_images as $image) {
            $imagePaths[] = $image->store('vendor-headers', 'public');
        }

        // 2. Save Everything
        $user->update([
            'store_name' => $this->store_name,
            'store_slug' => \Illuminate\Support\Str::slug($this->store_name),
            'about_text' => $this->about_text,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'header_images' => $imagePaths,
        ]);

        session()->flash('message', 'Your Business Page has been updated!');

        // Reset upload input
        $this->header_images = [];
        $this->existing_headers = $imagePaths; 
    }

    public function removeImage($index)
    {
        unset($this->existing_headers[$index]);
        $this->existing_headers = array_values($this->existing_headers); // Re-index array
    }

    public function render()
    {
        return view('livewire.vendor.edit-business-page');
    }
}