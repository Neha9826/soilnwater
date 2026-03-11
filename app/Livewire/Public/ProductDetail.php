<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Component
{
    public $product;
    public $mainImage;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)
            ->where('is_approved', true)
            ->where('is_active', true)
            ->firstOrFail();

        // Decode JSON colors and sizes from the DB
        $this->availableColors = is_array($this->product->colors) ? $this->product->colors : json_decode($this->product->colors, true) ?? [];
        $this->availableSizes = is_array($this->product->sizes) ? $this->product->sizes : json_decode($this->product->sizes, true) ?? [];

        $this->mainImage = (is_array($this->product->images) && count($this->product->images) > 0) 
            ? $this->product->images[0] 
            : 'default.jpg';
    }

    public function increment($cartId)
    {
        Cart::where('id', $cartId)->where('user_id', Auth::id())->increment('quantity');
        $this->dispatch('cartUpdated');
    }

    public function decrement($cartId)
    {
        $cart = Cart::where('id', $cartId)->where('user_id', Auth::id())->first();
        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            } else {
                $cart->delete();
            }
        }
        $this->dispatch('cartUpdated');
    }

    public function addToCart($productId)
    {
        if (!Auth::check()) return redirect()->route('login');

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            ['quantity' => 1]
        );

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', ['message' => 'Added to cart!', 'type' => 'success']);
    }

    public function selectBulkTier($qty)
    {
        if (!Auth::check()) return redirect()->route('login');
        
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $this->product->id],
            ['quantity' => $qty]
        );
        
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $cartItem = Auth::check() 
            ? Cart::where('user_id', Auth::id())->where('product_id', $this->product->id)->first() 
            : null;

        $price = $this->product->discounted_price ?? $this->product->price;
        $currentQty = $cartItem ? $cartItem->quantity : 1;
        $subtotal = $price * $currentQty;
        $gst = $subtotal * 0.18; // 18% GST

        return view('livewire.public.product-detail', [
            'cartItem' => $cartItem,
            'totalAmount' => $subtotal + $gst,
            'gst' => $gst
        ])->layout('layouts.app');
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
}