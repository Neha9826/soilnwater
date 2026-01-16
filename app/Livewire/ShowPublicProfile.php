<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Business;
use App\Models\Product;
use App\Models\Property;
use App\Models\User;
use Livewire\WithPagination;

class ShowPublicProfile extends Component
{
    use WithPagination;

    public $business;
    public $userType;

    public function mount($slug)
    {
        // 1. Find Business by Slug
        $this->business = Business::where('slug', $slug)->firstOrFail();
        
        // --- SAFETY FIX START ---
        // Prevents "String given" error if data wasn't cast correctly
        if (is_string($this->business->header_images)) {
            $this->business->header_images = json_decode($this->business->header_images, true) ?? [];
        }
        
        if (is_string($this->business->page_sections)) {
            $this->business->page_sections = json_decode($this->business->page_sections, true) ?? [];
        }
        // --- SAFETY FIX END ---

        // 2. Determine User Type
        $user = User::find($this->business->user_id);
        $this->userType = $user->profile_type;
    }

    public function render()
    {
        $listings = collect();

        // 3. Universal Data Fetching
        if ($this->userType === 'vendor') {
            $listings = Product::where('user_id', $this->business->user_id)
                ->where('is_active', true)
                ->paginate(12);
        } elseif ($this->userType === 'builder' || $this->userType === 'agent') {
            $listings = Property::where('user_id', $this->business->user_id)
                ->where('is_active', true)
                ->paginate(12);
        }

        return view('livewire.show-public-profile', [
            'vendor' => $this->business,
            'products' => $listings,
            'userType' => $this->userType
        ])->layout('components.layouts.app'); 
    }
}