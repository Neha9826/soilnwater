<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product; // The record being edited
    public $name, $brand, $price, $stock_quantity, $sku, $description;
    public $product_category_id, $product_sub_category_id, $is_other_category, $is_other_subcategory = false;
    public $categories = [], $subcategories = [];
    public $images = [], $existingImages = [], $video, $video_url, $colors, $sizes, $weight, $dimensions;
    public $specs = [];
    public $discount_percentage = 0, $discounted_price = 0, $shipping_charges = 0;
    public $is_sellable = false;
    public $tiered_pricing = [];

    public $new_category_name;
    public $new_subcategory_name;

    public function mount($id)
    {
        // 1. Fetch the product owned by the vendor
        $this->product = Product::where('user_id', Auth::id())->findOrFail($id);

        // 2. Map existing data to properties
        $this->name = $this->product->name;
        $this->brand = $this->product->brand;
        $this->price = $this->product->price;
        $this->discount_percentage = $this->product->discount_percentage;
        $this->discounted_price = $this->product->discounted_price;
        $this->stock_quantity = $this->product->stock_quantity;
        $this->sku = $this->product->sku;
        $this->description = $this->product->description;
        $this->product_category_id = $this->product->product_category_id;
        $this->product_sub_category_id = $this->product->product_sub_category_id;
        $this->existingImages = $this->product->images ?? [];
        $this->video_url = $this->product->video_url;
        $this->is_sellable = $this->product->is_sellable;
        $this->tiered_pricing = $this->product->tiered_pricing ?? [['min_qty' => '', 'unit_price' => '']];
        $this->specs = $this->product->specifications ?? [['key' => '', 'value' => '']];
        // Convert arrays to comma-separated strings for the inputs
        $this->colors = is_array($this->product->colors) ? implode(', ', $this->product->colors) : '';
        $this->sizes = is_array($this->product->sizes) ? implode(', ', $this->product->sizes) : '';
        
        // Load initial lists
        $this->categories = ProductCategory::where('is_approved', true)->get();
        if ($this->product_category_id) {
            $this->subcategories = ProductSubCategory::where('product_category_id', $this->product_category_id)->get();
        }
    }

    // Reuse your calculation and updated hooks from CreateProduct
    public function updatedProductCategoryId($value)
    {
        if ($value === 'other') {
            $this->is_other_category = true;
            $this->is_other_subcategory = true; // If category is new, subcat must be new
            $this->subcategories = [];
        } else {
            $this->is_other_category = false;
            $this->is_other_subcategory = false;
            $this->subcategories = ProductSubCategory::where('product_category_id', $value)->get();
        }
        $this->product_sub_category_id = null;
    }

    public function updatedProductSubCategoryId($value)
    {
        $this->is_other_subcategory = ($value === 'other');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'product_category_id' => 'required',
        ]);

        // Process new images if uploaded
        $imagePaths = $this->existingImages;
        if ($this->images) {
            foreach ($this->images as $img) {
                $imagePaths[] = $img->store('products', 'public');
            }
        }

        $this->product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_percentage' => $this->discount_percentage,
            'discounted_price' => $this->discounted_price,
            'stock_quantity' => $this->stock_quantity,
            'sku' => $this->sku,
            'brand' => $this->brand,
            'product_category_id' => $this->product_category_id,
            'product_sub_category_id' => $this->product_sub_category_id,
            'images' => $imagePaths,
            'is_sellable' => $this->is_sellable,
            'tiered_pricing' => array_filter($this->tiered_pricing, fn($t) => !empty($t['min_qty'])),
            'specifications' => array_filter($this->specs, fn($s) => !empty($s['key'])),
            'colors' => $this->colors ? array_map('trim', explode(',', (string)$this->colors)) : [],
            'sizes' => $this->sizes ? array_map('trim', explode(',', (string)$this->sizes)) : [],
            // 'specifications' => array_filter($this->specs, fn($s) => !empty($s['key'])),
        ]);

        // 1. Handle Category
        $finalCatId = $this->product_category_id;
        if ($this->product_category_id === 'other') {
            $this->validate(['new_category_name' => 'required|string|min:3']);
            $slug = Str::slug($this->new_category_name);
            
            // Check if it exists first to avoid duplicates
            $category = ProductCategory::where('slug', $slug)->first();
            if (!$category) {
                $category = ProductCategory::create([
                    'name' => $this->new_category_name,
                    'slug' => $slug,
                    'is_approved' => false,
                    'created_by' => Auth::id()
                ]);
            }
            $finalCatId = $category->id;
        }

        // 2. Handle Subcategory
        $finalSubCatId = $this->product_sub_category_id;
        if ($this->is_other_subcategory || $this->product_sub_category_id === 'other') {
            $this->validate(['new_subcategory_name' => 'required|string|min:2']);
            $subSlug = Str::slug($this->new_subcategory_name);

            $subCategory = ProductSubCategory::where('slug', $subSlug)
                ->where('product_category_id', $finalCatId)
                ->first();

            if (!$subCategory) {
                $subCategory = ProductSubCategory::create([
                    'product_category_id' => $finalCatId,
                    'name' => $this->new_subcategory_name,
                    'slug' => $subSlug,
                    // You may need to add 'is_approved' to your sub_categories table migration
                ]);
            }
            $finalSubCatId = $subCategory->id;
        }

        return redirect()->route('vendor.products')->with('message', 'Product updated successfully!');
    }

    public function render() {
        return view('livewire.vendor.edit-product')->layout('layouts.app');
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            // 1. Remove from the local array
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);

            // 2. Immediately update the Database
            $this->product->update([
                'images' => $this->existingImages
            ]);

            // 3. Optional: Flash a small message
            session()->flash('message', 'Image removed permanently.');
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
}