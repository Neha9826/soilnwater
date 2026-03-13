<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyDetail extends Component
{
    public $property;

    public function mount($slug) // Matching your route parameter {slug}
    {
        // Load relationships to ensure amenities and user data are available
        $this->property = Property::with(['user', 'amenities'])->findOrFail($slug);
    }

    public function render()
    {
        return view('livewire.property-detail')->layout('layouts.app');
    }
}