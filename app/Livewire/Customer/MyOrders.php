<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MyOrders extends Component
{
    public function render()
    {
        // Load orders with their items and the related products in one go
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.customer.my-orders', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}