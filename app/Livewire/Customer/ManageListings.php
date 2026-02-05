<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class ManageListings extends Component
{
    public $activeTab = 'properties'; // Default tab

    // Function to switch tabs
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
{
    return view('livewire.customer.manage-listings', [
        'ads' => \App\Models\Ad::with(['template', 'values.field']) // Removed .tier to prevent extra crashes
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get()
    ])->layout('layouts.app');
}
}