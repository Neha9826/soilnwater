<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

class MyAds extends Component
{
    use WithPagination;

    public $viewType = 'grid';
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setView($view)
    {
        $this->viewType = $view;
    }

    public function delete($id)
    {
        $ad = Ad::find($id);
        if ($ad && $ad->user_id == Auth::id()) {
            $ad->delete();
            session()->flash('message', 'Ad deleted successfully.');
        }
    }

    public function render()
    {
        $ads = Ad::where('user_id', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.customer.my-ads', ['ads' => $ads]);
    }
}   