<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\PropertyDetail;
use App\Livewire\VendorProfile;
use App\Livewire\ServiceDirectory;
use App\Livewire\HotelList;
use App\Livewire\ProjectList;
use App\Livewire\OffersPage;
use Illuminate\Support\Facades\Auth;

Route::get('/', HomePage::class)->name('home');
Route::get('/property/{slug}', PropertyDetail::class)->name('property.show');
Route::get('/v/{slug}', VendorProfile::class)->name('vendor.show');
Route::get('/services/{category?}', ServiceDirectory::class)->name('services.index');
Route::get('/hotels', HotelList::class)->name('hotels.index');
Route::get('/projects', ProjectList::class)->name('projects.index');
Route::get('/offers', OffersPage::class)->name('offers.index');
Route::get('/dashboard', \App\Livewire\UserDashboard::class)->name('dashboard')->middleware('auth');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');