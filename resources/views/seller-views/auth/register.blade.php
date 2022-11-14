@extends('layouts.app')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/page-auth.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- END: Page CSS-->
<style>
    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #04AA6D;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>
@endsection

@section('content')
@php($seller_registration=\App\Model\BusinessSetting::where('type','seller_registration')->first()->value)
@if($seller_registration != 0)
<form action="{{route('shop.apply')}}" method="post" id="shopApply" enctype="multipart/form-data">
    @csrf
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2" style="max-width: 700px;">

            <!-- Circles which indicates the steps of the form: -->
            <!-- <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div> -->

            <section class="card">
                <!-- Horizontal Wizard -->
                @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
                <a href="{{ url('/') }}" class="brand-logo mt-2">
                    <img src="{{ website_logo() }}" height="50px" alt="">
                </a>

                <div class="card-body">
                    <h5 class="black">Sign up to become a seller </h5>
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
                                <input class="form-control" type="email" name="email" id="email">
                                <div class="invalid-feedback">Please enter valid email address!</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="reg-phone">{{ __('phone_name')}}</label>
                                <input class="form-control" type="number" name="phone" required>
                                <div class="invalid-feedback">Please enter your phone number!</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">{{ __('password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" onkeydown="checkPass()" name="password" minlength="9" type="password" id="password" required>
                                    <div id="popover-password">
                                        <p>Password Strength: <span id="result"> </span></p>
                                        <div class="progress progress progress-bar-success">
                                            <div id="password-strength" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            </div>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="">
                                                <span class="low-upper-case">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>&nbsp; 1 lowercase &amp; 1 uppercase
                                            </li>
                                            <li class="">
                                                <span class="one-number">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span> &nbsp;1 number (0-9)
                                            </li>
                                            <li class="">
                                                <span class="one-special-char">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span> &nbsp;1 Special Character (!@#$%^&*).
                                            </li>
                                            <li class="">
                                                <span class="eight-character">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>&nbsp; Atleast 8 Character
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="si-password">{{ __('confirm_password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" minlength="9" onkeydown="checkPass()" name="con_password" type="password" id="confirm-password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->

                    <!-- <div class="card-body"> -->
                    <!-- <h5 class="black">Email Verification </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-ln">{{ __('code')}}</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" maxlength="4" name="code">
                                    <button id="sendOTP" onclick="$('#loading').show();" class="btn btn-outline-primary waves-effect" id="button-addon2" type="button">Send Code </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-ln">{{ __('code')}}</label>
                                <input class="form-control" type="number" maxlength="4" name="code">
                            </div>
                        </div>
                    </div> -->
                    <!-- </div> -->

                    <!-- <div class="card-body"> -->
                    <h5 class="black">{{__('Shop')}} {{__('Info')}}</h5>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0 ">
                            <input type="text" class="form-control form-control-user" id="shop_name" name="shop_name" placeholder="Shop Name" value="{{old('shop_name')}}" required>
                        </div>
                        <div class="col-sm-6">
                            <input name="shop_address" class="form-control" id="shop_address" rows="3" placeholder="shop address" value="{{old('shop_address')}}">
                        </div>
                    </div>
                    <hr>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <p for="customFileUpload">{{__('Upload')}} {{__('Shop Banner')}}</p>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileUpload">{{__('Upload')}} {{__('image')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="pb-1">
                                        <center>
                                            <img style="width: 100%;border: 1px solid; border-radius: 10px; max-height:150px;" id="viewer" src="{{asset('img2.jpg')}}" alt="banner image" />
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <pfor="LogoUpload">{{__('Upload')}} {{__('logo')}}</p>
                                            <div class="custom-file">
                                                <input type="file" name="logo" id="LogoUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="LogoUpload">{{__('Upload')}} {{__('logo')}}</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="pb-1">
                                        <center>
                                            <img style="width: 100%;border: 1px solid; border-radius: 10px; max-height:150px;" id="viewerLogo" src="{{asset('img2.jpg')}}" alt="banner image" />
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <strong>
                                <input type="checkbox" required class="mr-1" name="remember" id="inputCheckd">
                            </strong>
                            <label class="" for="remember">{{ __('i_agree_to_Your_terms')}}
                                <a class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                    {{ __('terms_and_condition')}}
                                </a>
                            </label>
                        </div>
                    </div>
                    <!-- </div> -->

                    <div style="overflow:auto;">
                        <button onclick="_submit();" class="btn btn-primary btn-prev" type="submit" id="nextBtn">
                            <span class="align-middle d-sm-inline-block d-none"> Submit </span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                        <!-- <div style="text-align: center; padding-bottom: 10px;">
                        <button class="btn btn-primary btn-prev" type="button" id="prevBtn" onclick="nextPrev(-1)">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-prev" type="button" id="nextBtn" onclick="nextPrev(1)">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div> -->
                    </div>
                </div>
            </section>

        </div>
    </div>
</form>
@else
<div class="container-fluid d-flex justify-content-center">
    <div class="mt-4">
        <div class="card" style="max-width: 700px;">
            <section class="card-body">
                <h2 class="text-center">Seller Registration is currently closed, please do check back later</h2>
                <img src="{{ asset('closed.png') }}" class="center" width="300px" alt="">
            </section>
        </div>
    </div>
</div>
@endif
<p class="text-center">
    <span>Already have an account?</span>
    <a href="{{ route('seller.auth.login') }}">
        <span>Log In</span>
    </a>
</p>

@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ url('/') }}/app-assets/js/scripts/forms/form-wizard.js"></script>

<script>
    $(document).ready(function() {
        $("#nextBtn").attr('disabled', true)
        $("form").attr('autocomplete', 'off');
        $("input").attr("role", "presentation");
        $("#password").keyup(function() {
            var password = $("#password").val();
            if (checkStrength(password) == false || $("#confirm-password").val() == '') {
                $("#nextBtn").attr("disabled", true);
            }
        });
        $("#confirm-password").blur(function() {
            if ($("#password").val() !== $("#confirm-password").val()) {
                $("#popover-cpassword").removeClass("hide");
                $("#nextBtn").attr("disabled", true);
            } else {
                $("#popover-cpassword").addClass("hide");
                var password = $("#password").val();
                if (checkStrength(password) !== false && $("#confirm-password").val() != '') {
                    $("#nextBtn").attr("disabled", false);
                }
            }
        });

        function checkStrength(password) {
            var strength = 0;

            //If password contains both lower and uppercase characters, increase strength value.
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                strength += 1;
                $(".low-upper-case").addClass("text-success");
                $(".low-upper-case i").removeClass("fa-times").addClass("fa-check");
                $("#popover-password-top").addClass("hide");
            } else {
                $(".low-upper-case").removeClass("text-success");
                $(".low-upper-case i").addClass("fa-times").removeClass("fa-check");
                $("#popover-password-top").removeClass("hide");
            }

            //If it has numbers and characters, increase strength value.
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
                strength += 1;
                $(".one-number").addClass("text-success");
                $(".one-number i").removeClass("fa-times").addClass("fa-check");
                $("#popover-password-top").addClass("hide");
            } else {
                $(".one-number").removeClass("text-success");
                $(".one-number i").addClass("fa-times").removeClass("fa-check");
                $("#popover-password-top").removeClass("hide");
            }

            //If it has one special character, increase strength value.
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                strength += 1;
                $(".one-special-char").addClass("text-success");
                $(".one-special-char i").removeClass("fa-times").addClass("fa-check");
                $("#popover-password-top").addClass("hide");
            } else {
                $(".one-special-char").removeClass("text-success");
                $(".one-special-char i").addClass("fa-times").removeClass("fa-check");
                $("#popover-password-top").removeClass("hide");
            }

            if (password.length > 7) {
                strength += 1;
                $("#nextBtn").attr('disabled', false)
                $(".eight-character").addClass("text-success");
                $(".eight-character i").removeClass("fa-times").addClass("fa-check");
                $("#popover-password-top").addClass("hide");
            } else {
                $("#nextBtn").attr('disabled', true)
                $(".eight-character").removeClass("text-success");
                $(".eight-character i").addClass("fa-times").removeClass("fa-check");
                $("#popover-password-top").removeClass("hide");
            }

            // If value is less than 2

            if (strength < 2) {
                $("#result").removeClass();
                $("#password-strength").addClass("progress-bar-danger");

                $("#result").addClass("text-danger").text("Very Week");
                $("#password-strength").css("width", "10%");
            } else if (strength == 2) {
                $("#result").addClass("good");
                $("#password-strength").removeClass("progress-bar-danger");
                $("#password-strength").addClass("progress-bar-warning");
                $("#result").addClass("text-warning").text("Week");
                $("#password-strength").css("width", "60%");
                return "Week";
            } else if (strength == 4) {
                $("#result").removeClass();
                $("#result").addClass("strong");
                $("#password-strength").removeClass("progress-bar-warning");
                $("#password-strength").addClass("progress-bar-success");
                $("#result").addClass("text-success").text("Strength");
                $("#password-strength").css("width", "100%");

                return "Strong";
            }
        }
    });

    function checkPass() {
        var password = $("#password").val();
        var conpassword = $("#confirm-password").val();
        if (checkStrength(password) != false && password.length > 8) {
            if (checkStrength(conpassword) != false && password.length > 8) {
                if (password === conpassword) {
                    $("#nextBtn").attr("disabled", false);
                }
            }
        }
    }

    function Validate(file) {
        var x;
        var le = file.length;
        var poin = file.lastIndexOf(".");
        var accu1 = file.substring(poin, le);
        var accu = accu1.toLowerCase();
        if ((accu != '.png') && (accu != '.jpg') && (accu != '.jpeg')) {
            x = 1;
            return x;
        } else {
            x = 0;
            return x;
        }
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#viewer').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileUpload").change(function() {
        readURL(this);
    });

    function readlogoURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#viewerLogo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#LogoUpload").change(function() {
        readlogoURL(this);
    });

    $("#email").on('focusout', function() {
        $("#ecode").val($("#email").val())
    })

    $("#sendOTP").click(function() {
        $('#loading').show();
        $.ajax({
            url: "{{ route('seller.register.otp') }}",
            data: $("#shopApply").serialize(),
            type: "post",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                $("#loading").hide();
                if (data.error) {
                    toastr.error(data.error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                } else {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            },
            complete: function() {
                $('#loading').hide();
            },
            error: function(data) {
                toastr.error(data.error, {
                    CloseButton: true,
                    ProgressBar: true
                });
                $('#loading').hide();
            }
        });
        $("#loading").hide();
    })

    function checkStrength(password) {
        var strength = 0;

        //If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            strength += 1;
            $(".low-upper-case").addClass("text-success");
            $(".low-upper-case i").removeClass("fa-times").addClass("fa-check");
            $("#popover-password-top").addClass("hide");
        } else {
            $(".low-upper-case").removeClass("text-success");
            $(".low-upper-case i").addClass("fa-times").removeClass("fa-check");
            $("#popover-password-top").removeClass("hide");
        }

        //If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
            strength += 1;
            $(".one-number").addClass("text-success");
            $(".one-number i").removeClass("fa-times").addClass("fa-check");
            $("#popover-password-top").addClass("hide");
        } else {
            $(".one-number").removeClass("text-success");
            $(".one-number i").addClass("fa-times").removeClass("fa-check");
            $("#popover-password-top").removeClass("hide");
        }

        //If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
            strength += 1;
            $(".one-special-char").addClass("text-success");
            $(".one-special-char i").removeClass("fa-times").addClass("fa-check");
            $("#popover-password-top").addClass("hide");
        } else {
            $(".one-special-char").removeClass("text-success");
            $(".one-special-char i").addClass("fa-times").removeClass("fa-check");
            $("#popover-password-top").removeClass("hide");
        }

        if (password.length > 7) {
            strength += 1;
            $("#nextBtn").attr('disabled', false)
            $(".eight-character").addClass("text-success");
            $(".eight-character i").removeClass("fa-times").addClass("fa-check");
            $("#popover-password-top").addClass("hide");
        } else {
            $("#nextBtn").attr('disabled', true)
            $(".eight-character").removeClass("text-success");
            $(".eight-character i").addClass("fa-times").removeClass("fa-check");
            $("#popover-password-top").removeClass("hide");
        }

        // If value is less than 2

        if (strength < 2) {
            $("#result").removeClass();
            $("#password-strength").addClass("progress-bar-danger");

            $("#result").addClass("text-danger").text("Very Week");
            $("#password-strength").css("width", "10%");
        } else if (strength == 2) {
            $("#result").addClass("good");
            $("#password-strength").removeClass("progress-bar-danger");
            $("#password-strength").addClass("progress-bar-warning");
            $("#result").addClass("text-warning").text("Week");
            $("#password-strength").css("width", "60%");
            return "Week";
        } else if (strength == 4) {
            $("#result").removeClass();
            $("#result").addClass("strong");
            $("#password-strength").removeClass("progress-bar-warning");
            $("#password-strength").addClass("progress-bar-success");
            $("#result").addClass("text-success").text("Strength");
            $("#password-strength").css("width", "100%");

            return "Strong";
        }
    }

    function _submit() {
        $('#loading').show()
        setTimeout(completeAlert, 10000);
    }

    function completeAlert() {
        $('#loading').hide()
        return true;
    }
</script>
@endsection