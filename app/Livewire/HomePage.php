<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Product;

class HomePage extends Component
{
    // --- THIS LINE IS MISSING OR BROKEN ---
    public $search = ''; 
    // --------------------------------------

    public function render()
    {
        return view('livewire.home-page', [
            'properties' => Property::where('is_active', true)
                                  ->where('title', 'like', '%' . $this->search . '%')
                                  ->latest()
                                  ->take(4)
                                  ->get(),

            'products' => Product::where('is_active', true)
                                  ->where('name', 'like', '%' . $this->search . '%')
                                  ->latest()
                                  ->take(5)
                                  ->get(),
        ]);
    }
}