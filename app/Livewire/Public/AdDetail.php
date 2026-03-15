<?php

namespace App\Livewire\Public;

use App\Models\Ad;
use Livewire\Component;

class AdDetail extends Component
{
    public $ad;

    public function mount($id)
    {
        // Fetch the specific ad or fail
        $this->ad = Ad::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.ad-detail')->layout('layouts.app');
    }
}