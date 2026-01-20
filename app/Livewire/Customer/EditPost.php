<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $propertyId;
    
    // Basic Details
    public $title, $description, $price;
    public $type, $listing_type;
    public $poster_type, $is_govt_registered;
    public $address, $city, $state;
    public $google_map_link;
    
    // Media & Amenities
    public $existing_images = [];
    public $new_images = [];
    public $selected_amenities = [];
    public $available_amenities = [];
    public $new_amenity_name = '';

    public function mount($id)
    {
        // Fetch property and ensure ownership
        $property = Property::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->propertyId = $property->id;
        $this->title = $property->title;
        $this->description = $property->description;
        $this->price = $property->price;
        $this->type = $property->type;
        $this->listing_type = $property->listing_type;
        $this->poster_type = $property->poster_type;
        $this->is_govt_registered = (bool) $property->is_govt_registered;
        $this->address = $property->address;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->google_map_link = $property->google_map_link;
        $this->existing_images = $property->images ?? [];
        
        $this->available_amenities = Amenity::all();
        $this->selected_amenities = $property->amenities->pluck('id')->toArray();
    }

    protected $rules = [
        'title' => 'required|min:5',
        'price' => 'required|numeric',
        'type' => 'required',
        'listing_type' => 'required',
        'poster_type' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'new_images.*' => 'image|max:5120',
    ];

    // Add Custom Amenity Logic
    public function addCustomAmenity()
    {
        $this->validate(['new_amenity_name' => 'required|string|min:2|max:50']);
        $existing = Amenity::where('name', 'LIKE', $this->new_amenity_name)->first();

        if ($existing) {
            if (!in_array($existing->id, $this->selected_amenities)) {
                $this->selected_amenities[] = $existing->id;
            }
        } else {
            $new = Amenity::create(['name' => ucfirst(trim($this->new_amenity_name))]);
            $this->available_amenities = Amenity::all();
            $this->selected_amenities[] = $new->id;
        }
        $this->new_amenity_name = '';
    }

    public function removeImage($index)
    {
        unset($this->existing_images[$index]);
        $this->existing_images = array_values($this->existing_images);
    }

    public function update()
    {
        $this->validate();

        $property = Property::find($this->propertyId);
        
        $property->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'poster_type' => $this->poster_type,
            'is_govt_registered' => $this->is_govt_registered,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'google_map_link' => $this->google_map_link,
        ]);

        // Handle Images
        $currentImages = $this->existing_images;
        foreach ($this->new_images as $img) {
            $currentImages[] = $img->store('properties/customer', 'public');
        }
        $property->update(['images' => $currentImages]);

        $property->amenities()->sync($this->selected_amenities);

        session()->flash('message', 'Ad updated successfully!');
        return redirect()->route('customer.my-posts');
    }

    public function delete()
    {
        $property = Property::find($this->propertyId);
        if ($property) {
            $property->delete();
            session()->flash('message', 'Ad deleted successfully.');
            return redirect()->route('customer.my-posts');
        }
    }

    public function render()
    {
        return view('livewire.customer.edit-post')->layout('layouts.app');
    }
}