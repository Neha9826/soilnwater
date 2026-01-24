<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateAd extends Component
{
    use WithFileUploads;

    public $mode = 'upload'; // 'upload' or 'builder'
    
    // Common Fields
    public $title;
    public $target_link;

    // Mode 1: Upload Pre-designed
    public $uploaded_file;

    // Mode 2: Builder State
    public $canvas_size = 'square'; // square (1:1), story (9:16), banner (4:1)
    public $bg_color = '#ffffff';
    public $layers = []; // Stores text/image elements
    public $generated_image_data; // Base64 string from frontend

    // Temporary upload for builder image layers
    public $temp_layer_image; 

    protected $rules = [
        'title' => 'required|min:3',
        'mode' => 'required',
    ];

    // --- BUILDER ACTIONS ---

    public function updatedTempLayerImage()
    {
        $this->validate(['temp_layer_image' => 'image|max:2048']);
        
        // Store temporarily and add as a layer
        $url = $this->temp_layer_image->temporaryUrl();
        
        // We dispatch an event to Alpine to add this image layer
        $this->dispatch('add-image-layer', url: $url);
        
        // Reset input
        $this->reset('temp_layer_image');
    }

    public function save()
    {
        $this->validate();

        $finalImagePath = null;
        $designData = null;

        if ($this->mode === 'upload') {
            $this->validate(['uploaded_file' => 'required|image|max:5120']);
            $finalImagePath = $this->uploaded_file->store('ads/uploads', 'public');
        } 
        else {
            // Builder Mode
            $this->validate(['generated_image_data' => 'required']);
            
            // 1. Decode Base64 Image
            $image_parts = explode(";base64,", $this->generated_image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_base64 = base64_decode($image_parts[1]);
            
            // 2. Save Image File
            $filename = 'ads/builder/' . uniqid() . '.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $image_base64);
            $finalImagePath = $filename;

            // 3. Save Design JSON (Passed from frontend)
            $designData = $this->layers; 
        }

        Ad::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'type' => $this->mode,
            'size_format' => $this->canvas_size,
            'final_image_path' => $finalImagePath,
            'design_data' => $designData,
            'target_link' => $this->target_link,
            'is_active' => true,
        ]);

        session()->flash('message', 'Ad created successfully!');
        return redirect()->route('customer.listings'); // Redirects to the Tabs page
    }

    public function render()
    {
        return view('livewire.customer.create-ad')->layout('layouts.app');
    }
}