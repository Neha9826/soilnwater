<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use Filament\Notifications\Notification;

class ProductApprovalDetail extends Component
{
    public $product;
    public $rejectionReason = '';
    public $showRejectModal = false;

    public function mount($id)
    {
        $this->product = Product::with(['user', 'category'])->findOrFail($id);
    }

    public function approve()
    {
        $this->product->update(['is_approved' => true, 'admin_rejection_reason' => null]);
        
        Notification::make()->title('Product Approved')->success()->send();
        return redirect()->route('filament.admin.pages.approvals');
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|min:5']);

        $this->product->update([
            'is_approved' => false, 
            'admin_rejection_reason' => $this->rejectionReason
        ]);

        Notification::make()->title('Product Rejected')->body('Vendor notified.')->danger()->send();
        return redirect()->route('filament.admin.pages.approvals');
    }

    public function render()
    {
        // Use Filament Layout so it stays inside the Admin Panel
        return view('livewire.admin.product-approval-detail')
            ->layout('filament::components.layouts.app'); 
    }
}