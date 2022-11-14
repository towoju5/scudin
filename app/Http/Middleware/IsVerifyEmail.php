<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('customer')->user()->is_email_verified) {
            $email = auth('customer')->user()->email;
            auth()->logout();
            return redirect()
                        ->route('customer.auth.verify.show')
                        ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
          }
   
        return $next($request);
    }
}