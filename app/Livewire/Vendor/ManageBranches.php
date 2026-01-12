<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class ManageBranches extends Component
{
    public $myBusinesses;

    // Modal State
    public $isEditing = false;
    public $editingId = null;

    // Form Fields
    public $name, $city, $phone;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->myBusinesses = Business::where('user_id', Auth::id())->get();
    }

    // 1. Open Modal and Load Data
    public function editBranch($id)
    {
        $biz = Business::find($id);
        
        if ($biz && $biz->user_id == Auth::id()) {
            $this->editingId = $id;
            $this->name = $biz->name;
            $this->city = $biz->city;
            $this->phone = $biz->phone;
            $this->isEditing = true;
        }
    }

    // 2. Save Changes
    public function updateBranch()
    {
        $this->validate([
            'name' => 'required|min:3',
            'city' => 'required|string',
            'phone' => 'required|string',
        ]);

        $biz = Business::find($this->editingId);

        if ($biz && $biz->user_id == Auth::id()) {
            $biz->update([
                'name' => $this->name,
                'city' => $this->city,
                'phone' => $this->phone,
            ]);
            
            session()->flash('message', 'Branch updated successfully!');
            $this->closeModal();
            $this->refreshData();
        }
    }

    // 3. Delete Branch
    public function deleteBranch($id)
    {
        $biz = Business::find($id);

        if ($biz && $biz->user_id == Auth::id()) {
            $biz->delete();
            session()->flash('message', 'Branch deleted successfully.');
            $this->refreshData();
        }
    }

    public function closeModal()
    {
        $this->isEditing = false;
        $this->reset(['name', 'city', 'phone', 'editingId']);
    }

    public function render()
    {
        return view('livewire.vendor.manage-branches')->layout('layouts.app');
    }
}