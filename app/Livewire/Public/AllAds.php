<?php

namespace App\Livewire\Public; // If the file is in app/Livewire/Public

use Livewire\Component;
use App\Models\Ad;
use Livewire\WithPagination;

class AllAds extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.public.all-ads', [
            'ads' => Ad::with(['template.tier'])
                ->whereHas('template.tier', function($query) {
                    $query->whereNot(function($q) {
                        $q->where('grid_width', 4)->where('grid_height', 1);
                    });
                })
                ->latest()
                ->paginate(20)
        ])->layout('layouts.app'); // Ensure this layout exists
    }
}