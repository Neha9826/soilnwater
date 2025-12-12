<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ServiceDirectory extends Component
{
    public $category = null; // Stores 'architect', 'plumber', etc.
    public $search = '';

    public function mount($category = null)
    {
        $this->category = $category;
    }

    public function render()
    {
        // Start with a base query
        $query = User::whereIn('profile_type', ['service', 'consultant', 'builder']);

        // Filter by Category if provided (e.g. /services/architect)
        if ($this->category) {
            $query->where('service_category', $this->category);
        }

        // Filter by Search Name
        if ($this->search) {
            $query->where('store_name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.service-directory', [
            'providers' => $query->latest()->get()
        ]);
    }
}