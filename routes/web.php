<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Required for manual login
use App\Http\Controllers\GoogleAuthController;

// --- Public Components ---
use App\Livewire\HomePage;
use App\Livewire\PropertyDetail;
use App\Livewire\ServiceDirectory;
use App\Livewire\HotelList;
use App\Livewire\ProjectList;
use App\Livewire\OffersPage;
use App\Livewire\ClassifiedList;
use App\Livewire\EditPublicProfile; 
use App\Livewire\ShowPublicProfile;

// --- User/Vendor Components ---
use App\Livewire\UserDashboard;
use App\Livewire\UserProfile;
use App\Livewire\User\Onboarding;
use App\Livewire\User\JoinPartner;
use App\Livewire\Vendor\EditBusinessPage;
use App\Livewire\Vendor\ManageProducts;
use App\Livewire\Vendor\Properties;

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

// Public Store Page
Route::get('/store/{slug}', ShowPublicProfile::class)->name('public.store');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
    
    // Standard Livewire Login (Keep this for when JS is fixed)
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

    // 4. MANAGE PUBLIC PROFILE
    Route::get('/manage/profile', EditPublicProfile::class)->name('user.profile.public');
    
    // 5. MANAGE PROPERTIES
    Route::get('/vendor/properties', Properties::class)->name('vendor.properties');
    Route::get('/vendor/properties/create', \App\Livewire\Vendor\CreateProperty::class)->name('vendor.properties.create');
    Route::get('/vendor/properties/{id}/edit', \App\Livewire\Vendor\EditProperty::class)->name('vendor.properties.edit');

    // 6. MANAGE BRANCHES
    Route::get('/my-branches', \App\Livewire\Vendor\ManageBranches::class)->name('vendor.branches');
    Route::get('/my-branches/{id}/edit', \App\Livewire\Vendor\EditBranch::class)->name('vendor.branches.edit');
    Route::get('/my-branches/create', \App\Livewire\Vendor\CreateBranch::class)->name('vendor.branches.create');
    Route::get('/my-business', UserDashboard::class)->name('vendor.business'); 

    // 7. ADMIN / APPROVALS
    Route::get('/admin/approvals/product/{id}', \App\Livewire\Admin\ProductApprovalDetail::class)
        ->name('admin.product.approval');

    // 8. PROFILE & SETTINGS
    Route::get('/profile', UserProfile::class)->name('profile.edit');
    Route::get('/onboarding', Onboarding::class)->name('onboarding');
    Route::get('/join-partner', JoinPartner::class)->name('join');

    // 9. CUSTOMER AD POSTING SYSTEM
    // 9. CUSTOMER AD POSTING SYSTEM

    // The Selection Page
    Route::get('/post/choose', \App\Livewire\PostAdSelection::class)
        ->name('post.choose-category');

    // UNIFIED LISTING MANAGER (The new One-Stop Shop)
    Route::get('/my-listings', \App\Livewire\Customer\ManageListings::class)
        ->name('customer.listings');

    // -- Forms (Keep these accessible) --
    Route::get('/post/property', \App\Livewire\Customer\PostProperty::class)
        ->name('customer.property.create');

    Route::get('/post/project', \App\Livewire\Customer\PostProject::class)
        ->name('customer.project.create');

    // -- Edit Routes (Keep these for the Edit Buttons to work) --
    Route::get('/my-posts/{id}/edit', \App\Livewire\Customer\EditPost::class)
        ->name('customer.post.edit');

    Route::get('/my-projects/{id}/edit', \App\Livewire\Customer\EditProject::class)
        ->name('customer.project.edit');

    Route::get('/post/ad', \App\Livewire\Customer\CreateAd::class)->name('customer.ad.create');
        
    // -- Old Routes (Optional: You can remove 'customer.my-posts' and 'customer.my-projects' GET routes if you rely solely on the manager) --
});

/*
|--------------------------------------------------------------------------
| EMERGENCY MANUAL LOGIN ROUTE (For use with Safe Mode HTML Form)
|--------------------------------------------------------------------------
*/
Route::post('/login-manual', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->email === 'admin@demo.com') return redirect('/admin');
        if ($user->profile_type === 'customer') return redirect('/');
        
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('login.manual');