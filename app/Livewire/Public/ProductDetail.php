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
}