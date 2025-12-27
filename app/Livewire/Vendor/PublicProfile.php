<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Models\User;
use App\Models\Product;
use Livewire\WithPagination;

class PublicProfile extends Component
{
    use WithPagination;

    public $vendor;
    public $slug;

    public function mount($slug)
    {
        // 1. Find the Vendor by their URL Slug
        $this->vendor = User::where('store_slug', $slug)
                            ->where('profile_type', '!=', 'customer') // Security check
                            ->firstOrFail();
        
        $this->slug = $slug;
    }

    public function render()
    {
        // 2. Fetch their products (Paginated)
        $products = Product::where('user_id', $this->vendor->id)
                           ->where('is_active', true)
                           ->latest()
                           ->paginate(12);

        return view('livewire.vendor.public-profile', [
            'products' => $products
        ]);
    }
}