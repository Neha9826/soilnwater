<?php

namespace App\Livewire\Public;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListing extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Filter properties to only show those NOT posted by builders
        $properties = Property::where('is_active', 1)
            ->whereHas('user', function($query) {
                $query->where('profile_type', '!=', 'builder');
            })
            ->where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.public.property-listing', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}