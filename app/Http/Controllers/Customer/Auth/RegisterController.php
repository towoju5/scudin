<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\UserVerify;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function register()
    {
        session()->put('keep_return_url', url()->previous());
        return view('customer-view.auth.register');
    }

    public function submit(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'min:6|required_with:con_password|same:con_password',
            //'con_password' => 'min:6'
        ], [
            'email.email'        => 'Please provide a valid email address.',
            'email.required'     => 'The Email field is required.',
            'email.unique'       => 'This Email already exists.',
            'phone.required'     => 'The Phone Number field is required.',
            'phone.unique'       => 'This Phone Number already exists.',
            'password.min'       =>  "Password can not be less than 6 characters",
            //'con_password.min'   =>  "Password can not be less than 6 characters",
            'password.required'  => 'The Password field is required.',
            'password.same'      => 'The Password and Confirm Password field must be the same.',
            'password.required_with' => 'The Confirm Password field is required.',
        ]);
        
        //if ($validator->fails()) {
          //  return back()->withErrors($validator);
            //return back()->with(['reg_errors' => Helpers::error_processor($validator)]);
        //}
        

        if ($request['password'] != $request['con_password']) {
            return back()->with(['errors' =>  'password does not match.']);
        }

        if (session()->has('keep_return_url') == false) {
            session()->put('keep_return_url', url()->previous());
        }
        
        if($request->honey && !empty($request->honey)){
            return redirect()->to("https://google.com");
        }

        $data = new User;
        $data->f_name   = $request['f_name'];
        $data->name     = "$request->f_name $request->l_name ";
        $data->l_name   = $request['l_name'];
        $data->email    = $request['email'];
        $data->phone    = $request['phone'];
        $data->password = bcrypt($request['password']);

        $createUser = $data->save();
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $data->id,
            'token' => $token
        ]);

        $message = \App\Model\BusinessSetting::where(['type' => 'user_registration'])->pluck('value')->first();

        if (str_contains($message, '!user')) {
            $message = str_replace('!user', "$request->l_name $request->f_name", $message);
        }

        send_mail($request->email, 'Email Verification', $message, route('user.verify', $token));


        if (auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // $this->hubspot();
            Toastr::success('Sign up process done successfully!');
            return redirect()->route('dashboard');

            return response()->json(['message' => 'Sign up process done successfully!', 'url' => session('keep_return_url')]);
        }
    }

    private function hubspot()
    {
        // add user to hustpost
        $hubspot = \SevenShores\Hubspot\Factory::create(env("HUBSPOT_API_KEY"));
        $contact = $hubspot->contacts()->create([
            'firstname' => request()->f_name,
            'lastname' => request()->l_name,
            'email' => request()->email,
            'phone' => request()->phone,
            'user_type' => "Customer"
        ]);
        $contact->properties->email->value;
        return true;
    }
}

