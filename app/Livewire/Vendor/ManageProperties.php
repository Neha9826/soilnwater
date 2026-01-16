<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class ManageProperties extends Component
{
    use WithPagination;

    public $search = '';
    public $viewType = 'list'; // 'list' or 'grid'

    public function toggleStatus($id)
    {
        $property = Property::where('user_id', Auth::id())->find($id);
        if ($property) {
            $property->is_active = !$property->is_active;
            $property->save();
        }
    }

    public function deleteProperty($id)
    {
        $property = Property::where('user_id', Auth::id())->find($id);
        if ($property) {
            $property->delete();
            session()->flash('message', 'Property deleted successfully.');
        }
    }

    public function render()
    {
        $properties = Property::where('user_id', Auth::id())
            ->where(function($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('city', 'like', '%'.$this->search.'%')
                  ->orWhere('type', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.vendor.manage-properties', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}