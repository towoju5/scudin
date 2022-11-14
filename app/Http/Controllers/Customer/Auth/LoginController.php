<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Wishlist;
use App\User;
use App\Model\UserVerify;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController extends Controller
{
  public $company_name;

  public function __construct()
  {
    $this->middleware('guest:customer', ['except' => ['logout', 'show', 'resend']]);
  }

  public function login()
  {
    session()->put('keep_return_url', url()->previous());
    return view('customer-view.auth.login');
  }

  public function submit(Request $request)
  {
    // session_destroy();
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:6'
    ], [
      'email.required'    =>  'Email field is required',
      'email.email'       =>  'Email must be a valid email address',
      'password.required' =>  'Password field is required',
      'password.min'      =>  'Password field can not be less than 6 characters',
    ]);

    // if ($validator->fails()) {
    //   return response()->json(['errors' => Helpers::error_processor($validator)]);
    // }

    $this->company_name = BusinessSetting::where('type', 'company_name')->first();

    $remember = ($request['remember']) ? true : false;

    if (auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
      session()->put('_user', $this->getUser());
      session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
      if ($request->ajax() && !auth('customer')->user()->is_email_verified) {
        return response()->json(['message' => 'Please verify your Email to continue!', 'url' => route('customer.auth.verify.show')]);
      }
      if ($request->ajax()) {
        return response()->json(['message' => 'Signed in successfully!', 'url' => session('keep_return_url')]);
      }
      if (!auth('customer')->user()->is_email_verified) {
        $email = auth('customer')->user()->email;
        Toastr::error('You need to confirm your account. We have sent you an activation code, please check your email.');
        return redirect()->route('customer.auth.verify.show');
      }

      Toastr::info('Welcome to ' . $this->company_name->value . '!');
      return redirect(session('keep_return_url'));
    }

    if ($request->ajax()) {
      return response()->json(['message' => 'Credentials do not match.'], 401);
    }

    Toastr::error('Credentials do not match.');
    return back();
  }

  public function logout(Request $request)
  {
    auth()->guard('customer')->logout();
    Toastr::info('Come back soon, ' . '!');
    return redirect()->route('home');
  }

  function getUser()
  {
    return $user = User::where('id', auth('customer')->id())->first();
  }

  function show()
  {
    return view('customer.emailVerificationEmail');
  }

  function resend(Request $request)
  {
    $user = User::where('email', auth('customer')->user()->email)->first();
    $_token = UserVerify::where('user_id', $user->id)->first();
    // send welcome email to user
    $_msg = "Welcome to Scudin. \n\n
      Please click the link below to verify you account and get started.";

    $config = \App\Model\BusinessSetting::where(['type' => 'mail_config'])->first();
    $data = json_decode($config['value'], true);
    $mail = new PHPMailer(true);
    $userInfo = [
      'name'      => $user['l_name'] . ' ' . $user['f_name'],
      'message'   => $_msg,
      'email'     => $user->email,
      'config'    => $config,
      'user'      => [],
      'action_url' => url("account/verify/$_token->token"),
      'subject'   => "Welcome to Scudin"
    ];
    $template = \App\Model\BusinessSetting::where(['type' => 'user_registration'])->pluck('value')->first();

    if (str_contains($template, '!user')) {
      $template = str_replace('!user', "$user->l_name $user->f_name", $template);
    }

    send_user_mail($user->email, 'Email Verification', $template, route('user.verify', $_token->token));
    return back();
  }

  public function verifyAccount($token)
  {
    auth()->guard('customer')->logout();
    $verifyUser = UserVerify::where('token', $token)->first();
    $message = 'Sorry your email cannot be identified.';
    if (!is_null($verifyUser)) {
      $user = $verifyUser->user;

      if (!$user->is_email_verified) {
        $verifyUser->user->is_email_verified = 1;
        $verifyUser->user->email_verified_at = now();
        $verifyUser->user->save();
        auth()->login($user);
        return redirect()->to(url('/dashboard'))->with('success', "Your e-mail is verified. You can now login.");
        $message = "Your e-mail is verified. You can now login.";
      } else {
        $message = "Your e-mail is already verified. You can now login.";
      }
    }

    Toastr::success($message);
    return redirect()->route('login')->with('message', $message);
  }
}
