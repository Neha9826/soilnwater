<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show($slug)
    {
        // 1. Find User
        $vendor = User::where('store_slug', $slug)->firstOrFail();

        // 2. Fetch Products/Properties
        $products = [];
        if ($vendor->profile_type === 'vendor') {
            $products = Product::where('user_id', $vendor->id)->paginate(12);
        } else {
            $products = Property::where('user_id', $vendor->id)->paginate(12);
        }

        // 3. Decode JSON
        if (is_string($vendor->page_sections)) {
            $vendor->page_sections = json_decode($vendor->page_sections, true);
        }
        if (is_string($vendor->header_images)) {
            $vendor->header_images = json_decode($vendor->header_images, true);
        }

        // FIX IS HERE: Point to 'livewire.vendor.public-profile'
        return view('livewire.vendor.public-profile', [
            'vendor' => $vendor,
            'products' => $products
        ]);
    }
}