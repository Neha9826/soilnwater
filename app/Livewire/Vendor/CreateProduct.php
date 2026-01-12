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

    // Basic & Existing
    public $name, $brand, $price, $stock_quantity, $sku, $description;
    public $category_id, $subcategory_id, $new_category_name, $is_other_category = false;
    public $categories = [], $subcategories = [];
    public $images = [], $colors, $sizes;
    public $weight, $dimensions, $video_url;
    public $specs = [['key' => '', 'value' => '']];

    // --- NEW ADVANCED FIELDS ---
    public $discount_percentage = 0;
    public $discounted_price = 0;
    public $shipping_charges = 0;
    
    public $is_sellable = false; // "Click to sell" toggle
    
    public $has_special_offer = false;
    public $special_offer_text = '';

    // Dynamic Tiered Pricing Rows
    public $tiered_pricing = [
        ['min_qty' => '', 'unit_price' => '']
    ];

    public function mount()
    {
        $this->categories = Category::whereNull('parent_id')->where('is_approved', true)->get();
    }

    // Auto-calculate Discounted Price when Percentage changes
    public function updatedDiscountPercentage($value)
    {
        if(is_numeric($this->price) && is_numeric($value)) {
            $discount = ($this->price * $value) / 100;
            $this->discounted_price = $this->price - $discount;
        }
    }

    // Auto-calculate Discounted Price when Base Price changes
    public function updatedPrice($value)
    {
        if(is_numeric($value) && is_numeric($this->discount_percentage)) {
            $discount = ($value * $this->discount_percentage) / 100;
            $this->discounted_price = $value - $discount;
        }
    }

    public function addTier()
    {
        $this->tiered_pricing[] = ['min_qty' => '', 'unit_price' => ''];
    }

    public function removeTier($index)
    {
        unset($this->tiered_pricing[$index]);
        $this->tiered_pricing = array_values($this->tiered_pricing);
    }
    
    // ... (Keep existing updatedCategoryId, addSpec, removeSpec functions) ...
    public function updatedCategoryId($value) { /* ... keep existing logic ... */ }
    public function addSpec() { $this->specs[] = ['key' => '', 'value' => '']; }
    public function removeSpec($index) { unset($this->specs[$index]); $this->specs = array_values($this->specs); }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'discount_percentage' => 'numeric|min:0|max:100',
        ]);

        // ... (Keep existing Category & Image processing logic) ...
        $finalCatId = $this->category_id; // (Reuse your existing logic here)
        $imagePaths = []; // (Reuse your existing logic here)
        foreach ($this->images as $img) { $imagePaths[] = $img->store('products', 'public'); }
        
        // Clean up Tiered Pricing (remove empty rows)
        $cleanTiers = [];
        foreach ($this->tiered_pricing as $tier) {
            if (!empty($tier['min_qty']) && !empty($tier['unit_price'])) {
                $cleanTiers[] = $tier;
            }
        }

        // Clean up Specs
        $cleanSpecs = [];
        foreach ($this->specs as $spec) {
            if (!empty($spec['key'])) $cleanSpecs[$spec['key']] = $spec['value'];
        }

        Product::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . uniqid(),
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity ?? 0,
            'sku' => $this->sku ?? strtoupper(Str::random(10)),
            'brand' => $this->brand,
            'category_id' => $finalCatId,
            'subcategory_id' => is_numeric($this->subcategory_id) ? $this->subcategory_id : null,
            'images' => $imagePaths,
            
            // Advanced Fields
            'discount_percentage' => $this->discount_percentage,
            'discounted_price' => $this->discounted_price,
            'shipping_charges' => $this->shipping_charges,
            'tiered_pricing' => $cleanTiers,
            'is_sellable' => $this->is_sellable,
            'has_special_offer' => $this->has_special_offer,
            'special_offer_text' => $this->has_special_offer ? $this->special_offer_text : null,
            
            // Existing Arrays
            'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
            'sizes' => $this->sizes ? array_map('trim', explode(',', $this->sizes)) : [],
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'specifications' => $cleanSpecs,
            'is_active' => true,
        ]);

        return redirect()->route('vendor.products')->with('message', 'Product listed successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.create-product')->layout('layouts.app');
    }
}