<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\Product;
use App\Models\Property;

class UserDashboard extends Component
{
    public $activeTab = 'stats';
    public $user;
    
    // Data Collections
    public $myBusinesses;
    
    // PRODUCT/ITEM STATE
    public $showItemForm = false; // Toggles between List and Form
    public $isEditingItem = false; // Track if we are updating or creating
    public $editingItemId = null;  // ID of item being edited
    
    // Form Fields (Item)
    public $selectedBusinessId; 
    public $item_name, $item_price, $item_description; 

    // BUSINESS STATE (For "Manage Branches")
    public $showBusinessForm = false;
    public $isEditingBusiness = false;
    public $editingBusinessId = null;
    public $bus_name, $bus_city, $bus_phone; // Basic fields for quick edit

    public function mount()
    {
        if (Auth::check() && Auth::user()->profile_type === 'super_admin') {
            return redirect('/admin');
        }

        $this->user = Auth::user();
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->myBusinesses = Business::where('user_id', $this->user->id)->get();
        // Default select first business
        if($this->myBusinesses->isNotEmpty() && !$this->selectedBusinessId){
            $this->selectedBusinessId = $this->myBusinesses->first()->id;
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        // Reset forms when switching tabs
        $this->resetItemForm();
        $this->resetBusinessForm();
    }

    // ==========================================
    //  ITEM (PRODUCT/PROPERTY) LOGIC
    // ==========================================

    public function openItemCreate()
    {
        $this->resetItemForm();
        $this->showItemForm = true;
        $this->isEditingItem = false;
    }

    public function editItem($id)
    {
        $model = ($this->user->profile_type == 'vendor') ? Product::class : Property::class;
        $item = $model::find($id);

        if($item && $item->user_id == $this->user->id) {
            $this->editingItemId = $item->id;
            // Removed business_id check as it might not exist on new items
            $this->item_name = $item->name ?? $item->title;
            $this->item_price = $item->price;
            $this->item_description = $item->description;
            
            $this->isEditingItem = true;
            $this->showItemForm = true;
        }
    }

    public function saveItem()
    {
        $this->validate([
            'item_name' => 'required|min:3',
            'item_price' => 'required|numeric',
        ]);

        $type = $this->user->profile_type;
        
        // Data to save (Removed 'business_id' dependency)
        $data = [
            'price' => $this->item_price,
            'description' => $this->item_description,
            'user_id' => $this->user->id,
        ];

        // Handle Title vs Name difference
        if ($type === 'vendor') {
            $data['name'] = $this->item_name;
            $model = Product::class;
        } else {
            $data['title'] = $this->item_name;
            $model = Property::class;
        }

        if ($this->isEditingItem) {
            // UPDATE
            $item = $model::find($this->editingItemId);
            if($item && $item->user_id == $this->user->id) {
                $item->update($data);
                session()->flash('message', 'Item updated successfully!');
            }
        } else {
            // CREATE
            $model::create($data);
            session()->flash('message', 'Item created successfully!');
        }
        
        $this->resetItemForm();
    }

    public function deleteItem($id)
    {
        $model = ($this->user->profile_type == 'vendor') ? Product::class : Property::class;
        $item = $model::find($id);
        
        if($item && $item->user_id == $this->user->id){
            $item->delete();
            session()->flash('message', 'Item deleted successfully.');
        }
    }

    public function resetItemForm()
    {
        $this->showItemForm = false;
        $this->isEditingItem = false;
        $this->editingItemId = null;
        $this->reset(['item_name', 'item_price', 'item_description']);
    }

    // ==========================================
    //  BUSINESS (BRANCH) LOGIC
    // ==========================================

    public function openBusinessCreate()
    {
        return redirect()->route('join'); 
    }

    public function editBusiness($id)
    {
        $biz = Business::find($id);
        if($biz && $biz->user_id == $this->user->id){
            $this->editingBusinessId = $biz->id;
            $this->bus_name = $biz->name;
            $this->bus_city = $biz->city;
            $this->bus_phone = $biz->phone;
            
            $this->isEditingBusiness = true;
            $this->showBusinessForm = true;
        }
    }

    public function updateBusiness()
    {
        $this->validate([
            'bus_name' => 'required',
            'bus_city' => 'required',
            'bus_phone' => 'required',
        ]);

        $biz = Business::find($this->editingBusinessId);
        if($biz && $biz->user_id == $this->user->id){
            $biz->update([
                'name' => $this->bus_name,
                'city' => $this->bus_city,
                'phone' => $this->bus_phone,
            ]);
            session()->flash('message', 'Branch updated successfully!');
        }
        $this->refreshData(); // Refresh list
        $this->resetBusinessForm();
    }

    public function deleteBusiness($id)
    {
        $biz = Business::find($id);
        if($biz && $biz->user_id == $this->user->id){
            $biz->delete();
            $this->refreshData();
            session()->flash('message', 'Branch deleted.');
        }
    }

    public function resetBusinessForm()
    {
        $this->showBusinessForm = false;
        $this->isEditingBusiness = false;
        $this->editingBusinessId = null;
        $this->reset(['bus_name', 'bus_city', 'bus_phone']);
    }

    public function render()
    {
        // Fetch Items
        $myItems = [];
        if ($this->user->profile_type === 'vendor') {
            // FIX IS HERE: Removed ->with('business')
            $myItems = Product::where('user_id', $this->user->id)->latest()->get();
        } elseif (in_array($this->user->profile_type, ['hotel', 'builder'])) {
            // FIX IS HERE: Removed ->with('business')
            $myItems = Property::where('user_id', $this->user->id)->latest()->get();
        }

        return view('livewire.user-dashboard', [
            'myItems' => $myItems
        ])->layout('layouts.app');
    }
}