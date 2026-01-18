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

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $property = Property::find($id);

        // Security Check: Ensure the property belongs to the logged-in user
        if ($property && $property->user_id == Auth::id()) {
            
            // Optional: Delete images from storage to cleanup
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