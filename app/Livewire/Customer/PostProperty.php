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
    public $selected_amenities = [];
    public $available_amenities = [];
    
    // NEW: Custom Amenity Input
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
    ];

    // --- NEW: Function to Add Custom Amenity ---
    public function addCustomAmenity()
    {
        // 1. Basic Validation
        $this->validate(['new_amenity_name' => 'required|string|min:2|max:50']);

        // 2. Check if it already exists (Case Insensitive)
        $existing = Amenity::where('name', 'LIKE', $this->new_amenity_name)->first();

        if ($existing) {
            // If exists, just check it (don't create duplicate)
            if (!in_array($existing->id, $this->selected_amenities)) {
                $this->selected_amenities[] = $existing->id;
            }
        } else {
            // If doesn't exist, create it
            $new = Amenity::create(['name' => ucfirst(trim($this->new_amenity_name))]);
            // Refresh list so it shows up
            $this->available_amenities = Amenity::all();
            // Automatically check the new box
            $this->selected_amenities[] = $new->id;
        }

        // 3. Clear Input
        $this->new_amenity_name = '';
    }

    public function save()
    {
        $this->validate();

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