<?php

use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\AttributesController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalReturnController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StripeReturnController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\seller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('front.home');
// });

// Route::group()
Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('vendor.dashboard')->middleware('seller');

// shop & Product
Route::group(['prefix' => 'shop/product', 'middleware' => 'seller', 'as' => 'product.'], function () {
    Route::get('index', [ProductController::class, 'index'])->name('index');
    Route::any('categories', [ProductController::class, 'categories'])->name('categories');
    Route::get('add-product', [ProductController::class, 'add_new'])->name('add');
    Route::post('save-product', [ProductController::class, 'store'])->name('store');
    Route::get('c/{taxonomyName}/{taxon}', [ProductController::class, 'index'])->name('category');
    Route::get('p/{product}', [ProductController::class, 'show'])->name('show');
    // Route::post('sku-combination', [ProductController::class, 'sku_combination'])->name('sku-combination');
});

// // Product Atttributes
// Route::group(['prefix' => 'shop/', 'middleware' => 'seller'], function () {
//     Route::resource('attr', AttributesController::class);
// });

// Product categories
Route::group(['prefix' => 'shop/cat', 'middleware' => 'admin', 'as' => 'cat.'], function () {
    Route::any('index', [CategoriesController::class, 'index'])->name('index');
    Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [CategoriesController::class, 'update'])->name('update');
    Route::post('store', [CategoriesController::class, 'store'])->name('store');
});

// Orders
Route::group(['prefix' => 'shop', 'middleware' => 'seller', 'as' => 'order.'], function () {
    Route::get('index', [OrderController::class, 'index'])->name('index');
    Route::get('order/{id}', [OrderController::class, 'show'])->name('show');
});

// un-monitored routes
Route::group(['prefix' => 'seller/shop', 'middleware' => 'seller', 'as' => 'vendor.'], function () {
    Route::any('reports', [ChartsController::class, 'chart'])->name('reports');

    Route::any('delivery', [CalenderController::class, 'calender'])->name('delivery.time');
    //Route::any('calendar-crud-ajax', [CalenderController::class, 'calendarEvents'])->name('calender');
    
    Route::any('review', [ReviewsController::class, 'review'])->name('review');
    Route::any('withdraw', [HomeController::class, 'withdraw'])->name('withdraw');

    Route::any('return', [ReturnController::class, 'index'])->name('return.request');
    Route::any('return/{id}', [ReturnController::class, 'show'])->name('return.show');

    Route::any('analytics', [ReviewsController::class, 'analytics'])->name('analytics');
    Route::any('subscription', [UserController::class, 'subscription'])->name('subscription');
});

#-----------------------------------------------------
#   Staffs
#-----------------------------------------------------
Route::group(['prefix' => 'seller/shop', 'middleware' => 'seller'], function () {
    //staff route via resources
    Route::any('staff/{id}/destroy', [StaffController::class, 'destroy']);
    Route::resource('staff', StaffController::class);
});


#----------------------------------------------------
#   Coupon routes
#----------------------------------------------------
Route::group(['prefix' => 'shop', 'middleware' => 'seller', 'as' => 'coupon.'], function () {
    Route::get('coupons', [CouponController::class, 'index'])->name('index');
    Route::get('coupon/{id}/edit', [CouponController::class, 'edit'])->name('edit');
    Route::put('coupon/edit/{id}', [CouponController::class, 'update'])->name('update');
    Route::post('coupon/save', [CouponController::class, 'save'])->name('store');
    Route::any('coupon/{id}/destroy', [CouponController::class, 'delete'])->name('destroy');
});


#----------------------------------------------------
#   ChartsController routes
#----------------------------------------------------
Route::group(['prefix' => 'chart', 'as' => 'chart.'], function () {
    Route::get('index', [ChartsController::class, 'chart'])->name('index');
    Route::get('dayBasedChart', [ChartsController::class, 'dayBasedChart'])->name('day_based');
    Route::get('dayBasedSellersChart', [ChartsController::class, 'dayBasedSellersChart'])->name('seller.day_based');
});

#----------------------------------------------------
#   Stripe and PayPal Payment Route
#----------------------------------------------------
// PayPal payment routes
Route::group(['prefix' => 'payment/paypal', 'as' => 'payment.paypal.'], function () {
    Route::get('return/{paymentId}', [PaypalReturnController::class, 'return'])->name('return');
    Route::get('cancel/{paymentId}', [PaypalReturnController::class, 'cancel'])->name('cancel');
});

// Stripe payment routes
Route::group(['prefix' => 'payment/stripe', 'as' => 'payment.stripe.'], function () {
    Route::get('return', [StripeReturnController::class, 'return'])->name('return');
    Route::get('cancel', [StripeReturnController::class, 'cancel'])->name('cancel');
});
