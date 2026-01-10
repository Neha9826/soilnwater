<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateProduct extends Component
{
    use WithFileUploads;

    // Form Fields
    public $name, $brand, $price, $stock_quantity, $sku, $description;
    public $weight, $dimensions, $video_url;
    
    // Arrays & Media
    public $images = [];
    public $colors, $sizes; // Text inputs (comma separated)
    
    // Categorization
    public $category_id, $subcategory_id;
    public $new_category_name;
    public $is_other_category = false;
    
    public $categories = [];
    public $subcategories = [];
    
    // Specs
    public $specs = [['key' => '', 'value' => '']];

    public function mount()
    {
        $this->categories = Category::whereNull('parent_id')->where('is_approved', true)->get();
    }

    public function updatedCategoryId($value)
    {
        if ($value === 'other') {
            $this->is_other_category = true;
            $this->subcategories = [];
        } else {
            $this->is_other_category = false;
            $this->subcategories = Category::where('parent_id', $value)->where('is_approved', true)->get();
        }
    }

    public function addSpec()
    {
        $this->specs[] = ['key' => '', 'value' => ''];
    }

    public function removeSpec($index)
    {
        unset($this->specs[$index]);
        $this->specs = array_values($this->specs);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'images.*' => 'image|max:2048',
            'category_id' => 'required',
        ]);

        // 1. Handle "Other" Category
        $finalCatId = $this->category_id;
        if ($this->category_id === 'other') {
            $this->validate(['new_category_name' => 'required|string|min:3']);
            $newCat = Category::create([
                'name' => $this->new_category_name,
                'slug' => Str::slug($this->new_category_name),
                'is_approved' => false,
                'created_by' => Auth::id()
            ]);
            $finalCatId = $newCat->id;
        }

        // 2. Upload Images
        $imagePaths = [];
        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('products', 'public');
        }

        // 3. Process Specs
        $cleanSpecs = [];
        foreach ($this->specs as $spec) {
            if (!empty($spec['key'])) $cleanSpecs[$spec['key']] = $spec['value'];
        }

        // 4. Create Product
        Product::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . uniqid(),
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'sku' => $this->sku ?? strtoupper(Str::random(10)),
            'brand' => $this->brand,
            'category_id' => $finalCatId,
            'subcategory_id' => is_numeric($this->subcategory_id) ? $this->subcategory_id : null,
            'images' => $imagePaths,
            'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
            'sizes' => $this->sizes ? array_map('trim', explode(',', $this->sizes)) : [],
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'video_url' => $this->video_url,
            'specifications' => $cleanSpecs,
        ]);

        // Redirect back to list
        return redirect()->route('vendor.products')->with('message', 'Product created successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.create-product')->layout('layouts.app');
    }
}