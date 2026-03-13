<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;

class PropertyListing extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $query = Property::where('is_active', true)
            ->whereHas('user', fn($q) => $q->where('profile_type', '!=', 'builder'))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));

        return view('livewire.public.property-listing', [
            'properties' => $query->latest()->paginate(12)
        ])->layout('layouts.app');
    }
}