<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleAuthController;

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
use App\Livewire\Vendor\EditBusinessPage;
// use App\Livewire\EditBusinessPage;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\BusinessController;
use App\Livewire\Vendor\ManageProducts;
use App\Livewire\Vendor\PublicProfile;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\User\JoinPartner;

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

// Public Vendor Page (e.g., soilnwater.in/v/abc-hardware)
// Note: This must be below other specific routes to avoid conflicts
Route::get('/v/{slug}', PublicProfile::class)->name('vendor.public');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Login, Register, Social Auth)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
    
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

Route::middleware([
    'auth', // <--- FIXED: Changed from 'auth:sanctum' to 'auth'
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');

    // 2. Profile Settings
    Route::get('/profile', UserProfile::class)->name('profile.edit');

    // 3. New Business Registration
    Route::get('/onboarding', Onboarding::class)->name('onboarding');

    // 4. Business Context Switcher (Sets the active business ID in session)
    Route::get('/business/{id}/manage', function($id) {
        // Security: Ensure user owns this business
        $exists = \App\Models\Business::where('id', $id)->where('user_id', Auth::id())->exists();
        
        if ($exists) {
            session(['active_business_id' => $id]);
            return redirect()->route('vendor.products');
        }
        
        return redirect()->route('dashboard')->with('error', 'Unauthorized access');
    })->name('business.manage');

   

    // 1. The Builder (Where you edit the design)
    Route::get('/manage-website', EditBusinessPage::class)
        ->middleware(['auth'])
        ->name('website.builder'); 

    // 2. The Public Page (What visitors see)
    Route::get('/v/{slug}', [PublicProfileController::class, 'show'])
        ->name('public.profile');

    // 5. Manage Products (Loads data based on 'active_business_id' session)
    Route::get('/my-products', ManageProducts::class)->name('vendor.products');

    // 6. Manage Website / Business Page
    Route::get('/my-business', EditBusinessPage::class)->name('vendor.business');

    // ... inside auth group ...

// New Route: Selection Page
Route::get('/join-partner', \App\Livewire\User\JoinPartner::class)->name('join.partner');
Route::get('/join-partner', JoinPartner::class)->name('join');

// Existing Routes
Route::get('/onboarding', \App\Livewire\User\Onboarding::class)->name('onboarding');

});