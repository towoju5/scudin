<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
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
        if (Auth::guard('seller')->check()) {
            if (!auth('seller')->user()->is_email_verified) {
                $email = auth('seller')->user()->email;
                //auth()->logout();
                return redirect()
                    ->route('seller.auth.show.seller.verify')
                    ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            }
            return $next($request);
        }
        return redirect()->route('seller.auth.login');
    }
}

