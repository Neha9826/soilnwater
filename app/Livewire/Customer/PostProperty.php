<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostProperty extends Component
{
    use WithFileUploads;

    // --- Basic Details ---
    public $title, $description, $price;
    public $type;          
    public $listing_type;  
    
    // --- Extra Customer Fields ---
    public $poster_type = 'Owner';
    public $is_govt_registered = false;

    // --- Location ---
    public $address, $city, $state;
    public $google_map_link, $google_embed_link;

    // --- Media & Amenities ---
    public $images = [];
    public $video; // Temp property for upload
    public $selected_amenities = [];
    public $available_amenities = [];
    
    public $new_amenity_name = '';

    public function mount()
    {
        $this->available_amenities = Amenity::all();
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
        'images.*' => 'image|max:5120',
        'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:51200', 
    ];

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

    public function save()
    {
        $this->validate();

        // 1. Handle Video Upload
        // We store it as an array to match the 'videos' plural column type (longtext/json)
        $videoPaths = [];
        if ($this->video) {
            $videoPaths[] = $this->video->store('properties/videos', 'public');
        }

        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title . '-' . uniqid()),
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
            'google_embed_link' => $this->google_embed_link,
            'videos' => $videoPaths, // FIX: Saving to 'videos' column as array
            'is_active' => true, 
        ]);

        $imagePaths = [];
        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('properties/customer', 'public');
        }
        $property->update(['images' => $imagePaths]);

        $property->amenities()->attach($this->selected_amenities);

        session()->flash('message', 'Your ad has been posted successfully!');
        
        return redirect()->route('customer.my-posts');
    }

    public function render()
    {
        return view('livewire.customer.post-property')->layout('layouts.app');
    }
}