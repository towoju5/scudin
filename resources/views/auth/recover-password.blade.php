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
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
        <a href="{{ url('/') }}" class="brand-logo">
          <img src="{{ website_logo() }}" height="50px" alt="">
        </a>

        <h4 class="card-title mb-1 text-center">Forgot your password? 👋</h4>
        <!-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> -->
               <div class="center">
                  @if(count($errors) > 0 )
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     <ul class="p-0 m-0" style="list-style: none;">
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                     </ul>
                  </div>
                  @endif
                  <!-- </div> -->
               </div>
        <div class="col-lg-12">
          <p class="card-text mb-2">Change your password in three easy steps. This helps to keep your new password secure.</p>
          <ol class="list-unstyled font-size-md">
            <li><span class="text-primary mr-2"><i class="fa fa-asterisk" aria-hidden="true"></i>.</span>Fill in your email address below.</li>
          </ol>
        </div>
        <form class="auth-login-form mt-2 pb-2" action="{{ route($link) }}" method="POST">
          @csrf
          @honeypot
          <div class="form-group">
            <label for="login-email" class="form-label">Email</label>
            <input class="form-control" type="email" name="email" id="recover-email" required="" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <button class="btn btn-primary btn-block" tabindex="4">Reset Password...</button>
        </form>
      </div>
    </div>
    <!-- /Login v1 -->
  </div>
</div>
@endsection