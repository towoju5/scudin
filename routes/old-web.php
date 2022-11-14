<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('display-user', [UserController::class, 'index']);
// locale Route
Route::get('_lang/{locale}', [LanguageController::class, 'swap'])->name('lang');


// Route::group()
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// PayPal payment routes
Route::group(['prefix' => 'payment/paypal', 'as' => 'payment.paypal.'], function() {
    Route::get('return/{paymentId}', 'PaypalReturnController@return')->name('return');
    Route::get('cancel/{paymentId}', 'PaypalReturnController@cancel')->name('cancel');
});

// Stripe payment routes
Route::group(['prefix' => 'payment/stripe', 'as' => 'payment.stripe.'], function() {
    Route::get('return', 'StripeReturnController@return')->name('return');
    Route::get('cancel', 'StripeReturnController@cancel')->name('cancel');
});

#--------------------------------------------------
#   Cart routes. app(vanilo.cart)
#--------------------------------------------------
Route::group(['prefix' => 'cart', 'as' => 'cart.'], function(){
    // Route::any('add-item/{id}/{quantity}', [CartController::class, 'add'])->name('add');
    Route::get('show', [CartController::class, 'show'])->name('show');
    // Route::get('update', [CartController::class, 'update'])->name('update');
    // Route::any('remove/{sku}', [CartController::class, 'remove'])->name('remove');
});

Route::group(['prefix' => 'cart', 'as' => 'cart.', 'namespace' => 'Web'], function () {
    Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
    Route::post('add', 'CartController@addToCart')->name('add');
    Route::post('remove', 'CartController@removeFromCart')->name('remove');
    Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav_cart');
    Route::post('toolbar', 'CartController@updateToolbar')->name('toolbar');
    Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
});


#--------------------------------------------------
#   Checkout routes. app(vanilo.checkout)
#--------------------------------------------------
Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function(){
    Route::get('show', [CartController::class, 'show'])->name('show');
    Route::get('submit', [CartController::class, 'submit'])->name('submit');
    Route::get('remove', [CartController::class, 'remove'])->name('remove');
});

Route::post('sku-combination', [ProductController::class,'sku_combination'])->name('product.sku-combination');
