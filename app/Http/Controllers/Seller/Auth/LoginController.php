<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\SellerVerify;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest:seller', ['except' => ['logout']]);
    }

    public function login()
    {
        return view('seller-views.auth.login');
    }

    function show()
    {
      if(!auth('seller')->check()){
        Toastr::error("Please login to continue"); 
        return back();
      }
      return view('customer.emailVerificationEmail');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ],[
            'email.required'    =>  'Email field is required',
            'email.email'       =>  'Email must be a valid email address',
            'password.required' =>  'Password field is required',
            'password.min'      =>  'Password field can not be less than 5 characters',
        ]);

        $se = Seller::where(['email' => $request['email']])->first(['status']);

        if (isset($se) && $se['status'] == 'approved' && auth('seller')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            Toastr::info('Welcome to your shop dashboard!');
             return redirect()->intended('seller/dashboard');
        } elseif (isset($se) && $se['status'] == 'pending') {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Your Shop is not approved yet.']);
        } elseif (isset($se) && $se['status'] == 'suspended') {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Your Shop has been suspended!.']);
        }

        return redirect()->back()->withErrors(['Invalid Credentials.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('seller')->logout();

        $request->session()->invalidate();

        return redirect()->route('seller.auth.login');
    }

    public function send_otp(Request $request)
    {
        validator($request->all(), [
            'email' => 'required'
        ]);

        $otp = session()->get('otp') ?? rand(1000, 9999); session()->put('otp', $otp);
        try {
            seller_mail($request->email, 'Registration O.T.P', "Your Registration code is: $otp");
        } catch (\Throwable $e) {
            return response()->json([
                'error' =>  "unable to send O.T.P",
                'data'  =>  $e->getMessage()
            ]);
        } 
    }

    function resend(Request $request)
    {
      $user = Seller::where('email', auth('seller')->user()->email)->first();
      $_token = SellerVerify::where('user_id', $user->id)->first();
      if(empty($_token)){
          Toastr::error("Unkown Seller"); 
          return back(); 
      }
      $template = \App\Model\BusinessSetting::where(['type' => 'seller_reg_email'])->pluck('value')->first();
      
      if (str_contains($template, '!user')) {
          $message = str_replace('!user', "$user->l_name $user->f_name", $template);
      }
  
      seller_mail($user->email, 'Email Verification Mail', $message, route('seller.verify', $_token->token));
      return back();    
    }
  
    public function verifyAccount($token)
    {
      $verifyUser = SellerVerify::where('token', $token)->first();
  
      $message = 'Sorry your email cannot be identified.';
  
      if (!is_null($verifyUser)) {
        $user = $verifyUser->user;
  
        if (!$user->is_email_verified) {
          $verifyUser->user->is_email_verified = 1;
          $verifyUser->user->save();
          $message = "Your e-mail is verified. You can now login.";
        } else {
          $message = "Your e-mail is already verified. You can now login.";
        }
      }
        
      Toastr::success($message);  
      return redirect()->to(url('seller/shop/subscription'))->with('message', $message);
    }
}
