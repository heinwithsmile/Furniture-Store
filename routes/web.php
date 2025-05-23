<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerController;

// =============================================
// Auth Routes
// =============================================
Auth::routes();

// =============================================
// Shop Routes
// =============================================
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/home', 'index')->name('home');
});
Route::controller(ShopController::class)->prefix('customer')->group( function () {
    Route::get('/shop', 'index')->name('shop');
    Route::get('/shop/detail/{id}', 'detail')->name('shop.detail');
    Route::get('/payment/failure', function () {
        return 'Payment Failed!';
    })->name('payment.failure');
    Route::get('cart', 'showCartTable')->name('cart');
    Route::get('add-to-cart/{id}', 'addToCart')->name('add-to-cart');
    Route::get('remove-from-cart/{id}', 'removeCartItem')->name('remove-from-cart');
    Route::get('clear-cart', 'clearCart');
});
Route::post('stripe', [PaymentController::class, 'stripe'])->name('stripe');
Route::get('success', [PaymentController::class, 'success'])->name('success');
Route::get('cancel', [PaymentController::class, 'cancel'])->name('cancel');

// =============================================
// Admin Routes
// =============================================
Route::group(['prefix' => 'admin', 'middleware'=>['auth:admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::resource('banner', BannerController::class);
    Route::resource('customer', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::post('product/send',[ProductController::class,'send'])->name('product.send');
    Route::resource('order', OrderController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('report', ReportController::class);
    Route::resource('supplier', SupplierController::class);
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
});

// ========================================
// Custom Auth Routes
// ========================================
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/login/admin', [LoginController::class, 'adminLogin'])->name('admin.login.process');
Route::get('/login/customer', [LoginController::class, 'showCustomerLoginForm'])->name('login.customer');
Route::post('/login/customer', [LoginController::class, 'customerLogin'])->name('customer.login.process');
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register');
Route::get('/register/customer', [RegisterController::class, 'showCustomerRegisterForm'])->name('customer.register');


