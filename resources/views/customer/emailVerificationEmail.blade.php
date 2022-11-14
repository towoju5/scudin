@extends('layouts.app')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/page-auth.min.css">
<!-- END: Page CSS-->
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- verify email basic -->
    <div class="card mb-0">
      <div class="card-body">
        <?php 
        if(auth('seller')->check()){
          $login  = "seller.auth.login";
          $logout = "seller.auth.logout";
          $form   = "seller.resend";
          $email  = auth('seller')->user()->email;
        } else {
          $login  = "customer.auth.login";
          $logout = "customer.auth.logout";
          $form   = "verification.resend";
          $email  = auth('customer')->user()->email;
        } ?>
        @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
        <a href="{{ url('/') }}" class="brand-logo">
          <img src="{{ website_logo() }}" height="50px" alt="">
        </a>

        <h2 class="card-title fw-bolder mb-1">Verify your email ✉️</h2>
        <p class="card-text mb-2">
          We've sent a link to your email address: <span class="fw-bolder"><strong>{{ $email }}</strong></span> Please follow the
          link inside to continue.
        </p>


        <p class="text-center mt-2">
        <form action="{{ route($form) }}" method="POST" class="d-inline">
          @csrf
            <button type="submit" class="btn btn-scudin w-100 waves-effect waves-float waves-light">
              <span>&nbsp;Resend</span>
            </button></a>
        </form>
        <a href="{{ route($logout) }}" class="d-inline btn btn-link p-0 text-right">Verified Already/Logout</a>
        <!-- <span>Didn't receive an email? </span><a href="Javascript:void(0)"><span>&nbsp;Resend</span></a> -->
        </p>
      </div>
    </div>
    <!-- / verify email basic -->
  </div>
</div>
@endsection
