<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;

class ProjectListing extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.public.project-listing', [
            'projects' => Project::where('is_active', true)->latest()->paginate(12)
        ])->layout('layouts.app');
    }
}