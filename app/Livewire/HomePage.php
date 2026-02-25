<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad;
use App\Models\Property;
use App\Models\Product;

class HomePage extends Component
{
    // --- THIS LINE IS MISSING OR BROKEN ---
    public $search = ''; 
    // --------------------------------------

    public function render()
    {
        return view('livewire.home-page', [

        'heroBanners' => Ad::whereHas('template.tier', function($query) {
                $query->where('grid_width', 4)->where('grid_height', 1);
            })
            ->latest()
            ->get(),

        // Fetching 3 top offers for the horizontal scroll
        'offers' => \App\Models\Offer::latest()->take(3)->get(),

        'products' => Product::where('is_active', 1)->latest()->take(5)->get(),

            // 2. Fetch Non-Banner Ads randomly for the grid
        'promotedAds' => Ad::whereHas('template.tier', function($query) {
                $query->whereNot(function($q) {
                    $q->where('grid_width', 4)->where('grid_height', 1);
                });
            })
            ->inRandomOrder() 
            ->take(8) // Adjust to fill your 2-row grid (4 columns x 2 rows = 8 slots)
            ->get(),

            'properties' => Property::where('is_active', true)
                                  ->where('title', 'like', '%' . $this->search . '%')
                                  ->latest()
                                  ->take(4)
                                  ->get(),

            'products' => Product::where('is_active', true)
                                  ->where('name', 'like', '%' . $this->search . '%')
                                  ->latest()
                                  ->take(5)
                                  ->get(),
            // Fetch Featured Experts
        'experts' => \App\Models\User::whereIn('profile_type', ['consultant', 'vendor'])
            ->whereNotNull('store_name')
            ->inRandomOrder()
            ->take(6)
            ->get(),
        ]);
    }
}