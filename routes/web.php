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
use App\Livewire\Vendor\CreateOffer;

use App\Models\Ad;

use App\Livewire\Public\RealEstateListing;
use App\Livewire\Public\ProjectListing;
use App\Livewire\Public\ProjectDetail;
use App\Livewire\Public\OffersListing;
use App\Livewire\Public\PropertyListing;
use App\Livewire\Public\ProductListing;
use App\Livewire\Public\ProductDetail;
use App\Livewire\Public\CartPage;
use App\Livewire\Public\CheckoutPage;
use App\Livewire\Public\OrderSuccess;

use App\Livewire\Customer\MyOrders;
use App\Livewire\Customer\MyPosts;
use App\Livewire\Customer\EditPost;
use App\Livewire\Customer\ManageListings;


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
// Route::get('/property/{slug}', PropertyDetail::class)->name('property.show');
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
    // Move your customer routes into a group to ensure they are prefixed with 'customer.'
    Route::name('customer.')->group(function () {

        Route::get('/my-listings', ManageListings::class)->name('listings');

        // Use 'listings' as the name so route('customer.listings') works in your navbar
        // Route::get('/my-listings', MyPosts::class)->name('listings');
        
        Route::get('/my-posts/{id}/edit', EditPost::class)->name('post.edit');
        Route::get('/my-projects/{id}/edit', \App\Livewire\Customer\EditProject::class)->name('project.edit');
        
        Route::get('/post/property', \App\Livewire\Customer\PostProperty::class)->name('property.create');
        Route::get('/post/project', \App\Livewire\Customer\PostProject::class)->name('project.create');
        Route::get('/post/ad', \App\Livewire\Customer\CreateAd::class)->name('ad.create');
    });;

    Route::get('/post/offer', CreateOffer::class)->name('public.offer.create');

    // Template test
    Route::get('/test-view', function () {
        return view('ads.templates.beauty_square', ['data' => []]);
    });

    Route::get('/cart', CartPage::class)->name('cart.index');
    Route::get('/wishlist', function() { 
        return "Wishlist Page Coming Soon"; 
    })->name('wishlist.index');

    Route::get('/checkout', \App\Livewire\Public\CheckoutPage::class)->name('checkout.index');

    Route::get('/my-orders', MyOrders::class)->name('customer.orders');

    Route::get('/order-success/{order_number}', OrderSuccess::class)->name('order.success');

    Route::get('/my-orders/{order_number}', \App\Livewire\Public\OrderDetail::class)->name('order.detail');

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

Route::get('/display-media', function (Illuminate\Http\Request $request) {
    $path = $request->query('path');
    $storagePath = storage_path('app/public/' . $path);

    if (!file_exists($storagePath)) {
        // Fallback to a local placeholder if file is missing
        return response()->file(public_path('images/placeholder.png'));
    }

    return response()->file($storagePath);
})->name('ad.display');

Route::get('/promotions', AllAds::class)->name('public.ads.index');

Route::get('/property-detail/{id}', \App\Livewire\Public\PropertyDetail::class)->name('public.property.detail');



// Public Marketplace Route
Route::get('/marketplace', ProductListing::class)->name('public.products.index');

// Public Product Detail Route
Route::get('/product/{slug}', ProductDetail::class)->name('public.product.detail');

// web.php

// 1. Marketplace (Already exists)
// Route::get('/marketplace', ProductListing::class)->name('public.products.index');

// 2. Real Estate (Builders)
Route::get('/real-estate', RealEstateListing::class)->name('public.realestate.index');  

// 3. Upcoming Projects
Route::get('/projects', ProjectListing::class)->name('public.projects.index');

Route::get('/projects/{slug}', ProjectDetail::class)->name('public.project.detail');

// 4. Hot Offers
Route::get('/deals', OffersListing::class)->name('public.offers.index');

// 5. User Properties (Classifieds)
Route::get('/properties', PropertyListing::class)->name('public.properties.index');

Route::get('/offer-detail/{id}', \App\Livewire\Public\OfferDetail::class)->name('public.offer.detail');