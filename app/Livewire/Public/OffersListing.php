<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Offer;

class OffersListing extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.public.offers-listing', [
            'offers' => Offer::latest()->paginate(12)
        ])->layout('layouts.app');
    }
}