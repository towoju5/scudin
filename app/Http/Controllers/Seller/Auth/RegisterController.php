<?php

namespace App\Http\Controllers\Seller\Auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use App\Model\SellerVerify;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function create()
    {
        return view('seller-views.auth.register');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:sellers',
            // 'code' => 'required',
            'password'=>'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{9,150}$/'
        ],[
            'password.min' => "Password must be minimum of 9 Alpha Numeric characters",
            'password.alpha_num' => "Password must contain atleast 1 lowercase & 1 uppercase 1 number (0-9) 1 Special Character (!@#$%^&*)"
        ]);

        // if(session()->get('otp') != $request->code){
        //     Toastr::error('Please check your O.T.P');
        //     return back();
        // }

        //session()->remove('otp');
        $seller = DB::transaction(function ($r) use ($request) {
            $seller = new Seller();
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->image = save_image('seller', $request->file('image'));
            $seller->password = Hash::make($request->password);
            $seller->status = "pending";
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->shop_address;
            $shop->contact = $request->phone;
            $shop->image = save_image('seller', $request->file('logo'));
            $shop->save();
            return $seller;
        });
        
        $token = Str::random(64);
        SellerVerify::create([
            'user_id' => $seller->id,
            'token' => $token
        ]);
        
        // Login Seller/
        auth('seller')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        
        $template = \App\Model\BusinessSetting::where(['type' => 'seller_reg_email'])->pluck('value')->first();

        if (str_contains($template, '!user')) {
            $message = str_replace('!user', $request->shop_name, $template);
        }

        seller_mail($request->email, 'Email Verification', $message, route('seller.verify', $token));

        Toastr::success('Shop apply successfully!');
        return redirect()->route('seller.auth.show.seller.verify');

    }

    function verifySeller(Request $request)
    {
        $phone = $request->phone;
        $msg = "Please complete your registration using the following code: ".rand(1000, 9999);
        if (twilio($phone, $msg)) {
            return true;
        }
    }
}
