<?php

namespace App\Livewire\Public;

use App\Models\Offer;
use Livewire\Component;

class OfferDetail extends Component
{
    public $offer;

    public function mount($id)
    {
        // Fetch offer by ID as defined in your SQL schema
        $this->offer = Offer::where('is_active', 1)->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.offer-detail')->layout('layouts.app');
    }
}