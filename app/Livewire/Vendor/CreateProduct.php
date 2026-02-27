<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateProduct extends Component
{
    use WithFileUploads;

    // Basic
    public $name, $brand, $price, $stock_quantity, $sku, $description;
    
    // Categorization
    public $product_category_id, $product_sub_category_id, $new_category_name, $new_subcategory_name;
    public $is_other_category = false;
    public $is_other_subcategory = false;
    
    public $categories = [], $subcategories = [];
    public $images = [], $video, $video_url, $colors, $sizes, $weight, $dimensions;
    public $specs = [['key' => '', 'value' => '']];
    public $discount_percentage = 0, $discounted_price = 0, $shipping_charges = 0;
    
    // Toggles
    public $is_sellable = false;
    
    // B2B Pricing
    public $tiered_pricing = [
        ['min_qty' => '', 'unit_price' => '']
    ];

    public function mount()
    {
        $this->categories = ProductCategory::where('is_approved', true)->get();
    }

    public function calculateTierPrice($index)
    {
        $basePrice = (float) $this->price;
        $qty = (int) ($this->tiered_pricing[$index]['min_qty'] ?? 0);

        if ($basePrice > 0 && $qty > 0) {
            $this->tiered_pricing[$index]['unit_price'] = $basePrice * $qty; 
        }
    }

    public function updatedDiscountPercentage($value)
    {
        if(is_numeric($this->price) && is_numeric($value)) {
            $discount = ($this->price * $value) / 100;
            $this->discounted_price = $this->price - $discount;
        }
    }

    public function updatedPrice($value)
    {
        if(is_numeric($value) && is_numeric($this->discount_percentage)) {
            $discount = ($value * $this->discount_percentage) / 100;
            $this->discounted_price = $value - $discount;
        }
    }

    public function updatedProductCategoryId($value)
    {
        if ($value === 'other') {
            $this->is_other_category = true;
            $this->is_other_subcategory = true; // Force other subcategory if category is new
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

    public function addTier() { $this->tiered_pricing[] = ['min_qty' => '', 'unit_price' => '']; }
    public function removeTier($index) { unset($this->tiered_pricing[$index]); $this->tiered_pricing = array_values($this->tiered_pricing); }
    public function addSpec() { $this->specs[] = ['key' => '', 'value' => '']; }
    public function removeSpec($index) { unset($this->specs[$index]); $this->specs = array_values($this->specs); }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'product_category_id' => 'required',
            'video' => 'nullable|mimes:mp4,mov,ogg|max:20480',
        ]);

        // Handle Category with Duplicate Prevention
        $finalCatId = $this->product_category_id;
        if ($this->product_category_id === 'other') {
            $this->validate(['new_category_name' => 'required|string|min:3']);
            $slug = Str::slug($this->new_category_name);
            
            // Check for existing unapproved or approved category to avoid duplicates
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

        // Handle Subcategory with Duplicate Prevention
        $finalSubCatId = is_numeric($this->product_sub_category_id) ? $this->product_sub_category_id : null;
        if ($this->is_other_subcategory || $this->product_sub_category_id === 'other') {
            $this->validate(['new_subcategory_name' => 'required|string|min:2']);
            $subSlug = Str::slug($this->new_subcategory_name);

            // Check if this subcategory already exists under this parent
            $subCategory = ProductSubCategory::where('slug', $subSlug)
                ->where('product_category_id', $finalCatId)
                ->first();

            if (!$subCategory) {
                $subCategory = ProductSubCategory::create([
                    'product_category_id' => $finalCatId,
                    'name' => $this->new_subcategory_name,
                    'slug' => $subSlug,
                    // Note: Subcategories are linked to the parent's approval status in this flow
                ]);
            }
            $finalSubCatId = $subCategory->id;
        }

        $imagePaths = [];
        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('products', 'public');
        }

        $videoPath = null;
        if ($this->video) {
            $videoPath = $this->video->store('product_videos', 'public');
        }

        $cleanTiers = array_filter($this->tiered_pricing, fn($t) => !empty($t['min_qty']) && !empty($t['unit_price']));
        $cleanSpecs = array_filter($this->specs, fn($s) => !empty($s['key']));

        Product::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . uniqid(),
            'description' => $this->description,
            'price' => $this->price,
            'discount_percentage' => $this->discount_percentage,
            'discounted_price' => $this->discounted_price,
            'stock_quantity' => $this->stock_quantity ?? 0,
            'shipping_charges' => $this->shipping_charges,
            'sku' => $this->sku ?? strtoupper(Str::random(10)),
            'brand' => $this->brand,
            'product_category_id' => $finalCatId,
            'product_sub_category_id' => $finalSubCatId,
            'images' => $imagePaths,
            'video_path' => $videoPath,
            'video_url' => $this->video_url,
            'is_sellable' => $this->is_sellable,
            'tiered_pricing' => $cleanTiers,
            'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
            'sizes' => $this->sizes ? array_map('trim', explode(',', $this->sizes)) : [],
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'specifications' => $cleanSpecs,
            'is_active' => true,
            'is_approved' => false, 
        ]);

        return redirect()->route('vendor.products')->with('message', 'Product listed successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.create-product')->layout('layouts.app');
    }
}