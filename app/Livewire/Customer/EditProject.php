<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProject extends Component
{
    use WithFileUploads;

    public $projectId;
    public $title, $description, $price, $type, $project_status;
    public $address, $city, $state, $google_map_link;
    
    public $existing_images = [], $new_images = [];
    public $existing_videos = [], $new_videos = [];
    
    public $selected_amenities = [];
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
        
        // Ensure these are arrays
        $this->existing_images = is_array($project->images) ? $project->images : json_decode($project->images, true) ?? [];
        $this->existing_videos = is_array($project->videos) ? $project->videos : json_decode($project->videos, true) ?? [];
        
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
            if (!in_array($existing->id, $this->selected_amenities)) {
                $this->selected_amenities[] = $existing->id;
            }
        } else {
            $new = Amenity::create(['name' => ucfirst(trim($this->new_amenity_name))]);
            $this->selected_amenities[] = $new->id;
        }
        $this->new_amenity_name = '';
    }

    public function update()
    {
        $this->validate();

        $project = Project::where('id', $this->projectId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 1. Process New Images
        // We loop through the temporary file objects and store them
        if (!empty($this->new_images)) {
            foreach ($this->new_images as $img) {
                // Store the file and add the path to our existing array
                $path = $img->store('projects/images', 'public');
                $this->existing_images[] = $path;
            }
        }

        // 2. Process New Videos (Similar logic)
        if (!empty($this->new_videos)) {
            foreach ($this->new_videos as $vid) {
                $path = $vid->store('projects/videos', 'public');
                $this->existing_videos[] = $path;
            }
        }

        // 3. Update the Database
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
            'images' => $this->existing_images, // This now contains both old and new paths
            'videos' => $this->existing_videos,
        ]);

        // 4. Sync Amenities
        $project->amenities()->sync($this->selected_amenities);

        // Clear the temporary upload arrays so they don't show up again if the user stays on the page
        $this->new_images = [];
        $this->new_videos = [];

        session()->flash('message', 'Project updated successfully!');
    
        // Optional: Refresh the project instance to ensure the view sees the latest DB data
        $this->project = $project->fresh();
    }

    public function removeImage($index)
    {
        if (isset($this->existing_images[$index])) {
            // Optional: Storage::disk('public')->delete($this->existing_images[$index]);
            unset($this->existing_images[$index]);
            $this->existing_images = array_values($this->existing_images);
        }
    }

    public function render()
    {
        return view('livewire.customer.edit-project', [
            'available_amenities' => Amenity::all() // Pass it here to avoid undefined variable error
        ])->layout('layouts.app');
    }
}