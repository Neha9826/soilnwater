<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class MyProjects extends Component
{
    public function delete($id)
    {
        $project = Project::find($id);
        if ($project && $project->user_id == Auth::id()) {
            $project->delete();
            session()->flash('message', 'Project deleted.');
        }
    }

    public function render()
    {
        $projects = Project::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('livewire.customer.my-projects', ['projects' => $projects]);
    }
}