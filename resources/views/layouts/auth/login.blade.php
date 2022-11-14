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
                <a href="{{ url('/') }}" class="brand-logo">
                    <img src="{{ website_logo() }}" alt="">
                </a>

                <h4 class="card-title mb-1 text-center">Please Sign-In to Get Started 👋</h4>
                <!-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> -->

                <form class="auth-login-form mt-2" action="{{ route($login) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="login-password">Password</label>
                            <a href="{{ route($register) }}">
                                <small>Forgot Password?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control form-control-merge" id="login-password" name="password"  tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="remember" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} tabindex="3" />
                            <label class="custom-control-label" for="remember-me"> Remember Me </label>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" tabindex="4">Sign in</button>
                </form>

                <p class="text-center mt-2">
                    <span>New on our platform?</span>
                    <a href="{{ route($register) }}">
                        <span>Create an account</span>
                    </a>
                </p>

                <div class="divider my-2">
                    <div class="divider-text">or</div>
                </div>

                <div class="auth-footer-btn d-flex justify-content-center">
                    <a href="javascript:void(0)" class="btn btn-facebook">
                        <i data-feather="facebook"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-twitter white">
                        <i data-feather="twitter"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-google">
                        <i data-feather="mail"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-github">
                        <i data-feather="github"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Login v1 -->
    </div>
</div>
@endsection