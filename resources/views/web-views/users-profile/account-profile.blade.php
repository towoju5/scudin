@extends('layouts.home.app')
@section('title', 'Profile Dashboard')
@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Profile Dashboard</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<section class="main-container col2-right-layout">
  <div class="main container">
    <div class="row">
      <section class="col-main col-sm-9 col-xs-12 wow bounceInUp animated animated" style="visibility: visible;">
        <div class="my-account">
          <!--page-title-->
          <!-- BEGIN DASHBOARD-->
          <div class="dashboard">
            <form class="mt-3" action="{{ route('user-update') }}" method="post" enctype="multipart/form-data">
              <div class="row photoHeader">
                @csrf
                <div class="col-md-12">
                  <div class="col-md-1">
                    <img id="blah" style=" border-radius: 50px; width: 50px!important;height: 50px!important;" class="rounded-circle border" src="{{asset($customerDetail['image'])}}" onerror="{{ asset('default.png') }}">
                  </div>
                  <div class="col-md-10">
                    <h5 class="font-name">{{ $customerDetail->f_name. ' '.$customerDetail->l_name }}</h5>
                    <label for="files" style="cursor: pointer; color:#3b71de;" class="spandHeadO">
                      {{ __('change_your_profile') }}
                    </label>
                    <span style="color: red;font-size: 10px">( * Image ratio should be 1:1 )</span>
                    <input id="files" name="image" style="visibility:hidden;" type="file">
                  </div>
                  <p class="h3 font-nameA">Account information </p>
                </div>
                <div class="card-body ml-3">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="firstName">{{ __('first_name')}} </label>
                      <input type="text" class="form-control" id="f_name" name="f_name" value="{{$customerDetail['f_name']}}" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="lastName"> {{ __('last_name')}} </label>
                      <input type="text" class="form-control" id="l_name" name="l_name" value="{{$customerDetail['l_name']}}">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">{{ __('Email')}} </label>
                      <input type="email" class="form-control" type="email" id="account-email" value="{{$customerDetail['email']}}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="phone">{{ __('phone_name')}} </label>
                      <input type="number" class="form-control" type="text" id="phone" name="phone" value="{{$customerDetail['phone']}}" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="si-password">{{ __('new_password')}}</label>
                      <div class="password-toggle">
                        <input class="form-control" autocomplete="off" name="password" type="password" id="password">
                        <label class="password-toggle-btn">
                          <input class="custom-control-input" type="checkbox" style="display: none">
                          <i class="czi-eye password-toggle-indicator" onChange="checkPasswordMatch()"></i>
                          <span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="newPass">{{ __('confirm_password')}} </label>
                      <div class="password-toggle">
                        <input class="form-control" name="con_password" type="password" id="confirm_password">
                        <div>
                          <label class="password-toggle-btn">
                            <input class="custom-control-input" type="checkbox" style="display: none">
                            <i class="czi-eye password-toggle-indicator" onChange="checkPasswordMatch()"></i><span class="sr-only">{{ __('Show')}} {{ __('password')}} </span>
                          </label>
                        </div>
                      </div>
                      <div id='message'></div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary" style="background-color: #3b71de;float:right"> {{ __('update')}} {{ __('Informations')}} </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!--col-main col-sm-9 wow bounceInUp animated-->
      <aside class="col-right sidebar col-sm-3 col-xs-12 wow bounceInUp animated animated" style="visibility: visible;">
        @include('web-views.users-profile.partials._sidebar')
      </aside>
      <!--col-right sidebar col-sm-3 wow bounceInUp animated-->
    </div>
    <!--row-->
  </div>
  <!--main container-->
</section>
@stop
@push('js')
<script>
  function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#confirm_password").val();
    $("#message").removeAttr("style");
    $("#message").html("");
    if (confirmPassword == "") {
      $("#message").attr("style", "color:black");
      $("#message").html("Please ReType Password");
    } else if (password == "") {
      $("#message").removeAttr("style");
      $("#message").html("");
    } else if (password != confirmPassword) {
      $("#message").html("Passwords do not match!");
      $("#message").attr("style", "color:red");
    } else if (confirmPassword.length <= 6) {
      $("#message").html("password Must Be 6 Character");
      $("#message").attr("style", "color:red");
    } else {
      $("#message").html("Passwords match.");
      $("#message").attr("style", "color:green");
    }
  }
  $(document).ready(function() {
    $("#confirm_password").keyup(checkPasswordMatch);
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  $("#files").change(function() {
    readURL(this);
  });
</script>
@endpush