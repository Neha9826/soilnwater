<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;

class EditProject extends Component
{
    use WithFileUploads;

    public $projectId;
    public $title, $description, $price, $type, $project_status;
    public $address, $city, $state, $google_map_link;
    
    public $existing_images = [], $new_images = [];
    public $existing_videos = [], $new_videos = [];
    
    public $selected_amenities = [];
    public $available_amenities = [];
    public $new_amenity_name = '';

    public function mount($id)
    {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->price = $project->price;
        $this->type = $project->type;
        $this->project_status = $project->project_status;
        $this->address = $project->address;
        $this->city = $project->city;
        $this->state = $project->state;
        $this->google_map_link = $project->google_map_link;
        
        $this->existing_images = $project->images ?? [];
        $this->existing_videos = $project->videos ?? [];
        
        $this->available_amenities = Amenity::all();
        $this->selected_amenities = $project->amenities->pluck('id')->toArray();
    }

    protected $rules = [
        'title' => 'required|min:5',
        'price' => 'required|numeric',
        'type' => 'required',
        'city' => 'required',
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

    public function update()
    {
        $this->validate();
        $project = Project::find($this->projectId);

        // Merge Media
        foreach ($this->new_images as $img) $this->existing_images[] = $img->store('projects/images', 'public');
        foreach ($this->new_videos as $vid) $this->existing_videos[] = $vid->store('projects/videos', 'public');

        $project->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'project_status' => $this->project_status,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'google_map_link' => $this->google_map_link,
            'images' => $this->existing_images,
            'videos' => $this->existing_videos,
        ]);

        $project->amenities()->sync($this->selected_amenities);

        session()->flash('message', 'Project updated successfully!');
        return redirect()->route('customer.my-projects');
    }

    public function removeImage($index)
    {
        unset($this->existing_images[$index]);
        $this->existing_images = array_values($this->existing_images);
    }

    public function render()
    {
        return view('livewire.customer.edit-project')->layout('layouts.app');
    }
}