<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateProperty extends Component
{
    use WithFileUploads;

    // Basic Fields
    public $title, $description, $price, $type;
    
    // Location
    public $address, $city, $state;
    public $google_map_link, $google_embed_link; // <--- NEW FIELDS

    // Media
    public $images = [];
    public $videos = [];
    public $documents = [];

    // Floor Plans
    public $floors = []; 

    // Amenities
    public $available_amenities = [];
    public $selected_amenities = [];
    public $new_amenity_name = '';

    public function mount()
    {
        $this->available_amenities = Amenity::all();
        $this->addFloor();
    }

    public function addFloor()
    {
        $this->floors[] = [
            'id' => Str::random(10),
            'floor_name' => '',
            'area_sqft' => '',
            'rooms' => '',
            'description' => '',
            'image_path' => null,
            'new_image' => null,
        ];
    }

    public function removeFloor($index)
    {
        unset($this->floors[$index]);
        $this->floors = array_values($this->floors);
    }

    public function createNewAmenity()
    {
        $this->validate(['new_amenity_name' => 'required|string|min:2|unique:amenities,name']);
        $amenity = Amenity::create(['name' => $this->new_amenity_name]);
        $this->available_amenities = Amenity::all();
        $this->selected_amenities[] = $amenity->id;
        $this->new_amenity_name = '';
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:5',
            'type' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|max:2048',
            'videos.*' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20480',
            'documents.*' => 'mimes:pdf,doc,docx|max:5120',
            'floors.*.floor_name' => 'required',
            'selected_amenities' => 'array',
            'google_map_link' => 'nullable|url', // Basic URL validation
            'google_embed_link' => 'nullable|string',
        ]);

        // 1. Create Property
        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title . '-' . uniqid()),
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            
            // NEW MAP FIELDS
            'google_map_link' => $this->google_map_link,
            'google_embed_link' => $this->google_embed_link,
            
            'is_active' => true,
        ]);

        // 2. Handle Media
        $imagePaths = [];
        foreach ($this->images as $img) $imagePaths[] = $img->store('properties/images', 'public');
        
        $videoPaths = [];
        foreach ($this->videos as $vid) $videoPaths[] = $vid->store('properties/videos', 'public');
        
        $docPaths = [];
        foreach ($this->documents as $doc) $docPaths[] = $doc->store('properties/docs', 'public');

        $property->update([
            'images' => $imagePaths,
            'videos' => $videoPaths,
            'documents' => $docPaths,
        ]);

        // 3. Save Floors
        foreach ($this->floors as $floorData) {
            $floorImgPath = null;
            if (isset($floorData['new_image']) && $floorData['new_image']) {
                $floorImgPath = $floorData['new_image']->store('properties/floors', 'public');
            }

            PropertyFloor::create([
                'property_id' => $property->id,
                'floor_name' => $floorData['floor_name'],
                'area_sqft' => $floorData['area_sqft'],
                'rooms' => $floorData['rooms'],
                'description' => $floorData['description'],
                'image_path' => $floorImgPath,
            ]);
        }

        // 4. Attach Amenities
        $property->amenities()->attach($this->selected_amenities);

        session()->flash('message', 'Property created successfully!');
        return redirect()->route('vendor.properties');
    }

    public function render()
    {
        return view('livewire.vendor.create-property')->layout('layouts.app');
    }
}