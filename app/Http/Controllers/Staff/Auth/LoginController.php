<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Staff;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:seller', ['except' => ['logout']]);
    }

    public function login()
    {
        return view('staff-views.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $se = Staff::where(['email' => $request['email']])->first(['status']);

        if (isset($se) && $se['status'] == 'approved' && auth('staff')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            Toastr::info('Welcome to your shop dashboard!');
            return redirect()->route('staff.dashboard');
        }elseif (isset($se) && $se['status'] == 'pending'){
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Your Shop is not approved yet.']);
        }elseif (isset($se) && $se['status'] == 'suspended'){
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Your Shop has been suspended!.']);
        }

        return redirect()->back()->withErrors(['Invalid Credentials.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('staff')->logout();

        $request->session()->invalidate();

        return redirect()->route('staff.auth.login');
    }
}
