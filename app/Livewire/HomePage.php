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

        $verticalAds = Ad::whereHas('template.tier', function($query) {
        $query->where('grid_width', 1)->where('grid_height', 2);
            })->latest()->take(5)->get(); // Take 5 for variet

                return view('livewire.home-page', [

                'heroBanners' => Ad::whereHas('template.tier', function($query) {
                        $query->where('grid_width', 4)->where('grid_height', 1);
                    })
                    ->latest()
                    ->get(),

                
                // 1. Horizontal Rectangles (e.g., 2x1)
                // 'horizontalAds' => Ad::whereHas('template.tier', fn($q) => $q->where('grid_width', 2)->where('grid_height', 1))->latest()->take(2)->get(),

                // 2. Vertical Rectangles (e.g., 1x2)
                'verticalAds' => $verticalAds,

                // 1. Square Ads: Fetch 16 for a 2-row x 8-column grid
                'squareAds' => Ad::whereHas('template.tier', fn($q) => $q->where('grid_width', 1)->where('grid_height', 1))->latest()->take(16)->get(),

                // 2. Horizontal Ads: Fetch 6 for a 2-row x 3-column grid
                'horizontalAds' => Ad::whereHas('template.tier', fn($q) => $q->where('grid_width', 2)->where('grid_height', 1))->latest()->take(6)->get(),

                // 3. User Properties: Specifically excluding builders (assuming builder role/profile_type)
                'userProperties' => Property::where('is_active', true)
                    ->whereHas('user', fn($q) => $q->where('profile_type', '!=', 'builder')) 
                    ->latest()
                    ->take(16)
                    ->get(),

                // 4. Upcoming Projects: 8 items for a 2nd row
                'upcomingProjects' => \App\Models\Project::where('is_active', true)
                    ->latest()
                    ->take(8) 
                    ->get(),

                'fullPageAds' => Ad::whereHas('template.tier', function($query) {
                    $query->where('grid_width', 4)->where('grid_height', 2); 
                })->latest()->take(2)->get(),

                // Fetching 3 top offers for the horizontal scroll
                'offers' => \App\Models\Offer::latest()->take(8)->get(),

                'trendingProducts' => Product::where('is_active', true)
                                        ->latest()
                                        ->take(12) // Take 6 for the 2x3 grid we designed
                                        ->get(),

                // 'upcomingProjects' => \App\Models\Project::where('is_active', true)->latest()->take(4)->get(),

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

    public function addToCart($productId)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    \App\Models\Cart::updateOrCreate(
        ['user_id' => auth()->id(), 'product_id' => $productId],
        ['quantity' => \Illuminate\Support\Facades\DB::raw('quantity + 1')]
    );

    // This refreshes the cart count in your navbar
    $this->dispatch('cartUpdated'); 

    session()->flash('message', 'Product added to cart!');
}
}