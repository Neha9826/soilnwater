<?php

namespace App\Livewire\Public;

use App\Models\Ad;
use Livewire\Component;

class AdListing extends Component
{
    public $search = '';
    public $showFilters = false;
    public $perPage = 20; // Start with 20 ads

    protected $listeners = ['load-more' => 'loadMore'];

    public function loadMore()
    {
        $this->perPage += 20; // Load 20 more ads when triggered
    }

    public function toggleFilters() { $this->showFilters = !$this->showFilters; }

    public function updatingSearch()
    {
        $this->perPage = 20; // Reset count on search
    }

    // app/Livewire/Public/AdListing.php

public function render()
{
    $ads = Ad::with(['template.tier']) // Eager load the grid proportions
        ->select(['id', 'title', 'preview_image', 'ad_template_id', 'status', 'created_at']) // Only fetch needed columns
        ->where('status', 'approved')
        ->when($this->search, function($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->take($this->perPage)
        ->get();

    return view('livewire.public.ad-listing', [
        'ads' => $ads
    ])->layout('layouts.app');
}
}