<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination; // Import Pagination
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class MyProjects extends Component
{
    use WithPagination; // Use Pagination

    public $viewType = 'grid'; 
    public $search = '';

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setView($view)
    {
        $this->viewType = $view;
    }

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
        $projects = Project::where('user_id', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.customer.my-projects', ['projects' => $projects]);
    }
}