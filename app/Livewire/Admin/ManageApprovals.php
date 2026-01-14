<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Business;
use Livewire\WithPagination;

class ManageApprovals extends Component
{
    use WithPagination;

    public $activeTab = 'products'; // 'products' or 'vendors'

    // Actions
    public $rejectId = null;
    public $rejectType = null;
    public $rejectionReason = '';
    public $showRejectModal = false;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // --- APPROVE ---
    public function approveProduct($id)
    {
        Product::find($id)->update(['is_approved' => true, 'admin_rejection_reason' => null]);
        session()->flash('message', 'Product Approved Successfully!');
    }

    public function approveVendor($id)
    {
        Business::find($id)->update(['is_approved' => true, 'admin_rejection_reason' => null]);
        session()->flash('message', 'Vendor Branch Approved Successfully!');
    }

    // --- REJECT ---
    public function openRejectModal($id, $type)
    {
        $this->rejectId = $id;
        $this->rejectType = $type;
        $this->rejectionReason = '';
        $this->showRejectModal = true;
    }

    public function submitRejection()
    {
        $this->validate(['rejectionReason' => 'required|min:5']);

        if ($this->rejectType === 'product') {
            Product::find($this->rejectId)->update([
                'is_approved' => false, 
                'admin_rejection_reason' => $this->rejectionReason
            ]);
        } else {
            Business::find($this->rejectId)->update([
                'is_approved' => false, 
                'admin_rejection_reason' => $this->rejectionReason
            ]);
        }

        $this->showRejectModal = false;
        session()->flash('message', 'Item rejected and vendor notified.');
    }

    public function render()
    {
        // Fetch Pending Items (is_approved = 0)
        $pendingProducts = Product::where('is_approved', false)
            ->with(['user', 'category']) 
            ->latest()
            ->paginate(10);

        $pendingVendors = Business::where('is_approved', false)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-approvals', [
            'pendingProducts' => $pendingProducts,
            'pendingVendors' => $pendingVendors
        ])->layout('layouts.app');
    }
}