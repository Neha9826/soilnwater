<?php

namespace App\Livewire;

use Livewire\Component;

class ProjectList extends Component
{
    public function render()
    {
        return view('livewire.project-list', [
            'projects' => \App\Models\Project::latest()->get()
        ]);
    }
}
