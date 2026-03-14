<?php

namespace App\Livewire\Public;

use App\Models\AdTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class OffersListing extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $offers = AdTemplate::where('is_active', 1)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.public.offers-listing', [
            'offers' => $offers
        ])->layout('layouts.app');
    }
}