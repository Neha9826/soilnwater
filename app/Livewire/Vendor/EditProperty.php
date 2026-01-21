<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditProperty extends Component
{
    use WithFileUploads;

    public $propertyId;

    // Basic Fields (Price removed)
    public $title, $description;
    public $type;          
    
    // Location
    public $address, $city, $state;
    public $google_map_link, $google_embed_link;

    // Media
    public $existing_images = []; 
    public $new_images = [];
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
        $property = Property::with(['floors', 'amenities'])->findOrFail($id);
        
        if ($property->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->propertyId = $property->id;

        $this->title = $property->title;
        $this->description = $property->description;
        // We DO NOT load price or listing_type here as they are managed via the "Sell" modal
        $this->type = $property->type;
        
        $this->address = $property->address;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->google_map_link = $property->google_map_link;
        $this->google_embed_link = $property->google_embed_link;

        $this->existing_images = $property->images ?? [];
        $this->existing_videos = $property->videos ?? [];
        $this->existing_documents = $property->documents ?? [];

        $this->available_amenities = Amenity::all();
        $this->selected_amenities = $property->amenities->pluck('id')->toArray();

        foreach ($property->floors as $floor) {
            $this->floors[] = [
                'id' => $floor->id,
                'floor_name' => $floor->floor_name,
                'area_sqft' => $floor->area_sqft,
                'rooms' => $floor->rooms,
                'description' => $floor->description,
                'image_path' => $floor->image_path,
                'new_image' => null,
            ];
        }
    }

    public function addFloor()
    {
        $this->floors[] = [
            'id' => 'new_' . Str::random(5),
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
        $floorData = $this->floors[$index];
        if (is_numeric($floorData['id'])) {
            PropertyFloor::find($floorData['id'])->delete();
        }
        unset($this->floors[$index]);
        $this->floors = array_values($this->floors);
    }

    public function removeImage($key)
    {
        unset($this->existing_images[$key]);
        $this->existing_images = array_values($this->existing_images);
    }

    public function removeVideo($key)
    {
        unset($this->existing_videos[$key]);
        $this->existing_videos = array_values($this->existing_videos);
    }

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
            'type' => 'required',
            'new_images.*' => 'nullable|image|max:2048',
            'floors.*.floor_name' => 'required',
        ]);

        $property = Property::find($this->propertyId);

        // Update Info (Exclude Price/Listing Type)
        $property->update([
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'google_map_link' => $this->google_map_link,
            'google_embed_link' => $this->google_embed_link,
        ]);

        // Handle Media
        foreach ($this->new_images as $img) {
            $this->existing_images[] = $img->store('properties/images', 'public');
        }
        foreach ($this->new_videos as $vid) {
            $this->existing_videos[] = $vid->store('properties/videos', 'public');
        }
        foreach ($this->new_documents as $doc) {
            $this->existing_documents[] = $doc->store('properties/docs', 'public');
        }

        $property->update([
            'images' => $this->existing_images,
            'videos' => $this->existing_videos,
            'documents' => $this->existing_documents,
        ]);

        // Update Floors
        foreach ($this->floors as $floorData) {
            $path = $floorData['image_path'];
            if (isset($floorData['new_image']) && $floorData['new_image']) {
                $path = $floorData['new_image']->store('properties/floors', 'public');
            }

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

        $property->amenities()->sync($this->selected_amenities);

        session()->flash('message', 'Project updated successfully!');
        return redirect()->route('vendor.properties');
    }

    public function render()
    {
        return view('livewire.vendor.edit-property')->layout('layouts.app');
    }
}