<?php

namespace App\Livewire\Public;

use App\Models\Property;
use Livewire\Component;

class PropertyDetail extends Component
{
    public $property;

    public function mount($id)
    {
        // We use findOrFail by ID because your listing links pass $property->id
        $this->property = Property::with('user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.property-detail')->layout('layouts.app');
    }
}