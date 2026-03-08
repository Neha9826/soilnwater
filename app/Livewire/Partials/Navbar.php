<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use Livewire\Attributes\On; //

class Navbar extends Component
{
    public function updateCartCount()
    {
        // This method can be empty; calling it forces the component to re-render
    }
    public function render()
    {
        return view('livewire.partials.navbar');
    }

}
