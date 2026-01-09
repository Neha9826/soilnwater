<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function show($slug)
    {
        // 1. Fetch the Business by Slug
        $vendor = Business::where('slug', $slug)->with('sections')->firstOrFail();

        // 2. Fetch Products/Properties belonging to this business
        $products = [];
        if ($vendor->type === 'vendor') {
            $products = Product::where('business_id', $vendor->id)->paginate(12);
        } else {
            $products = Property::where('business_id', $vendor->id)->paginate(12);
        }

        // 3. Return your original Public Profile View
        return view('public-profile', [
            'vendor' => $vendor,
            'products' => $products
        ]);
    }
}