<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC LIVEWIRE COMPONENTS
|--------------------------------------------------------------------------
*/
use App\Livewire\HomePage;
use App\Livewire\PropertyDetail;
use App\Livewire\ServiceDirectory;
use App\Livewire\HotelList;
use App\Livewire\ProjectList;
use App\Livewire\OffersPage;
use App\Livewire\ClassifiedList;
use App\Livewire\EditPublicProfile;
use App\Livewire\ShowPublicProfile;
use App\Livewire\Public\AllAds;
use App\Livewire\Vendor\EditProduct;

/*
|--------------------------------------------------------------------------
| USER / VENDOR COMPONENTS
|--------------------------------------------------------------------------
*/
use App\Livewire\UserDashboard;
use App\Livewire\UserProfile;
use App\Livewire\User\Onboarding;
use App\Livewire\User\JoinPartner;
use App\Livewire\Vendor\EditBusinessPage;
use App\Livewire\Vendor\ManageProducts;
use App\Livewire\Vendor\Properties;
use App\Models\Ad;

/*
|--------------------------------------------------------------------------
| IMAGE PROXY ROUTE (CRITICAL FIX FOR SHARED HOSTING)
|--------------------------------------------------------------------------
| Bypasses broken symlinks by serving images directly from private storage.
*/
Route::get('/view-image', function (Request $request) {
    $path = $request->query('path');
    
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
})->name('image.proxy');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/', HomePage::class)->name('home');
Route::get('/property/{slug}', PropertyDetail::class)->name('property.show');
Route::get('/services/{category?}', ServiceDirectory::class)->name('services.index');
Route::get('/hotels', HotelList::class)->name('hotels.index');
Route::get('/projects', ProjectList::class)->name('projects.index');
Route::get('/offers', OffersPage::class)->name('offers.index');
Route::get('/classifieds', ClassifiedList::class)->name('classifieds.index');
Route::get('/store/{slug}', ShowPublicProfile::class)->name('public.store');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (AUTH + VERIFIED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/manage-website', EditBusinessPage::class)->name('website.builder');
    Route::get('/manage-products', ManageProducts::class)->name('vendor.products');
    Route::get('/manage-products/create', \App\Livewire\Vendor\CreateProduct::class)->name('vendor.products.create');
    Route::get('/manage/profile', EditPublicProfile::class)->name('user.profile.public');

    // Properties
    Route::get('/vendor/properties', Properties::class)->name('vendor.properties');
    Route::get('/vendor/properties/create', \App\Livewire\Vendor\CreateProperty::class)->name('vendor.properties.create');
    Route::get('/vendor/properties/{id}/edit', \App\Livewire\Vendor\EditProperty::class)->name('vendor.properties.edit');
    // Ensure this is inside your 'vendor' middleware group
    Route::get('/vendor/products/{id}/edit', EditProduct::class)->name('vendor.products.edit');

    // Branches
    Route::get('/my-branches', \App\Livewire\Vendor\ManageBranches::class)->name('vendor.branches');
    Route::get('/my-branches/create', \App\Livewire\Vendor\CreateBranch::class)->name('vendor.branches.create');
    Route::get('/my-branches/{id}/edit', \App\Livewire\Vendor\EditBranch::class)->name('vendor.branches.edit');
    Route::get('/my-business', UserDashboard::class)->name('vendor.business');

    // Admin approvals
    Route::get('/admin/approvals/product/{id}', \App\Livewire\Admin\ProductApprovalDetail::class)->name('admin.product.approval');

    // Profile / onboarding
    Route::get('/profile', UserProfile::class)->name('profile.edit');
    Route::get('/onboarding', Onboarding::class)->name('onboarding');
    Route::get('/join-partner', JoinPartner::class)->name('join');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER AD SYSTEM
    |--------------------------------------------------------------------------
    */
    Route::get('/post/choose', \App\Livewire\PostAdSelection::class)->name('post.choose-category');
    Route::get('/my-listings', \App\Livewire\Customer\ManageListings::class)->name('customer.listings');
    Route::get('/post/property', \App\Livewire\Customer\PostProperty::class)->name('customer.property.create');
    Route::get('/post/project', \App\Livewire\Customer\PostProject::class)->name('customer.project.create');
    Route::get('/my-posts/{id}/edit', \App\Livewire\Customer\EditPost::class)->name('customer.post.edit');
    Route::get('/my-projects/{id}/edit', \App\Livewire\Customer\EditProject::class)->name('customer.project.edit');
    Route::get('/post/ad', \App\Livewire\Customer\CreateAd::class)->name('customer.ad.create');

    // Template test
    Route::get('/test-view', function () {
        return view('ads.templates.beauty_square', ['data' => []]);
    });
});

/*
|--------------------------------------------------------------------------
| INTERNAL AD PREVIEW ROUTE (GENERATION WRAPPER)
|--------------------------------------------------------------------------
*/
Route::get('/__internal/ad-preview/{ad}', function (Ad $ad) {
    $data = $ad->values->load('field')->mapWithKeys(fn ($item) => [
        $item->field->field_name => $item->value
    ])->toArray();

    return view('ads.previews.layout_wrapper', [
        'template' => $ad->template->blade_path,
        'data' => $data
    ]);
})->name('ads.preview');

/*
|--------------------------------------------------------------------------
| EMERGENCY UTILITIES
|--------------------------------------------------------------------------
*/
Route::get('/clear-site-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "All caches cleared successfully!";
});

/*
|--------------------------------------------------------------------------
| EMERGENCY MANUAL LOGIN
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

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.manual');

// Route::get('/display-ad/{filename}', function ($filename) {
//     $path = 'ads/previews/' . $filename;
//     if (!Storage::disk('public')->exists($path)) abort(404);
//     return response()->file(storage_path('app/public/' . $path));
// })->name('ad.display');

Route::get('/display-media', function (Request $request) {
    $path = $request->query('path');
    
    if (!$path || !Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return response()->file(storage_path('app/public/' . $path));
})->name('ad.display');

Route::get('/promotions', AllAds::class)->name('public.ads.index');