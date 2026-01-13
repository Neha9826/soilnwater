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

    // Basic
    public $name, $brand, $price, $stock_quantity, $sku, $description;
    public $category_id, $subcategory_id, $new_category_name, $is_other_category = false;
    public $categories = [], $subcategories = [];
    public $images = [], $video, $video_url, $colors, $sizes, $weight, $dimensions;
    public $specs = [['key' => '', 'value' => '']];
    public $discount_percentage = 0, $discounted_price = 0, $shipping_charges = 0;
    
    // Toggles
    public $is_sellable = false, $has_special_offer = false, $special_offer_text = '';
    
    // B2B Pricing
    public $tiered_pricing = [
        ['min_qty' => '', 'unit_price' => '']
    ];

    public function mount()
    {
        $this->categories = Category::whereNull('parent_id')->where('is_approved', true)->get();
    }

    // --- FIXED: CALCULATION LOGIC ---
    // --- FIXED: MULTIPLICATION LOGIC (Qty * Price) ---
    public function calculateTierPrice($index)
    {
        // 1. Get Base Price
        $basePrice = (float) $this->price;
        
        // 2. Get Quantity
        // Use (int) to ensure it's a number for math
        $qty = (int) ($this->tiered_pricing[$index]['min_qty'] ?? 0);

        // 3. Perform Multiplication
        // Only calculate if we have both values
        if ($basePrice > 0 && $qty > 0) {
            // Example: 10 Qty * 100 Price = 1000
            $this->tiered_pricing[$index]['unit_price'] = $basePrice * $qty; 
        }
    }
    // ------------------------------------------------

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

    public function addTier() { $this->tiered_pricing[] = ['min_qty' => '', 'unit_price' => '']; }
    public function removeTier($index) { unset($this->tiered_pricing[$index]); $this->tiered_pricing = array_values($this->tiered_pricing); }
    public function addSpec() { $this->specs[] = ['key' => '', 'value' => '']; }
    public function removeSpec($index) { unset($this->specs[$index]); $this->specs = array_values($this->specs); }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'video' => 'nullable|mimes:mp4,mov,ogg|max:20480',
        ]);

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

        $imagePaths = [];
        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('products', 'public');
        }

        $videoPath = null;
        if ($this->video) {
            $videoPath = $this->video->store('product_videos', 'public');
        }

        // Filter out empty rows
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
            'category_id' => $finalCatId,
            'subcategory_id' => is_numeric($this->subcategory_id) ? $this->subcategory_id : null,
            'images' => $imagePaths,
            'video_path' => $videoPath,
            'video_url' => $this->video_url,
            'is_sellable' => $this->is_sellable,
            'has_special_offer' => $this->has_special_offer,
            'special_offer_text' => $this->has_special_offer ? $this->special_offer_text : null,
            'tiered_pricing' => $cleanTiers,
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