<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\PropertyDetail;
use App\Livewire\VendorProfile;

Route::get('/', HomePage::class)->name('home');
Route::get('/property/{slug}', PropertyDetail::class)->name('property.show');
Route::get('/v/{slug}', VendorProfile::class)->name('vendor.show');


// Temporary testing route
Route::get('/create-test-vendor', function () {
    // 1. Get your current Admin user
    $user = \App\Models\User::first();
    
    // 2. Give them a store name (This triggers the auto-QR code logic we wrote)
    $user->store_name = "Doon Hardware";
    $user->store_description = "Best hardware store in Dehradun.";
    $user->save();
    
    return "Success! Vendor Created. <a href='/v/doon-hardware'>Click here to view your Microsite</a>";
});