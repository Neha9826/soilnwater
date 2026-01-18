<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditProperty extends Component
{
    use WithFileUploads;

    public $propertyId; // To know which property we are editing

    // Basic Fields
    public $title, $description, $price;
    public $type;          
    public $listing_type;  
    
    // Location
    public $address, $city, $state;
    public $google_map_link, $google_embed_link;

    // Media
    public $existing_images = []; // URLs from DB
    public $new_images = [];      // Fresh uploads
    
    public $existing_videos = [];
    public $new_videos = [];

    public $existing_documents = [];
    public $new_documents = [];

    // Floor Plans
    public $floors = []; 

    // Amenities
    public $available_amenities = [];
    public $selected_amenities = [];
    public $new_amenity_name = '';

    public function mount($id)
    {
        // 1. Load Property & Check Ownership
        $property = Property::with(['floors', 'amenities'])->findOrFail($id);
        
        if ($property->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->propertyId = $property->id;

        // 2. Fill Basic Fields
        $this->title = $property->title;
        $this->description = $property->description;
        $this->price = $property->price;
        $this->type = $property->type;
        $this->listing_type = $property->listing_type;
        $this->address = $property->address;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->google_map_link = $property->google_map_link;
        $this->google_embed_link = $property->google_embed_link;

        // 3. Fill Media
        $this->existing_images = $property->images ?? [];
        $this->existing_videos = $property->videos ?? [];
        $this->existing_documents = $property->documents ?? [];

        // 4. Fill Amenities
        $this->available_amenities = Amenity::all();
        $this->selected_amenities = $property->amenities->pluck('id')->toArray();

        // 5. Fill Floors (Convert Collection to Array for Repeater)
        foreach ($property->floors as $floor) {
            $this->floors[] = [
                'id' => $floor->id, // Real DB ID
                'floor_name' => $floor->floor_name,
                'area_sqft' => $floor->area_sqft,
                'rooms' => $floor->rooms,
                'description' => $floor->description,
                'image_path' => $floor->image_path, // Existing image
                'new_image' => null, // Placeholder for potential update
            ];
        }
    }

    public function addFloor()
    {
        $this->floors[] = [
            'id' => 'new_' . Str::random(5), // Temporary ID
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
        // Check if it's a real floor (has numeric ID)
        $floorData = $this->floors[$index];
        if (is_numeric($floorData['id'])) {
            // Delete from DB immediately
            PropertyFloor::find($floorData['id'])->delete();
        }
        
        unset($this->floors[$index]);
        $this->floors = array_values($this->floors);
    }

    // Remove a specific existing image
    public function removeImage($key)
    {
        unset($this->existing_images[$key]);
        $this->existing_images = array_values($this->existing_images);
    }

    // --- NEW: Remove Video ---
    public function removeVideo($key)
    {
        unset($this->existing_videos[$key]);
        $this->existing_videos = array_values($this->existing_videos);
    }

    // --- NEW: Remove Document ---
    public function removeDocument($key)
    {
        unset($this->existing_documents[$key]);
        $this->existing_documents = array_values($this->existing_documents);
    }

    public function createNewAmenity()
    {
        $this->validate(['new_amenity_name' => 'required|string|min:2|unique:amenities,name']);
        $amenity = Amenity::create(['name' => $this->new_amenity_name]);
        $this->available_amenities = Amenity::all();
        $this->selected_amenities[] = $amenity->id;
        $this->new_amenity_name = '';
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|min:5',
            'price' => 'required|numeric',
            'type' => 'required',
            'listing_type' => 'required',
            'new_images.*' => 'nullable|image|max:2048',
            'floors.*.floor_name' => 'required',
        ]);

        $property = Property::find($this->propertyId);

        // 1. Update Basic Info
        $property->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'google_map_link' => $this->google_map_link,
            'google_embed_link' => $this->google_embed_link,
        ]);

        // 2. Handle Media Merging (Existing + New)
        // Add new uploads to the array
        foreach ($this->new_images as $img) {
            $this->existing_images[] = $img->store('properties/images', 'public');
        }
        foreach ($this->new_videos as $vid) {
            $this->existing_videos[] = $vid->store('properties/videos', 'public');
        }
        foreach ($this->new_documents as $doc) {
            $this->existing_documents[] = $doc->store('properties/docs', 'public');
        }

        // Save merged arrays back to DB
        $property->update([
            'images' => $this->existing_images, // This includes old kept ones + new ones
            'videos' => $this->existing_videos,
            'documents' => $this->existing_documents,
        ]);

        // 3. Update/Create Floors
        foreach ($this->floors as $floorData) {
            $path = $floorData['image_path'];
            
            // If a new floor image was uploaded, replace the path
            if (isset($floorData['new_image']) && $floorData['new_image']) {
                $path = $floorData['new_image']->store('properties/floors', 'public');
            }

            // Update or Create
            PropertyFloor::updateOrCreate(
                ['id' => is_numeric($floorData['id']) ? $floorData['id'] : null],
                [
                    'property_id' => $property->id,
                    'floor_name' => $floorData['floor_name'],
                    'area_sqft' => $floorData['area_sqft'],
                    'rooms' => $floorData['rooms'],
                    'description' => $floorData['description'],
                    'image_path' => $path,
                ]
            );
        }

        // 4. Sync Amenities
        $property->amenities()->sync($this->selected_amenities);

        session()->flash('message', 'Property updated successfully!');
        return redirect()->route('vendor.properties');
    }

    public function render()
    {
        return view('livewire.vendor.edit-property')->layout('layouts.app');
    }
}