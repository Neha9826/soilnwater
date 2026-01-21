<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Properties extends Component
{
    use WithPagination;

    // View State
    public $viewType = 'grid'; 
    public $search = '';

    // Sell Modal State
    public $isSellModalOpen = false;
    public $selectedPropertyId = null;
    public $sellingPrice;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // --- SELL VIA US LOGIC ---
    public function openSellModal($id)
    {
        $property = Property::find($id);
        if($property && $property->user_id == Auth::id()) {
            $this->selectedPropertyId = $id;
            $this->sellingPrice = $property->price > 0 ? $property->price : ''; // Pre-fill if exists
            $this->isSellModalOpen = true;
        }
    }

    public function closeSellModal()
    {
        $this->isSellModalOpen = false;
        $this->selectedPropertyId = null;
        $this->sellingPrice = '';
    }

    public function activateSale()
    {
        $this->validate([
            'sellingPrice' => 'required|numeric|min:1'
        ]);

        $property = Property::find($this->selectedPropertyId);
        
        if($property && $property->user_id == Auth::id()) {
            $property->update([
                'price' => $this->sellingPrice,
                'sell_via_us' => true, // Flag to show in marketplace
                'is_active' => true,
                'listing_type' => 'Sale' // Ensure it's marked as Sale
            ]);

            session()->flash('message', 'Property is now listed for Sale in the Marketplace!');
            $this->closeSellModal();
        }
    }

    public function deactivateSale($id)
    {
        $property = Property::find($id);
        if($property && $property->user_id == Auth::id()) {
            $property->update([
                'sell_via_us' => false,
                'price' => 0 // Optional: Reset price or keep it for later
            ]);
            session()->flash('message', 'Property removed from Marketplace. Visible on Profile only.');
        }
    }
    // --------------------------

    public function delete($id)
    {
        $property = Property::find($id);
        if ($property && $property->user_id == Auth::id()) {
            if ($property->images) {
                foreach ($property->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $property->delete();
            session()->flash('message', 'Property deleted successfully.');
        }
    }

    public function render()
    {
        $properties = Property::where('user_id', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.vendor.properties', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}