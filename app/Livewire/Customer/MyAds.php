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

    public function deleteAd($id)
    {
        // 1. Find the ad belonging specifically to the logged-in user
        $ad = Ad::where('user_id', auth()->id())->findOrFail($id);

        // 2. Delete the record (Cascade will handle AdValues if set in DB)
        $ad->delete();

        // 3. Flash a success message for the employer to see
        session()->flash('message', 'Advertisement deleted successfully!');
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