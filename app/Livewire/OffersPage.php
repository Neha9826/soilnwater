<?php

namespace App\Livewire;

use Livewire\Component;

class OffersPage extends Component
{
    public function render()
    {
        return view('livewire.offers-page', [
            'offers' => \App\Models\Offer::where('is_active', true)->latest()->get()
        ]);
    }
}
