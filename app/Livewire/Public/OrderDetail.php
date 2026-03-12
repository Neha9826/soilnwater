<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderDetail extends Component
{
    public $order;

    public function mount($order_number)
    {
        // Fetch order with items and products, ensuring it belongs to the logged-in user
        $this->order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('order_number', $order_number)
            ->firstOrFail();
    }

    public function cancelOrder()
    {
        // Policy: Only allow cancellation if status is 'pending'
        if ($this->order->status === 'pending') {
            $this->order->update(['status' => 'cancelled']);
            session()->flash('message', 'Order #'.$this->order->order_number.' has been cancelled successfully.');
        } else {
            session()->flash('error', 'This order cannot be cancelled as it is already ' . $this->order->status);
        }
    }

    public function render()
    {
        return view('livewire.public.order-detail')->layout('layouts.app');
    }
}