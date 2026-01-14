<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use Filament\Notifications\Notification;
use Livewire\WithPagination;

class Approvals extends Page
{
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Approvals Center';
    protected static ?string $title = 'Pending Products';
    protected static ?string $slug = 'approvals';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.approvals';

    // Badge Count
    public static function getNavigationBadge(): ?string
    {
        $count = Product::where('is_approved', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    // Quick Action: Approve directly from list
    public function approveProduct($id)
    {
        Product::find($id)->update(['is_approved' => true, 'admin_rejection_reason' => null]);
        Notification::make()->title('Product Approved')->success()->send();
    }

    protected function getViewData(): array
    {
        return [
            'pendingProducts' => Product::where('is_approved', false)
                ->with(['user', 'category'])
                ->latest()
                ->paginate(10),
        ];
    }
}