<?php

namespace App\Livewire\Public;

use App\Models\Offer;
use Livewire\Component;
use Livewire\WithPagination;

class OffersListing extends Component
{
    use WithPagination;

    public $search = '';
    public $showFilters = false;

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Verified columns from SQL: offer_title, offer_description, is_active
        $query = Offer::where('is_active', 1)
            ->when($this->search, function($q) {
                $q->where('offer_title', 'like', '%' . $this->search . '%')
                  ->orWhere('offer_description', 'like', '%' . $this->search . '%')
                  ->orWhere('coupon_code', 'like', '%' . $this->search . '%');
            })
            ->latest();

        return view('livewire.public.offers-listing', [
            'offers' => $query->paginate(18)
        ])->layout('layouts.app');
    }
}