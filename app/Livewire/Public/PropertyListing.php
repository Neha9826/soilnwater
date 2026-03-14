<?php

namespace App\Livewire\Public;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListing extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice, $maxPrice;
    public $sort = 'latest';
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
        $query = Property::where('is_active', 1)
            ->whereHas('user', function($q) {
                $q->where('profile_type', '!=', 'builder');
            })
            ->when($this->search, function($q) {
                $q->where(fn($sub) => $sub->where('title', 'like', '%' . $this->search . '%')
                                           ->orWhere('city', 'like', '%' . $this->search . '%'));
            })
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice));

        // Sorting Logic
        if ($this->sort === 'price_low') $query->orderBy('price', 'asc');
        elseif ($this->sort === 'price_high') $query->orderBy('price', 'desc');
        else $query->latest();

        return view('livewire.public.property-listing', [
            'properties' => $query->paginate(18)
        ])->layout('layouts.app');
    }
}