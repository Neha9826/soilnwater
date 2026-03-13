<?php
namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;

class RealEstateListing extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice, $maxPrice;
    public $sort = 'latest';
    public $showFilters = false; // Toggles the Smart Toolbar

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function render()
    {
        $query = Property::where('is_active', true)
            ->whereHas('user', fn($q) => $q->where('profile_type', 'builder'))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice));

        // Apply Sorting
        if ($this->sort === 'price_low') $query->orderBy('price', 'asc');
        elseif ($this->sort === 'price_high') $query->orderBy('price', 'desc');
        else $query->latest();

        return view('livewire.public.real-estate-listing', [
            'properties' => $query->paginate(18)
        ])->layout('layouts.app');
    }
}