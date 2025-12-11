<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\User;
use App\Models\Product;

class VendorProfile extends Component
{
    public $vendor;
    public $products;

    public function mount($slug)
    {
        // Find vendor by their unique slug
        $this->vendor = User::where('store_slug', $slug)->firstOrFail();

        // Fetch ONLY products created by THIS vendor (assuming you link products to users later)
        // For now, we will show all products just for the demo
        $this->products = Product::take(10)->get(); 
    }

    public function render()
    {
        return view('livewire.vendor-profile');
    }
}