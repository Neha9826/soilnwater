<?php

namespace App\Livewire\Public;

use Livewire\Component;

class CheckoutPage extends Component
{
    public function render()
    {
        return view('livewire.public.checkout-page');
    }

    public function placeOrder()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        $cartItems = \App\Models\Cart::where('user_id', auth()->id())->get();
        
        // 1. Create Order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'SNW-' . strtoupper(str()->random(8)),
            'total_amount' => $this->total, // Calculate this in mount()
            'status' => 'pending',
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
        ]);

        // 2. Move Cart Items to Order Items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->discounted_price ?: $item->product->price,
            ]);
        }

        // 3. Clear Cart
        \App\Models\Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('order.success', $order->order_number);
    }
}
