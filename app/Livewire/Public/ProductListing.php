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
}