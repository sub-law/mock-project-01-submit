<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product_show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showloginform'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', fn() => view('auth.verify'))
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile_setup', [ProfileController::class, 'setup'])->name('profile.setup');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/profile_setup', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/sell', [ExhibitionController::class, 'create'])->name('sell.form');
    Route::post('/sell', [ExhibitionController::class, 'store'])->name('sell.store');

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'showpurchaseform'])->name('purchase');
    
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchaseconfirm'])->name('purchase.confirm');
    Route::get('/purchase/cancel', fn() => redirect()->route('index')->with('error', '決済がキャンセルされました'))->name('purchase.cancel');
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');


    Route::post('/comments', [CommentController::class, 'storecomment'])->name('comments.store');
    Route::post('/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->name('address_edit');
    Route::put('/purchase/address/{item_id}', [AddressController::class, 'update'])->name('address_update');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/mypage/profile', 'profile')->name('mypage.profile');
        Route::put('/mypage/profile', 'edit')->name('mypage.profile.edit');
    });

});
