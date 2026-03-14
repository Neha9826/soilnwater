<?php

namespace App\Livewire\Public;

use App\Models\Project;
use Livewire\Component;

class ProjectDetail extends Component
{
    public $project;

    public function mount($slug)
    {
        // Find project by slug or fail
        $this->project = Project::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.project-detail')->layout('layouts.app');
    }
}