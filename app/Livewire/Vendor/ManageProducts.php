<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithPagination; 
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ManageProducts extends Component
{
    use WithPagination;

    // View & Search State
    public $viewType = 'list'; // 'list' or 'grid'
    public $search = '';
    
    // Actions
    public $deleteId = null;

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Toggle "Online Sale" (Eye Icon)
    public function toggleStatus($id)
    {
        $product = Product::where('user_id', Auth::id())->find($id);
        if ($product) {
            $product->is_sellable = !$product->is_sellable;
            $product->save();
            
            // Optional: You can add a session flash here if you want visual confirmation
            // session()->flash('message', 'Product visibility updated.'); 
        }
    }

    // Delete Product (Dustbin)
    public function deleteProduct($id)
    {
        $product = Product::where('user_id', Auth::id())->find($id);
        if ($product) {
            $product->delete();
            session()->flash('message', 'Product deleted successfully.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Advanced Search Logic
        $products = Product::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('brand', 'like', '%'.$this->search.'%')
                      ->orWhere('stock_quantity', 'like', '%'.$this->search.'%')
                      ->orWhere('price', 'like', '%'.$this->search.'%')
                      ->orWhereDate('created_at', 'like', '%'.$this->search.'%')
                      ->orWhereHas('category', function($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      });
            })
            ->latest()
            ->paginate(20); // 20 Items per page

        return view('livewire.vendor.manage-products', [
            'products' => $products
        ])->layout('layouts.app');
    }
}