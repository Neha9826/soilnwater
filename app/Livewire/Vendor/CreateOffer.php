<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Offer;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class CreateOffer extends Component
{
    use WithFileUploads;

    public $title, $discount_tag, $coupon_code, $valid_until, $image, $description, $product_category_id;

    public function render()
    {
        return view('livewire.vendor.create-offer', [
            'categories' => \App\Models\ProductCategory::where('is_approved', true)->get()
        ])->layout('layouts.app'); // Force the main theme
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:5',
            'discount_tag' => 'required',
            'image' => 'required|image|max:2048', 
        ]);

        \App\Models\Offer::create([
            'user_id' => Auth::id(), // Works for any logged-in user
            'product_category_id' => $this->product_category_id ?: null,
            'title' => $this->title,
            'discount_tag' => $this->discount_tag,
            'coupon_code' => $this->coupon_code,
            'valid_until' => $this->valid_until,
            'description' => $this->description,
            'image' => $this->image->store('offers', 'public'), 
            'is_active' => false, // Still requires Admin approval
        ]);

        return redirect()->route('offers.index')->with('message', 'Offer posted! It will be live once approved.');
    }
}