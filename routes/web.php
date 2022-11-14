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

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\Seller\Auth\RegisterController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ChattingController;
use App\Http\Controllers\Web\CouponController;
use App\Http\Controllers\Web\CurrencyController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\UserProfileController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Seller\SubscriptionController;
use App\Http\Controllers\UserController;
use App\PromotionData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

//use App\Http\Controllers\Web;


// Route::get('/send-notification', [NotificationController::class, 'sendOfferNotification']);
// locale Route
Route::get('_lang/{locale}', [LanguageController::class, 'swap'])->name('lang');


// Route::get('/', function(){
//     $val = "['column_1' => 'Customer Service', 'column_2' => 'Corporation', 'column_3' => 'Why choose Us']";
//     updateDotEnv('MenuColumns', $val);
// });

Route::group(['namespace' => 'Web'], function () {
    Route::get('/', [WebController::class, 'home'])->name('home');
    Route::get('article/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('blog/index', [BlogController::class, 'list'])->name('blog.list');

    // Dashboard main page
    Route::get('dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard')->middleware('customer');

    Route::get('quick-view', [WebController::class, 'quick_view'])->name('quick-view');
    Route::get('searched-products', [WebController::class, 'searched_products'])->name('searched-products');
    Route::get('checkout-details', [WebController::class, 'checkout_details'])->name('checkout-details')->middleware('customer');
    Route::get('checkout-shipping', [WebController::class, 'checkout_shipping'])->name('checkout-shipping')->middleware('customer');
    Route::get('checkout-payment', [WebController::class, 'checkout_payment'])->name('checkout-payment')->middleware('customer');
    Route::get('checkout-review', [WebController::class, 'checkout_review'])->name('checkout-review')->middleware('customer');
    Route::get('checkout-complete', [WebController::class, 'checkout_complete'])->name('checkout-complete')->middleware('customer');
    Route::get('cart/show', [WebController::class, 'shop_cart'])->name('shop-cart');

    Route::group(['middleware' => ['auth:customer'], 'as' => 'plans.'], function () {
        Route::get('plans/list', [UserController::class, 'plans'])->name('list');
        Route::any('plans/buy/{id}/plan', [UserController::class, 'activate'])->name('buy');
    });

    Route::get('categories', [WebController::class, 'all_categories'])->name('categories');
    Route::get('category-ajax/{id}', [WebController::class, 'categories_by_category'])->name('category-ajax');

    Route::get('brands', [WebController::class, 'all_brands'])->name('brands');
    Route::get('get_p_type', [WebController::class, 'get_p_type'])->name('get_p_type');

    Route::get('flash-deals/{id}', [WebController::class, 'flash_deals'])->name('flash-deals');

    Route::get('terms', [WebController::class, 'termsandCondition'])->name('terms');
    Route::get('privacy-policy', [WebController::class, 'privacy_policy'])->name('privacy');
    Route::get('return-policy', [WebController::class, 'return_policy'])->name('return');

    Route::get('/product/{slug}', [WebController::class, 'product'])->name('product');
    Route::get('products', [WebController::class, 'products'])->name('products');
    Route::get('orderDetails', [WebController::class, 'orderdetails'])->name('orderdetails');

    //Chat with seller from product details
    Route::get('chat-for-product', [WebController::class, 'chat_for_product'])->name('chat-for-product');

    Route::get('wishlists', [WebController::class, 'viewWishlist'])->name('wishlists')->middleware('customer');
    Route::post('store-wishlist', [WebController::class, 'storeWishlist'])->name('store-wishlist');
    Route::post('delete-wishlist', [WebController::class, 'deleteWishlist'])->name('delete-wishlist');

    Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');


    Route::get('about-us', [WebController::class, 'about_us'])->name('about-us');    
    Route::get('sell-on-scudin', [WebController::class, 'sell_on_scudin'])->name('sell-on-scudin');


    //profile Route
    Route::get('user-account', [UserProfileController::class, 'user_account'])->name('user-account');
    Route::post('user-account-update', [UserProfileController::class, 'user_update'])->name('user-update');
    Route::post('user-account-picture', [UserProfileController::class, 'user_picture'])->name('user-picture');
    Route::get('account-address', [UserProfileController::class, 'account_address'])->name('account-address');
    Route::post('account-address-store', [UserProfileController::class, 'address_store'])->name('address-store');
    Route::get('account-address-delete', [UserProfileController::class, 'address_delete'])->name('address-delete');
    Route::post('account-address-update', [UserProfileController::class, 'address_update'])->name('address-update');
    Route::get('account-payment', [UserProfileController::class, 'account_payment'])->name('account-payment');
    Route::get('account-oder', [UserProfileController::class, 'account_oder'])->name('account-oder');
    Route::get('account-order-details', [UserProfileController::class, 'account_order_details'])->name('account-order-details');
    Route::get('generate-invoice/{id}', [UserProfileController::class, 'generate_invoice'])->name('generate-invoice');
    Route::get('account-wishlist', [UserProfileController::class, 'account_wishlist'])->name('account-wishlist'); //add to card not work

    Route::get('account-tickets', [UserProfileController::class, 'account_tickets'])->name('account-tickets');
    Route::post('ticket-submit', [UserProfileController::class, 'ticket_submit'])->name('ticket-submit');

    // Chatting start
    Route::get('chat-with-seller', [ChattingController::class, 'chat_with_seller'])->name('chat-with-seller');
    Route::get('messages', [ChattingController::class, 'messages'])->name('messages');
    Route::post('messages-store', [ChattingController::class, 'messages_store'])->name('messages_store');
    // chatting end
    //Support Ticket
    Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
        Route::get('{id}', [UserProfileController::class, 'single_ticket'])->name('index');
        Route::post('{id}', [UserProfileController::class, 'comment_submit'])->name('comment');
        Route::get('delete/{id}', [UserProfileController::class, 'support_ticket_delete'])->name('delete');
        Route::get('close/{id}', [UserProfileController::class, 'support_ticket_close'])->name('close');
    });

    Route::get('account-transaction', [UserProfileController::class, 'account_transaction'])->name('account-transaction');
    Route::get('account-wallet-history', [UserProfileController::class, 'account_wallet_history'])->name('account-wallet-history');

    Route::post('review', [ReviewController::class, 'store'])->name('review.store');

    Route::group(['prefix' => 'track-order', 'as' => 'track-order.'], function () {
        Route::get('', [UserProfileController::class, 'track_order'])->name('index');
        Route::get('result-view', [UserProfileController::class, 'track_order_result'])->name('result-view');
        Route::get('last', [UserProfileController::class, 'track_last_order'])->name('last');
        Route::post('result', [UserProfileController::class, 'track_order_result'])->name('result');
    });
    //FAQ route
    Route::get('helpTopic', [WebController::class, 'helpTopic'])->name('helpTopic');
    //Contacts
    Route::get('contacts', [WebController::class, 'contacts'])->name('contacts');

    //sellerShop
    Route::get('shopView/{id}', [WebController::class, 'seller_shop'])->name('shopView');

    //top Rated
    Route::get('top-rated', [WebController::class, 'top_rated'])->name('topRated');
    Route::get('best-sell', [WebController::class, 'best_sell'])->name('bestSell');
    Route::get('new-product', [WebController::class, 'new_product'])->name('newProduct');

    //for test
    Route::get('order', [WebController::class, 'testOrder'])->name('order'); //done
    Route::get('orderList', [WebController::class, 'testOrderList'])->name('orderList'); //done/todo
    Route::get('profile', [WebController::class, 'testProfile'])->name('profile'); //done
    Route::get('supportTicket', [WebController::class, 'testSupport'])->name('support-ticket'); //done
    Route::get('wishList', [WebController::class, 'testWish'])->name('wishList'); //done/todo
    Route::get('chatTest', [WebController::class, 'testChat'])->name('chatTest'); // done
    Route::get('addressTest', [WebController::class, 'testAddress'])->name('address'); // done (header Problem)
    Route::get('addressView', [WebController::class, 'testAddressView'])->name('addressView'); //done
    Route::get('purchase', [WebController::class, 'testpurchase'])->name('purchase'); //done
    Route::get('supportChat', [WebController::class, 'supportChat'])->name('supportChat'); //done
    Route::get('orderDetails', [WebController::class, 'orderdetails'])->name('orderdetails'); //done/todo
    Route::get('error', [WebController::class, 'error']);
});

//Seller shop apply
Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Seller\Auth'], function () {
    Route::get('apply', [RegisterController::class, 'create'])->name('apply');
    Route::post('apply', [RegisterController::class, 'store']);
});


Route::post('address-validation', [WebController::class, 'address_validation'])->name('address.validation'); // Address Validation



Route::any('test', [WebController::class, 'importCsv'])->name('test'); //done


Route::any('checkout/set-checkout-address', function () {
    $address = [
        'address' => request()->input('address'),
        'city' => request()->input('city'),
        'state' => request()->input('state'),
        'postal' => request()->input('postal'),
        'country' => request()->input('country'),
    ];
    try {
        if(validate_address($address)){
            session([
                'user_address' => request()->input('address'),
                'user_city' => request()->input('city'),
                'user_state' => strtoupper(request()->input('state')),
                'user_postal' => request()->input('postal'),
                'user_country' => request()->input('country'),
            ]);
            return redirect()->back()->with("success", "Delivery Address set successfully");
        } else {
            return redirect()->back()->with("error", "Invalid address provided");
        }
    } catch (\Throwable $th) {
        return redirect()->back()->with("error", "Invalid address provided ".$th->getMessage());
    }
})->name('set.checkout.session'); //done



//check done

Route::group(['prefix' => 'cart', 'as' => 'cart.', 'namespace' => 'Web'], function () {
    Route::post('variant_price', [CartController::class, 'variant_price'])->name('variant_price');
    Route::post('add', [CartController::class, 'addToCart'])->name('add');
    Route::post('remove', [CartController::class, 'removeFromCart'])->name('remove');
    Route::post('nav-cart-items', [CartController::class, 'updateNavCart'])->name('nav_cart');
    Route::post('toolbar', [CartController::class, 'updateToolbar'])->name('toolbar');
    Route::post('updateQuantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
    Route::post('weUpdate', [CartController::class, 'weUpdate'])->name('weUpdate');
});

//Seller shop apply
Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'namespace' => 'Web'], function () {
    Route::post('apply', [CouponController::class, 'apply'])->name('apply');
});
//check done



#------------// stripeCheckout for plans //------------------
Route::any('plans.paypal.checkout', [UserController::class, 'paypalCheckout'])->name('plans.paypal.checkout');
Route::any('process-paypal-checkout', [PaypalPaymentController::class, 'process_paypal'])->name('process.paypal.checkout');
Route::any('plans.stripe.checkout', [SubscriptionController::class, 'stripeCheckout'])->name('plans.stripe.checkout');
#------------// stripeCheckout for plans //------------------


Route::any('updateShippingPrice', [SystemController::class, 'updateShippingPrice'])->name('updateShippingPrice');
Route::any('promote-checkout', [WebController::class, 'stripeCheckout'])->name('promote.checkout');
Route::any('payment-fail', [WebController::class, 'paymentFail'])->name('payment-fail');




/*paypal*/
/*Route::get('/paypal', function (){return view('paypal-test');})->name('paypal');*/
Route::post('pay-paypal', [PaypalPaymentController::class, 'payWithpaypal'])->name('pay-paypal');
Route::post('pay-paypal-app', [PaypalPaymentController::class, 'payWithpaypalApp'])->name('pay-paypal-app');

Route::get('paypal-status', [PaypalPaymentController::class, 'getPaymentStatus'])->name('paypal-status');
Route::get('paypal-success', [PaypalPaymentController::class, 'success'])->name('paypal-success');
Route::get('paypal-fail', [PaypalPaymentController::class, 'fail'])->name('paypal-fail');
/*paypal*/

/*Route::get('stripe', function (){
return view('stripe-test');
});*/
Route::post('pay-stripe', [StripePaymentController::class, 'paymentProcess'])->name('pay-stripe');
Route::get('pay-stripe/success', [StripePaymentController::class, 'success'])->name('pay-stripe.success');
Route::get('pay-stripe/fail', [StripePaymentController::class, 'success'])->name('pay-stripe.fail');



#--------------------------------
# social login
#--------------------------------
// Google
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('social.google');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
// facebook
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect'])->name('social.facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);
// Twitter
Route::get('auth/twitter', [SocialController::class, 'loginwithTwitter'])->name('social.twitter');
Route::get('auth/twitter/callback', [SocialController::class, 'handleTwitterCallback']);
// GitHub
Route::get('auth/github', [SocialController::class, 'loginwithTwitter'])->name('social.github');
Route::get('auth/github/callback', [SocialController::class, 'handleTwitterCallback']);


Route::get('getevent', [CalenderController::class, 'calendarEvents'])->name('get_events');
Route::post('createevent',[CalenderController::class, 'calendarEvents'])->name('create_event');
Route::post('deleteevent', [CalenderController::class, 'calendarEvents'])->name('delete_event');


Route::post('/customer/auth/email/resend', '\App\Http\Controllers\Customer\Auth\LoginController@resend')->name('verification.resend');

Route::get('account/verify/{token}', '\App\Http\Controllers\Customer\Auth\LoginController@verifyAccount')->name('user.verify'); 


Route::get('woju_command', function(){
    Artisan::call('schedule:run');
    echo app()['Illuminate\Contracts\Console\Kernel']->output();
});
