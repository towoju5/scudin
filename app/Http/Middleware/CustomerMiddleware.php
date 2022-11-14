<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('customer')->check()) {
          if (!auth('customer')->user()->is_email_verified) {
            $email = auth('customer')->user()->email;
            return redirect()
                        ->route('customer.auth.verify.show')
                        ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
          }
   
        return $next($request);
            return $next($request);
        }
        Toastr::error('Unauthenticated, login first!');
        return redirect(route('customer.auth.login'));
    }
}
