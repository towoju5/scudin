<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Product;
use App\Model\Seller;
use App\Models\Payment;
use App\Subscription;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandBoxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Support\Facades\DB;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PaypalPaymentController extends Controller
{
    //
    public static function environment()
    {
        $paypal_conf = $config = Helpers::get_business_settings('paypal');
        $clientId = $paypal_conf['paypal_client_id'];
        $clientSecret = $paypal_conf['paypal_secret'];
        //return new SandBoxEnvironment($clientId, $clientSecret);
        return new ProductionEnvironment($clientId, $clientSecret);
    }

    public function payWithpaypal(Request $request)
    {
        $collection = request()->session()->get('cart', collect([]));
        foreach ($collection as $key => $value) {
            $collection = getFinalPrice($collection, $key);
        }
        request()->session()->put('cart', $collection);

        $cart = session('cart');
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $customer_info = session()->get('customer_info');
        $payment_id = session()->get('paypal_payment_id');

        $data = [];
        $data['purchase_units'] = [
            [
                'name' => 'Products',
                'invoice_id' => $payment_id,
                'desc'  => 'Payment for Goods purchase on ' . website_title(),
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => round(CartManager::cart_grand_total($cart) - $coupon_discount, 2)
                ]
            ]
        ];
        $data['intent'] = 'CAPTURE';
        $data['application_context'] = [
            'return_url' => route('paypal-status'),
            'cancel_url' => route('home')
        ];

        // return 
        // $payer = new Pay

        $paypal = new PayPalHttpClient(self::environment());
        $OrderRequest = new OrdersCreateRequest();
        $OrderRequest->prefer('return=representation');
        $OrderRequest->body = $data;
        $response = response()->json($paypal->execute($OrderRequest));
        $content = $response->getOriginalContent();

        if ($content->result->status === 'CREATED') {
            // return $content->result->links;
            return redirect()->to($content->result->links[1]->href);
        }
        return $response;
    }

    function getPaymentStatus(Request $request)
    {
        // return "Here I Am";
        $mm_content = '';
        $cart = session('cart');
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $customer_info = session()->get('customer_info');
        $payment_id = session()->get('paypal_payment_id');

        $paypal = new PayPalHttpClient(self::environment());
        $orderID = $request->token; //$request->input('orderId');
        $request = new OrdersCaptureRequest($orderID);
        $response = response()->json($paypal->execute($request));

        $content = $response->getOriginalContent();
        if ($content->result->status === 'COMPLETED') {
            DB::table('orders')->where(['id' => session('order_id')])->update([
                'payment_status' => 'paid',
                'order_status' => 'confirmed',
                'payment_method' => 'paypal',
                'transaction_ref' => $payment_id,
                'updated_at' => now()
            ]);
            $order_id = 100000 + Order::all()->count() + 1;
            $mm_total = CartManager::cart_grand_total($cart) - $coupon_discount;
            DB::table('orders')
                ->insertGetId([
                    'id' => $order_id,
                    'customer_id' => auth('customer')->id(),
                    'customer_type' => 'customer',
                    'payment_status' => 'paid',
                    'order_amount' => CartManager::cart_grand_total($cart) - $coupon_discount,
                    'order_status' => 'confirmed',
                    'payment_method' => 'paypal',
                    'discount_amount' => session()->has('coupon_discount') ? session('coupon_discount') : 0,
                    'discount_type' => session()->has('coupon_discount') ? 'coupon_discount' : '',
                    'shipping_address' => $customer_info['address_id'],
                    'transaction_ref' => $payment_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            foreach ($cart as $c) {
                $product = Product::where('id', $c['id'])->first();
                $or_d = [
                    'order_id' => $order_id,
                    'product_id' => $c['id'],
                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => $c['tax'] * $c['quantity'],
                    'discount' => $c['discount'] * $c['quantity'],
                    'discount_type' => 'discount_on_product',
                    'variant' => $c['variant'],
                    'variation' => json_encode($c['variations']),
                    'delivery_status' => 'pending',
                    'shipping_method_id' => $c['shipping_method_id'],
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $mm_content .= "<tr>
                                    <td>". $product->name ."</td>
                                    <td>". $c['price'] ."</td>
                                </tr>";
                DB::table('order_details')->insert($or_d);
            }
             // send invoice to user
             $template = \App\Model\BusinessSetting::where(['type' => 'general_invoice'])->pluck('value')->first();                
             if (str_contains($template, '!invoice_ID')) {
                 $template = str_replace('!invoice_ID', $order_id."($payment_id)" , $template);
             }
             if (str_contains($template, '!created_at')) {
                 $template = str_replace('!created_at', now(), $template);
             }
             if (str_contains($template, '!due_date')) {
                 $template = str_replace('!due_date', now()->addMinutes(30), $template);
             }
             if (str_contains($template, '!item_info')) {
                 $template = str_replace('!item_info', $mm_content, $template);
             }
             if (str_contains($template, '!total_price')) {
                 $template = str_replace('!total_price', $mm_total, $template);
             }
             if (str_contains($template, '!receive_address')) {
                 $user = auth('customer')->user();
                 $receive_address = "$user->name <br> $user->phone";
                 $template = str_replace('!receive_address', $receive_address, $template);
             }
            send_user_mail(auth('customer')->user()->email, "Order Placed Successfully. #$order_id", $template, NULL, NULL, NULL, $template);

            session()->forget('cart');
            session()->forget('coupon_code');
            session()->forget('coupon_discount');
            session()->forget('payment_method');
            session()->forget('shipping_method_id');

            return view('web-views.checkout-complete', compact('order_id'));
        }
        return $response;
    }

    public function success()
    {
        if (session()->has('payment_mode') && \session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }
        if (auth('customer')->check()) {
            Toastr::success('Payment success.');
            return redirect('/account-oder');
        }
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    public function fail()
    {
        if (session()->has('payment_mode') && \session('payment_mode') == 'app') {
            return redirect()->route('payment-fail');
        }

        if (auth('customer')->check()) {
            Toastr::error('Payment failed.');
            return redirect('/account-oder');
        }
        return redirect()->route('payment-fail');
        return response()->json(['message' => 'Payment failed'], 403);
    }

    public static function UserPlanPayment($amount, $url)
    {
        $data = [];
        $data['purchase_units'] = [
            [
                'name' => 'Products',
                'invoice_id' => _getTransactionId(),
                'desc'  => 'Payment for Goods purchase on ' . website_title(),
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => round($amount, 2)
                ]
            ]
        ];
        $data['intent'] = 'CAPTURE';
        $data['application_context'] = [
            'return_url' => $url,
            'cancel_url' => route('paypal-fail')
        ];

        $paypal = new PayPalHttpClient(self::environment());
        $OrderRequest = new OrdersCreateRequest();
        $OrderRequest->prefer('return=representation');
        $OrderRequest->body = $data;
        $response = response()->json($paypal->execute($OrderRequest));
        return $content = $response->getOriginalContent();

        return $response;
    }

    public function process_paypal(Request $request)
    {

        $_final = route('plans.list');
        $paypal = new PayPalHttpClient(self::environment());
        $orderID = $request->token; //$request->input('orderId');
        $request = new OrdersCaptureRequest($orderID);
        $resp   = $paypal->execute($request);

        $response = response()->json($resp);

        $content = $response->getOriginalContent();
        if ($content->result->status === 'COMPLETED') {
            // payment was successful: update database
            $plan_id = session()->get('su_plan_id');
            session()->remove('su_plan_id');
            $plan = Subscription::findOrFail($plan_id);
            $userType = $plan->plan_user_type;

            if (auth('customer')->check()) {
                $user = User::find(auth('customer')->id());
            } elseif (auth('seller')->check()) {
                $user = Seller::find(auth('seller')->id());
            } else {
                return redirect()->to('/');
            }

            $user->plan_id = $plan->id;
            $user->save();
            $template = \App\Model\BusinessSetting::where(['type' => 'subscription_plan'])->pluck('value')->first();

            if (str_contains($template, '!user')) {
                $message = str_replace('!user', "$user->l_name $user->f_name", $template);
            }

            if (str_contains($template, '!plan')) {
                $message = str_replace('!plan',  $plan->plan_name, $template);
            }

            send_mail($user->email, 'Subscription Update', $message);
            
            $template = \App\Model\BusinessSetting::where(['type' => 'general_invoice'])->pluck('value')->first();      
            $mm_content = "";
            $mm_content .= "<tr>
                                <td>Plan Name</td>
                                <td>". $plan->plan_name ."</td>
                            </tr>";          
            if (str_contains($template, '!invoice_ID')) {
                $template = str_replace('!invoice_ID', _getTransactionId(), $template);
            }
            if (str_contains($template, '!item_info')) {
                $template = str_replace('!item_info', $mm_content, $template);
            }
            if (str_contains($template, '!total_price')) {
                $template = str_replace('!total_price', "USD $plan->plan_price", $template);
            }
            if (str_contains($template, '!receive_address')) {
                $user = auth('customer')->user();
                $receive_address = "$user->name <br> $user->phone";
                $template = str_replace('!receive_address', $receive_address, $template);
            }
            send_user_mail(auth('customer')->user()->email, ucwords($plan->plan_name)." Purchased Successfully", $template, NULL, NULL, NULL, $template);
            Toastr::success('Plan updated successfully.');
            return redirect($_final);
        }
    }
}
