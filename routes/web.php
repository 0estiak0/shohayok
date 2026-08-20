<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    HomeController,
    ListingController,
    BookingController,
    ProviderController,
    ProviderApplicationController,
    SupportController,
    ProviderMessageController,
    AdminController,
    UserProfileController,
    PublicProfileController
};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ListingController::class, 'explore'])
    ->middleware('auth')
    ->name('explore');
Route::get('/listing/{listing}', [ListingController::class, 'show'])->name('listing.show');
Route::get('/providers', [PublicProfileController::class, 'providers'])->name('providers.index');
Route::get('/providers/{provider}', [PublicProfileController::class, 'provider'])->name('providers.show');
Route::get('/works', [PublicProfileController::class, 'works'])->name('works.index');

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale,['en','bn'],true),404);
    session(['locale'=>$locale]);
    return back();
})->name('language.switch');
Route::view('/about', 'about')->name('about');
Route::view('/how-it-works', 'how-it-works')->name('how-it-works');
Route::view('/faq', 'faq')->name('faq');

use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('auth')
    ->name('contact.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications', [UserProfileController::class, 'notifications'])->name('notifications');
    Route::post('/listing/{listing}/book', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/works/{work}/like', [PublicProfileController::class, 'likeWork'])->name('works.like');

    Route::get('/become-provider', [ProviderApplicationController::class, 'show'])->name('provider.apply');
    Route::post('/become-provider', [ProviderApplicationController::class, 'store'])->name('provider.apply.store');

    Route::get('/support/messages', [SupportController::class, 'index'])->name('support.messages');
    Route::post('/support/messages', [SupportController::class, 'store'])->name('support.messages.store');
    Route::get('/messages/provider/{provider}', [ProviderMessageController::class, 'customerThread'])->name('customer.messages.thread');
    Route::post('/messages/provider/{provider}', [ProviderMessageController::class, 'customerStore'])->name('customer.messages.store');

    Route::middleware('role:provider')->prefix('provider')->name('provider.')->group(function () {
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [ProviderController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [ProviderController::class, 'editProfile'])->name('profile.edit');
        Route::patch('/profile', [ProviderController::class, 'updateProfile'])->name('profile.update');
        Route::get('/services', [ProviderController::class, 'services'])->name('services');
        Route::get('/works/create', [ProviderController::class, 'createWork'])->name('work.create');
        Route::get('/works', [ProviderController::class, 'works'])->name('works');
        Route::get('/reviews', [ProviderController::class, 'reviews'])->name('reviews');
        Route::get('/notifications', [ProviderController::class, 'notifications'])->name('notifications');
        Route::get('/settings', [ProviderController::class, 'settings'])->name('settings');
        Route::patch('/settings', [ProviderController::class, 'updateSettings'])->name('settings.update');
        Route::post('/listing', [ListingController::class, 'store'])->name('listing.store');
        Route::post('/work', [ProviderController::class, 'work'])->name('work.store');
        Route::get('/bookings', [BookingController::class, 'provider'])->name('bookings');
        Route::patch('/bookings/{booking}', [BookingController::class, 'update'])->name('booking.update');
        Route::get('/messages', [ProviderMessageController::class, 'index'])->name('messages');
        Route::get('/messages/{customer}', [ProviderMessageController::class, 'providerThread'])->name('messages.thread');
        Route::post('/messages/{customer}', [ProviderMessageController::class, 'providerStore'])->name('messages.store');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/providers/{user}/approve', [AdminController::class, 'approveProvider'])->name('providers.approve');
        Route::patch('/providers/{user}/reject', [AdminController::class, 'rejectProvider'])->name('providers.reject');

        Route::get('/provider-payments', [AdminController::class, 'providerPayments'])->name('provider-payments');
        Route::patch('/provider-payments/{providerPayment}/approve', [AdminController::class, 'approveProviderPayment'])->name('provider-payments.approve');
        Route::patch('/provider-payments/{providerPayment}/reject', [AdminController::class, 'rejectProviderPayment'])->name('provider-payments.reject');

        Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
        Route::get('/messages/{user}', [AdminController::class, 'messageThread'])->name('messages.thread');
        Route::post('/messages/{user}', [AdminController::class, 'replyMessage'])->name('messages.reply');

        Route::get('/banners', [AdminController::class, 'banners'])->name('banners');
        Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
        Route::get('/ads', [AdminController::class, 'ads'])->name('ads');
        Route::patch('/ads/{listing}', [AdminController::class, 'updateAd'])->name('ads.update');
        Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
        Route::post('/listings', [AdminController::class, 'storeListing'])->name('listings.store');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'userDetails'])->name('users.show');
    });
});
