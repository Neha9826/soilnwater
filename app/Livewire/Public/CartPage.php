<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Cart;

class CartPage extends Component
{
    public function increment($id)
    {
        Cart::where('id', $id)->where('user_id', auth()->id())->increment('quantity');
        
        // ADD THIS HERE: Notify the navbar to update the count
        $this->dispatch('cartUpdated'); 
    }

    public function decrement($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', auth()->id())->first();
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
        
        // This is already correct
        $this->dispatch('cartUpdated');
    }

    public function removeItem($id)
    {
        Cart::where('id', $id)->where('user_id', auth()->id())->delete();
        
        // This is already correct
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        $total = $cartItems->sum(function($item) {
            $price = $item->product->discounted_price ?: $item->product->price;
            return $price * $item->quantity;
        });

        return view('livewire.public.cart-page', [
            'cartItems' => $cartItems,
            'total' => $total
        ])->layout('layouts.app');
    }
}