<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyPosts extends Component
{
    use WithPagination;

    public $search = '';
    public $viewType = 'grid'; // Default to Grid (Square Cards)

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $property = Property::where('id', $id)->where('user_id', Auth::id())->first();

        if ($property) {
            // Optional: Delete images from storage
            if ($property->images) {
                foreach ($property->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $property->delete();
            session()->flash('message', 'Ad deleted successfully.');
        }
    }

    public function render()
    {
        $posts = Property::where('user_id', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%') // Search functionality
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.customer.my-posts', ['posts' => $posts]);
    }
}