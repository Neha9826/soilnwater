<?php

namespace App\Livewire\Public;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectListing extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice, $maxPrice;
    public $sort = 'latest';
    public $showFilters = false;

    public function toggleFilters() { $this->showFilters = !$this->showFilters; }

    public function render()
    {
        $query = Project::where('is_active', 1)
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice));

        if ($this->sort === 'price_low') $query->orderBy('price', 'asc');
        elseif ($this->sort === 'price_high') $query->orderBy('price', 'desc');
        else $query->latest();

        return view('livewire.public.project-listing', [
            'projects' => $query->paginate(12)
        ])->layout('layouts.app');
    }
}