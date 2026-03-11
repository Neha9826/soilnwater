<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductListing extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    // Inside ProductListing.php - Update the render method
public function render()
{
    $query = Product::where('is_sellable', true)
        ->where('is_active', true)
        ->where('is_approved', true)
        ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
        ->when($this->category, fn($q) => $q->where('product_category_id', $this->category));

    return view('livewire.public.product-listing', [
        'products' => $query->latest()->paginate(12),
        'categories' => ProductCategory::where('is_approved', true)->get(),
        // Fetching 1x1 Square Ads for the top banner
        'bannerAds' => \App\Models\Ad::whereHas('template.tier', function($query) {
            $query->where('grid_width', 1)->where('grid_height', 1);
        })->latest()->take(8)->get() 
    ])->layout('layouts.app');
}

    // Add these methods inside your ProductListing class

public function increment($id)
{
    \App\Models\Cart::where('id', $id)->where('user_id', auth()->id())->increment('quantity');
    $this->dispatch('cartUpdated'); // Notify the navbar
}

public function decrement($id)
{
    $cart = \App\Models\Cart::where('id', $id)->where('user_id', auth()->id())->first();
    
    if ($cart) {
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
    }
    
    $this->dispatch('cartUpdated'); // Notify the navbar
}

    public function addToCart($productId)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    \App\Models\Cart::updateOrCreate(
        ['user_id' => auth()->id(), 'product_id' => $productId],
        ['quantity' => 1]
    );

    $this->dispatch('cartUpdated');
}
}