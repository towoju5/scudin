@extends('layouts.app')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/page-auth.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
<!-- END: Page CSS-->
@endsection

@section('content')
<form action="{{route('shop.apply')}}" method="post" enctype="multipart/form-data" hidden>
    @csrf
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <div id="step-1">
                <div class="card mb-0">
                    <div class="card-body">
                        @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                        <a href="{{ url('/') }}" class="brand-logo">
                            <img src="{{ website_logo() }}" height="50px" alt="">
                        </a>
                        <h5 class="black">{{__('Seller')}} {{__('Info')}} </h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-fn">{{ __('first_name')}}</label>
                                    <input class="form-control" type="text" name="f_name" required>
                                    <div class="invalid-feedback">Please enter your first name!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{ __('last_name')}}</label>
                                    <input class="form-control" type="text" name="l_name">
                                    <div class="invalid-feedback">Please enter your last name!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-email">{{ __('email_address')}}</label>
                                    <input class="form-control" type="email" name="email">
                                    <div class="invalid-feedback">Please enter valid email address!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-phone">{{ __('phone_name')}}</label>
                                    <input class="form-control" type="text" name="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="si-password">{{ __('password')}}</label>
                                    <div class="password-toggle">
                                        <input class="form-control" name="password" type="password" id="si-password" required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                        <label for="reg-password">{{ __('password')}}</label>
                                <input class="form-control" type="password" name="password">
                                <div class="invalid-feedback">Please enter password!</div>
                            </div> --}}
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="si-password">{{ __('confirm_password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" name="con_password" type="password" id="con-password" required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                        <label for="reg-password-confirm">{{ __('confirm_password')}}</label>
                            <input class="form-control" type="password" name="con_password">
                            <div class="invalid-feedback">Passwords do not match!</div>
                        </div> --}}
                    </div>
                </div>
                <div class="form-group d-flex flex-wrap justify-content-between">

                    <div class="form-group mb-1">
                        <strong>
                            <input type="checkbox" class="mr-1" name="remember" id="inputCheckd">
                        </strong>
                        <label class="" for="remember">{{ __('i_agree_to_Your_terms')}}<a class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                {{ __('terms_and_condition')}}
                            </a></label>
                    </div>

                </div>
                <div class="row">
                    <button class="btn btn-primary btn-block text-uppercase" type="button" id="sign_in"> {{ __('next')}} </button>
                </div>
            </div>
            <div id="step-2">
                <div class="card mb-0">
                    <div class="card-body">
                        @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                        <a href="{{ url('/') }}" class="brand-logo">
                            <img src="{{ website_logo() }}" height="50px" alt="">
                        </a>
                        <h5 class="black">{{__('Seller')}} {{__('Info')}} </h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-fn">{{ __('first_name')}}</label>
                                    <input class="form-control" type="text" name="f_name" required>
                                    <div class="invalid-feedback">Please enter your first name!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{ __('last_name')}}</label>
                                    <input class="form-control" type="text" name="l_name">
                                    <div class="invalid-feedback">Please enter your last name!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-email">{{ __('email_address')}}</label>
                                    <input class="form-control" type="email" name="email">
                                    <div class="invalid-feedback">Please enter valid email address!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-phone">{{ __('phone_name')}}</label>
                                    <input class="form-control" type="text" name="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="si-password">{{ __('password')}}</label>
                                    <div class="password-toggle">
                                        <input class="form-control" name="password" type="password" id="si-password" required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                        <label for="reg-password">{{ __('password')}}</label>
                                <input class="form-control" type="password" name="password">
                                <div class="invalid-feedback">Please enter password!</div>
                            </div> --}}
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="si-password">{{ __('confirm_password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" name="con_password" type="password" id="con-password" required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                        <label for="reg-password-confirm">{{ __('confirm_password')}}</label>
                            <input class="form-control" type="password" name="con_password">
                            <div class="invalid-feedback">Passwords do not match!</div>
                        </div> --}}
                    </div>
                </div>
                <div class="form-group d-flex flex-wrap justify-content-between">

                    <div class="form-group mb-1">
                        <strong>
                            <input type="checkbox" class="mr-1" name="remember" id="inputCheckd">
                        </strong>
                        <label class="" for="remember">{{ __('i_agree_to_Your_terms')}}<a class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                {{ __('terms_and_condition')}}
                            </a></label>
                    </div>

                </div>
                <div class="row">
                    <button class="btn btn-primary btn-block text-uppercase" type="button" id="sign_in"> {{ __('next')}} </button>
                </div>
            </div>
        </div>
    </div>
</form>
<p class="text-center mt-2">
    <span>Already have an account?</span>
    <a href="{{ route('seller.auth.login') }}">
        <span>Log In</span>
    </a>
</p>

<script>
    $('#sign_in').click(function() {
        $("#step-2").show();
        $("#step-1").hide();
    });
    $('#_step2').click(function() {
        $("#step-1").show();
        $("#step-2").hide();
    });


    $('#sign-up-form').submit(function(e) {
        e.preventDefault();
        $.post({
            url: "{{route('customer.auth.register')}}",
            dataType: 'json',
            data: $('#sign-up-form').serialize(),
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(data) {
                $("#loading").hide();
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setInterval(function() {
                        location.href = data.url;
                    }, 2000);
                }
            },
            complete: function() {
                $('#loading').hide();
            },
            error: function() {
                toastr.error('password does not match!', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
        $("#loading").hide();
    });
</script>
@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/js/scripts/forms/form-wizard.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
@endsection