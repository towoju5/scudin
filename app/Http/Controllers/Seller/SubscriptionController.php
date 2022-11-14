<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\Subscription;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Omnipay\Omnipay;

class SubscriptionController extends Controller
{
    public function index()
    {
        $seller = Shop::where(['seller_id' => auth('seller')->id()])->first();
        
        if(empty($seller->tax_id) || empty($seller->address) || empty($seller->contact))
            return redirect()->route()->with(['error' => 'Please complete your account information']);
            
        $plans = Subscription::where('plan_user_type', 'seller')->get();
        return view('seller-views.system.subscription', compact(['plans']));
    }


    public function view()
    {
        $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
        if (isset($shop) == false) {
            DB::table('shops')->insert([
                'seller_id' => auth('seller')->id(),
                'name' => auth('seller')->user()->f_name,
                'address' => '',
                'contact' => auth('seller')->user()->phone,
                'image' => 'def.png',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
        }

        return view('seller-views.shop.shopInfo', compact('shop'));
    }

    public function edit($id)
    {
        $shop = Shop::where(['seller_id' =>  auth('seller')->id()])->first();
        return view('seller-views.shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->contact = $request->contact;
        if ($request->image) {
            $shop->image = ImageManager::update('shop/', $shop->image, 'png', $request->file('image'));
        }
        $shop->save();

        Toastr::info('Shop updated successfully!');
        return redirect()->route('seller.shop.view');
    }

    public function create()
    {
        //
    }

    public function activate($id)
    {
        $plan_id = $id;
        $plan = Subscription::findOrFail($id);
        $userType = $plan->plan_user_type;
        
        if (auth('seller')->check()) {
            $user = Seller::find(auth('seller')->id());
        } else if (auth('seller')->check()) {
            $user = User::find(auth('customer')->id());
        } else {
            return redirect()->back()->with('error', 'Invalid Plan selected!');
        }

        if ($plan->plan_price < 1) {
            // set user plan to free plan.
            $user->plan_id = $id;
            $user->save();
            return redirect()->back()->with('success', "Plan successfully set to free plan, Happy selling 😄");
        } else {
            // user needs to pay for the said plan.
            return view('paynow', compact(['plan', 'userType', 'user', 'plan_id']));
        }
    }

    public function stripeCheckout(Request $request)
    {    
        $request->validate([
            'tax_id' => 'required|min:5'
        ],[
            'tax_id.required' => 'Please provide a valid Tax ID'
        ]);
        
        Seller::where('id', auth('seller')->id())->update(['tax_id' => $request->tax_id]);
   
        if (request()->input('payment_type') == 'paypal') {
            $this->paypalCheckout();
        }
        
        $stripe = \App\CPU\Helpers::get_business_settings('stripe');
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($stripe['api_key']);
        $plan = Subscription::findOrFail($request->plan_id);

        // '4242424242424242'
        $getExpDate = explode('/', $request->cc_date);
        $expiryMonth = $getExpDate[0] ?? NULL;
        $expiryYear = $getExpDate[1] ?? NULL;
        $formData = array('number' => $request->cc_num, 'expiryMonth' => $expiryMonth, 'expiryYear' => $expiryYear, 'cvv' => $request->cc_cvv);
        $response = $gateway->purchase(array('amount' => $plan->plan_price, 'currency' => 'USD', 'card' => $formData))->send();

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            $userType = $plan->plan_user_type;
            if ($userType == 'user') {
                $user = User::find(auth('customer')->id());
                $_final = "vendor.subscription";
            } else {
                $user = Seller::find(auth('seller')->id());
                $_final = "vendor.subscription";
            }
            $user->plan_id = $plan->id;
            $user->save();
            // send invoice receipt to user
            
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
            seller_mail(auth('customer')->user()->email, ucwords($plan->plan_name)." Purchased Successfully", $template);
            
            Toastr::success('Plan updated successfully.');
            return redirect(route($_final));
            // print_r($response);
        } else {
            // payment failed: display message to customer
            // echo $response->getMessage();
            return redirect()->route('payment-fail');
        }
    }

    public function paypalCheckout()
    {
        $paypal = \App\CPU\Helpers::get_business_settings('paypal');
        $gateway = Omnipay::create('RestGateway');

        // Initialise the gateway
        $gateway->initialize(array(
            'clientId' => $paypal['paypal_client_id'],
            'secret' => $paypal['paypal_secret'],
            'testMode' => true,
        ));

        $plan = Subscription::findOrFail(request()->plan_id);

        // '4242424242424242'
        $getExpDate = explode('/', request()->cc_date);
        $expiryMonth = $getExpDate[0] ?? NULL;
        $expiryYear = $getExpDate[1] ?? NULL;
        $formData = array('number' => request()->cc_num, 'expiryMonth' => $expiryMonth, 'expiryYear' => $expiryYear, 'cvv' => request()->cc_cvv);
        $response = $gateway->purchase(array('amount' => $plan->plan_price, 'currency' => 'USD', 'card' => $formData))->send();

        var_dump($response); exit;

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            // $userType = $plan->plan_user_type;
            if (auth('customer')->check()) {
                return redirect('plans.list');
            } else if (auth('seller')->check()){
                $user = Seller::find(auth('seller')->id());
                $_final = "vendor.subscription";
            } else {
                return redirect('/');
            }
            $user->plan_id = $plan->id;
            $user->save();
            // send invoice receipt to user
            
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
            seller_mail(auth('customer')->user()->email, ucwords($plan->plan_name)." Purchased Successfully", $template);
            return redirect(route($_final));
            // print_r($response);
        } else {
            // payment failed: display message to customer
            // echo $response->getMessage();
            return redirect()->route('payment-fail');
        }
    }
}
