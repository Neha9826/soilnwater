<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ManageProducts extends Component
{
    use WithFileUploads, WithPagination;

    // Form Fields (Matching your Admin Panel)
    public $name, $slug, $description, $price, $category;
    public $images = []; // New uploads
    public $is_active = true;
    public $is_featured = false;
    public $in_stock = true;
    public $on_sale = false;

    // Edit Mode Variables
    public $productId; 
    public $isEditing = false;
    public $showForm = false;

    public function mount()
    {
        // Security: Only Vendors allowed
        if(Auth::user()->profile_type !== 'vendor') {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        $this->resetFields();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        
        $this->productId = $id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->category = $product->category_id; // Assuming category_id column
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->in_stock = $product->in_stock;
        $this->on_sale = $product->on_sale;
        
        $this->showForm = true;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'images.*' => 'image|max:2048', // 2MB Max
        ]);

        // Handle Images
        $imagePaths = [];
        if ($this->images) {
            foreach ($this->images as $img) {
                $imagePaths[] = $img->store('products', 'public');
            }
        }

        $data = [
            'user_id' => Auth::id(), // Assign to logged-in Vendor
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'in_stock' => $this->in_stock,
            'on_sale' => $this->on_sale,
        ];

        // If editing, merge images (logic simplified for now)
        if (!empty($imagePaths)) {
            $data['images'] = $imagePaths; 
        }

        if ($this->isEditing) {
            $product = Product::where('user_id', Auth::id())->findOrFail($this->productId);
            $product->update($data);
            session()->flash('message', 'Product updated successfully!');
        } else {
            // Default image if none uploaded
            if(empty($imagePaths)) $data['images'] = ['products/default.png'];
            
            Product::create($data);
            session()->flash('message', 'Product created successfully!');
        }

        $this->resetFields();
        $this->showForm = false;
    }

    public function delete($id)
    {
        Product::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Product deleted.');
    }

    public function cancel()
    {
        $this->resetFields();
        $this->showForm = false;
    }

    private function resetFields()
    {
        $this->reset(['name', 'slug', 'description', 'price', 'images', 'is_active', 'is_featured', 'in_stock', 'on_sale', 'productId']);
        $this->images = [];
    }

    public function render()
    {
        return view('livewire.vendor.manage-products', [
            'products' => Product::where('user_id', Auth::id())->latest()->paginate(10)
        ]);
    }
}