<?php

namespace App\Livewire;

use Livewire\Component;

class HotelList extends Component
{
    public function render()
    {
        return view('livewire.hotel-list', [
            'hotels' => \App\Models\Hotel::where('is_active', true)->latest()->get()
        ]);
    }
}
