<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Classified;

class ClassifiedList extends Component
{
    public function render()
    {
        return view('livewire.classified-list', [
            'ads' => Classified::where('is_active', true)->latest()->get()
        ]);
    }
}