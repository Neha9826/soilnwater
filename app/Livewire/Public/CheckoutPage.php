<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutPage extends Component
{
    public $name, $phone, $pincode, $address, $city, $state;
    public $cartItems = [];
    public $total = 0;
    public $savedAddresses = [];
    public $selectedAddressId = null;

    public function mount()
    {
        $this->loadCart();
        
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone; // Ensure 'phone' is in your User model fillable

        // Fetch saved addresses through the relationship
        // Ensure you added public function addresses() { return $this->hasMany(Address::class); } to User model
        $this->savedAddresses = $user->addresses()->latest()->get();
        
        if($this->savedAddresses->count() > 0) {
            $this->setAddress($this->savedAddresses->first()->id);
        }
    }

    public function setAddress($id)
    {
        $addr = Address::find($id);
        if ($addr && $addr->user_id == Auth::id()) {
            $this->selectedAddressId = $id;
            $this->name = $addr->name;
            $this->phone = $addr->phone;
            $this->pincode = $addr->pincode;
            $this->address = $addr->address;
            $this->city = $addr->city;
            $this->state = $addr->state;
        }
    }

    public function loadCart()
    {
        $this->cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $this->total = $this->cartItems->sum(function($item) {
            $price = $item->product->discounted_price ?: $item->product->price;
            return $price * $item->quantity;
        });
    }

    public function placeOrder()
    {
        // Validation with specific error messages for user feedback
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'pincode' => 'required|digits:6',
            'address' => 'required|min:5',
            'city' => 'required',
            'state' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'SNW-' . strtoupper(Str::random(8)),
                'total_amount' => $this->total,
                'status' => 'pending',
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'pincode' => $this->pincode,
            ]);

            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discounted_price ?: $item->product->price,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
            DB::commit();

            $this->dispatch('cartUpdated');
            
            // Redirect to a named route for order success
            return redirect()->route('order.success', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Standard Livewire 3 return for components using layouts.app
        return view('livewire.public.checkout-page')->layout('layouts.app');
    }
}