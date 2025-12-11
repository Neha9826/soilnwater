<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyDetail extends Component
{
    public $property;

    // This runs automatically when the page loads
    public function mount($slug)
    {
        // Find the property or show 404 if missing
        $this->property = Property::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.property-detail');
    }
}