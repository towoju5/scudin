<?php

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

use App\Http\Controllers\Seller\Auth\LoginController;
use App\Http\Controllers\Seller\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Seller', 'prefix' => 'seller', 'as' => 'seller.'], function () {

    Route::any('send_otp', [LoginController::class, 'send_otp'])->name('register.otp');

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('verify/show', 'LoginController@show')->name('show.seller.verify'); 
    });

    /*authenticated*/
    Route::group(['middleware' => ['seller']], function () {
        Route::get('dashboard', 'SystemController@dashboard')->name('dashboard');

        Route::get('fees-and-pricing', 'SystemController@feespricing')->name('fees.pricing');

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::post('image-upload', 'ProductController@imageUpload')->name('image-upload');
            Route::get('remove-image', 'ProductController@remove_image')->name('remove-image');
            Route::get('add-new', 'ProductController@add_new')->name('add-new');
            Route::post('add-new', 'ProductController@store')->name('store');
            Route::post('status-update', 'ProductController@status_update')->name('status-update');
            Route::get('list', 'ProductController@list')->name('list');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::post('update/{id}', 'ProductController@update')->name('update');
            Route::post('sku-combination', 'ProductController@sku_combination')->name('sku-combination');
            Route::get('get-categories', 'ProductController@get_categories')->name('get-categories');

            Route::get('bulk-import', 'ProductController@bulk_import_index')->name('bulk-import');
            Route::post('bulk-import', 'ProductController@bulk_import_data');
            Route::get('bulk-export', 'ProductController@bulk_export_data')->name('bulk-export');

            Route::any('sponsor-product', 'ProductController@promote')->name('promote');
            Route::any('terminate-sponsor-product/{id}', 'ProductController@terminate_promote')->name('end-promotion');
            Route::any('add-sponsor-product/{id}/{days}', 'ProductController@add_promote')->name('add-promotion');

            Route::match(['get', 'post'], 'import', 'ProductController@import')->name('import'); // import product from csv

            Route::get('delete/{id}', 'ProductController@delete')->name('delete');

            Route::get('view/{id}', 'ProductController@view')->name('view');
        });

        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('list/{status}', 'OrderController@list')->name('list');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            Route::get('generate-invoice/{id}', 'OrderController@generate_invoice')->name('generate-invoice');
            Route::post('status', 'OrderController@status')->name('status');
            Route::post('productStatus', 'OrderController@productStatus')->name('productStatus');
        });
        //Product Reviews

        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            Route::get('list', 'ReviewsController@list')->name('list');
        });

        // Messaging
        Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
            Route::get('/chat', 'ChattingController@chat')->name('chat');
            Route::get('/message-by-user', 'ChattingController@message_by_user')->name('message_by_user');
            Route::post('/seller-message-store', 'ChattingController@seller_message_store')->name('seller_message_store');
        });
        // profile

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('view', 'ProfileController@view')->name('view');
            Route::get('update/{id}', 'ProfileController@edit')->name('update');
            Route::post('update/{id}', 'ProfileController@update');
            Route::post('settings-password', 'ProfileController@settings_password_update')->name('settings-password');

            Route::get('bank-edit/{id}', 'ProfileController@bank_edit')->name('bankInfo');
            Route::post('bank-update/{id}', 'ProfileController@bank_update')->name('bank_update');
            Route::post('paypal-update/{id}', 'ProfileController@paypal_update')->name('paypal_update');
        });
        Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
            Route::get('view', 'ShopController@view')->name('view');
            Route::get('edit/{id}', 'ShopController@edit')->name('edit');
            Route::post('update/{id}', 'ShopController@update')->name('update');
        });

        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('index', 'WithdrawController@index')->name('index');
            Route::post('request', 'WithdrawController@w_request')->name('request');
            Route::post('schedule-update', 'WithdrawController@schedule')->name('schedule');
            Route::delete('close/{id}', 'WithdrawController@close_request')->name('close');
        });

        Route::group(['prefix' => 'business-settings', 'as' => 'business-settings.'], function () {

            Route::group(['prefix' => 'shipping-method', 'as' => 'shipping-method.'], function () {
                Route::get('add', 'ShippingMethodController@index')->name('add');
                Route::post('add', 'ShippingMethodController@store');
                Route::get('edit/{id}', 'ShippingMethodController@edit')->name('edit');
                Route::post('update/{id}', 'ShippingMethodController@update')->name('update');
                Route::delete('delete/{id}', 'ShippingMethodController@delete')->name('delete');
                Route::post('status-update', 'ShippingMethodController@status_update')->name('status-update');
            });
        });

        /* Coupon */
        Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
            Route::get('add-new', 'CouponController@add_new')->name('add-new');
            Route::post('add-new', 'CouponController@store');
            Route::get('update/{id}', 'CouponController@edit')->name('update');
            Route::get('delete/{id}', 'CouponController@delete')->name('delete');
            Route::post('update/{id}', 'CouponController@update');
            Route::post('status', 'CouponController@status')->name('status');
            Route::get('delete/{id}/coupon', 'CouponController@delete')->name('delete');
        });

        Route::group(['prefix' => 'susbscription', 'as' => 'subscription.' ], function(){
            Route::any('buy/{id}/plan', [SubscriptionController::class, 'activate'])->name('buy');
        });

    });
});

Route::post('/seller/auth/email/resend', '\App\Http\Controllers\Seller\Auth\LoginController@resend')->name('seller.resend');

Route::get('seller/account/verify/{token}', '\App\Http\Controllers\Seller\Auth\LoginController@verifyAccount')->name('seller.verify'); 
