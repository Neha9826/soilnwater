<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PublicProfileController;

// --- Livewire Components ---
use App\Livewire\HomePage;
use App\Livewire\PropertyDetail;
use App\Livewire\ServiceDirectory;
use App\Livewire\HotelList;
use App\Livewire\ProjectList;
use App\Livewire\OffersPage;
use App\Livewire\ClassifiedList;
use App\Livewire\UserDashboard;
use App\Livewire\UserProfile;
use App\Livewire\User\Onboarding;
use App\Livewire\User\JoinPartner;

// --- Vendor Components ---
use App\Livewire\Vendor\EditBusinessPage;
use App\Livewire\Vendor\ManageProducts;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (No Login Required)
|--------------------------------------------------------------------------
*/

Route::get('/', HomePage::class)->name('home');
Route::get('/property/{slug}', PropertyDetail::class)->name('property.show');
Route::get('/services/{category?}', ServiceDirectory::class)->name('services.index');
Route::get('/hotels', HotelList::class)->name('hotels.index');
Route::get('/projects', ProjectList::class)->name('projects.index');
Route::get('/offers', OffersPage::class)->name('offers.index');
Route::get('/classifieds', ClassifiedList::class)->name('classifieds.index');

// 1. PUBLIC VENDOR PAGE (The "View Live" link)
Route::get('/v/{slug}', [PublicProfileController::class, 'show'])->name('public.profile');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    
    // Google Auth
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD OVERVIEW
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');

    // 2. WEBSITE BUILDER
    Route::get('/manage-website', EditBusinessPage::class)->name('website.builder'); 

    // 3. MANAGE PRODUCTS
    Route::get('/manage-products', ManageProducts::class)->name('vendor.products');
    Route::get('/manage-products/create', App\Livewire\Vendor\CreateProduct::class)->name('vendor.products.create');

    // 4. MY BRANCHES (Added BOTH names to prevent crashes)
    // Route::get('/my-branches', UserDashboard::class)->name('vendor.branches');
    Route::get('/my-branches', \App\Livewire\Vendor\ManageBranches::class)->name('vendor.branches');
    Route::get('/my-business', UserDashboard::class)->name('vendor.business'); 
    Route::get('/my-branches/{id}/edit', \App\Livewire\Vendor\EditBranch::class)->name('vendor.branches.edit');
    Route::get('/my-branches/create', \App\Livewire\Vendor\CreateBranch::class)->name('vendor.branches.create');

    // 5. PROFILE & SETTINGS
    Route::get('/profile', UserProfile::class)->name('profile.edit');
    Route::get('/onboarding', Onboarding::class)->name('onboarding');
    Route::get('/join-partner', JoinPartner::class)->name('join');

});