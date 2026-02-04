<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyAds extends Component
{
    use WithPagination;

    public $search = '';
    public $viewType = 'grid'; // Kept for logic compatibility

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $ad = Ad::where('user_id', Auth::id())->findOrFail($id);

        // 1. Delete associated images from storage before deleting database records
        foreach ($ad->values as $value) {
            if ($value->field->type === 'image' && $value->value) {
                Storage::disk('public')->delete($value->value);
            }
        }

        // 2. Delete the Ad (Cascade will handle ad_values if set in migration, 
        // but Eloquent delete is safer for model events)
        $ad->delete();

        session()->flash('message', 'Advertisement deleted successfully.');
    }

    public function render()
    {
        $ads = Ad::with(['template.tier', 'values.field'])
            ->where('user_id', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.customer.my-ads', [
            'ads' => $ads
        ]);
    }
}