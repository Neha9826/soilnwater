<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostProject extends Component
{
    use WithFileUploads;

    public $title, $description, $price;
    public $type;
    public $project_status = 'Upcoming'; 
    
    public $address, $city, $state;
    public $google_map_link, $google_embed_link;

    public $images = [];
    public $videos = [];
    public $documents = [];
    
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
        'project_status' => 'required',
        'city' => 'required',
        'images.*' => 'image|max:5120',
        'videos.*' => 'mimes:mp4,mov,ogg,qt|max:51200',
    ];

    public function addCustomAmenity()
    {
        $this->validate(['new_amenity_name' => 'required|string|min:2|max:50']);
        $existing = Amenity::where('name', 'LIKE', $this->new_amenity_name)->first();

        if ($existing) {
            if (!in_array($existing->id, $this->selected_amenities)) $this->selected_amenities[] = $existing->id;
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

        // 1. Save Files
        $imgPaths = [];
        foreach ($this->images as $img) $imgPaths[] = $img->store('projects/images', 'public');

        $vidPaths = [];
        foreach ($this->videos as $vid) $vidPaths[] = $vid->store('projects/videos', 'public');

        $docPaths = [];
        foreach ($this->documents as $doc) $docPaths[] = $doc->store('projects/docs', 'public');

        // 2. Create Project
        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title . '-' . uniqid()),
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'project_status' => $this->project_status,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'google_map_link' => $this->google_map_link,
            'google_embed_link' => $this->google_embed_link,
            'images' => $imgPaths,
            'videos' => $vidPaths,
            'documents' => $docPaths,
            'is_active' => true,
        ]);

        $project->amenities()->attach($this->selected_amenities);

        session()->flash('message', 'Project Posted Successfully!');
        return redirect()->route('customer.my-projects');
    }

    public function render()
    {
        return view('livewire.customer.post-project')->layout('layouts.app');
    }
}