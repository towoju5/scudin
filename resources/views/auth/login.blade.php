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
                <?php if(!isset($login) || empty($login)){
                    $login = "customer.auth.login";
                } ?>
                @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                <a href="{{ url('/') }}" class="brand-logo">
                    <img src="{{ website_logo() }}" height="50px" alt="">
                </a>

                <h4 class="card-title mb-1 text-center">Please Sign-In to Get Started 👋</h4>
                <!-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> -->
               <div class="center">
                  @if(count($errors) > 0 )
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     <ul class="p-1" style="list-style: none;">
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                     </ul>
                  </div>
                  @endif
                  <!-- </div> -->
               </div>
                <form class="auth-login-form mt-2" action="{{ route($login) }}" method="POST">
                    @csrf
                    @honeypot
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email</label>
                        <input class="form-control" type="hidden" name="honey">
                        <input type="text" required class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="login-password">Password</label>
                            @if(!empty($reset))
                            <a href="{{ route($reset) }}">
                                <small>Forgot Password?</small>
                            </a>
                            @endif
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" required class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">                            
                            <input class="custom-control-input" type="checkbox" id="remember" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} tabindex="3" />
                             <label class="custom-control-label" for="remember">Remember Me </label>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit" tabindex="4">Sign in</button>
                </form>

                @if(!empty($register))
                <p class="text-center mt-2">
                    <span>New on our platform?</span>
                    <a href="{{ route($register) }}">
                        <span>Create an account</span>
                    </a>
                </p>

                @if($social > 0)
                <div class="divider my-2">
                    <div class="divider-text">or</div>
                </div>

                <div class="auth-footer-btn d-flex justify-content-center">
                    @if(!empty(getenv('FB_CLIENT_ID')))
                    <a href="{{ route('social.facebook') }}" class="btn btn-facebook">
                        <i data-feather="facebook"></i>
                    </a>
                    @endif
                    @if(!empty(getenv('TWITTER_CLIENT_ID')))
                    <a href="{{ route('social.twitter') }}" class="btn btn-twitter white">
                        <i data-feather="twitter"></i>
                    </a>
                    @endif
                    @if(!empty(getenv('GOOGLE_CLIENT_ID')))
                    <a href="{{ route('social.google') }}" class="btn btn-google">
                        <i data-feather="mail"></i>
                    </a>
                    @endif
                    @if(!empty(getenv('GITHUB_CLIENT_ID')))
                    <a href="{{ route('social.github') }}" class="btn btn-github">
                        <i data-feather="github"></i>
                    </a>
                    @endif
                </div>
                @endif

                @else
                <br>
                @endif
            </div>
        </div>
        <!-- /Login v1 -->
    </div>
</div>
@endsection