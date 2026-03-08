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

    public function render()
    {
        $query = Product::where('is_sellable', true) // Only listed for 'Buy Now'
            ->where('is_active', true)              // Not hidden by vendor
            ->where('is_approved', true)            // Approved by Admin
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->category, fn($q) => $q->where('product_category_id', $this->category));

        return view('livewire.public.product-listing', [
            'products' => $query->latest()->paginate(12),
            'categories' => ProductCategory::where('is_approved', true)->get() //
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