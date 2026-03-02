<?php

namespace App\Livewire;

use Livewire\Component;

class OffersPage extends Component
{
    public function render()
    {
        return view('livewire.offers-page', [
            'offers' => \App\Models\Offer::where('is_active', true) // Only approved
                ->where(function($query) {
                    $query->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->latest()
                ->get()
        ])->layout('layouts.app');
    }
}
