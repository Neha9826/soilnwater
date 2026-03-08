<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;
    public $mainImage;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)
            ->where('is_approved', true) // Security: Only show approved items
            ->where('is_active', true)   // Ensure vendor hasn't hidden it
            ->firstOrFail();

        // Set the first image as default main image
        $this->mainImage = is_array($this->product->images) && count($this->product->images) > 0 
            ? $this->product->images[0] 
            : null;
    }

    public function setMainImage($path)
    {
        $this->mainImage = $path;
    }

    public function render()
    {
        return view('livewire.public.product-detail')->layout('layouts.app');
    }

    public function addToWishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        \App\Models\Wishlist::updateOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
        ]);

        session()->flash('message', 'Added to wishlist!');
    }

    public function addToCart($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $cart = \App\Models\Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            \App\Models\Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        $this->dispatch('cartUpdated'); // Refresh the navbar counter
        session()->flash('message', 'Item added to cart!');
    }
}