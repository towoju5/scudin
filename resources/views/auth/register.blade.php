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

            <form class="needs-validation_" id="sign-up-form-" action="{{route('customer.auth.register')}}" method="post">
               @csrf
               @honeypot
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="reg-fn">{{ __('first_name')}}</label>
                        <input class="form-control" type="text" name="f_name" required>
                        <input class="form-control" type="hidden" name="honey">
                        <div class="invalid-feedback">Please enter your first name!</div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="reg-ln">{{ __('last_name')}}</label>
                        <input class="form-control" type="text" name="l_name" required>
                        <div class="invalid-feedback">Please enter your last name!</div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="reg-email">{{ __('email_address')}}</label>
                        <input class="form-control" type="email" name="email" required>
                        <div class="invalid-feedback">Please enter valid email address!</div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="reg-phone">{{ __('phone_name')}}</label>
                        <input class="form-control" type="text" name="phone" required>
                        <div class="invalid-feedback">Please enter your phone number!</div>
                     </div>
                     @error('phone')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="si-password">{{ __('password')}}</label>
                        <div class="password-toggle">
                           <input class="form-control" name="password" type="password" id="si-password" required>
                           <label class="password-toggle-btn">
                              <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{
                                 __('password')}} </span>
                           </label>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="si-password">{{ __('confirm_password')}}</label>
                        <div class="password-toggle">
                           <input class="form-control" name="con_password" type="password" id="con-password" required>
                           <label class="password-toggle-btn">
                              <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show')}} {{
                                 __('password')}} </span>
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
            <div class="col-sm-12">
               <div class="text-right">
                  <button class="btn btn-primary btn-block" type="submit" onclick="$('#loading').show();" id="sign_in" disabled><i class="czi-user mr-2 ml-n1"></i>{{ __('sing_up')}}
                  </button>
               </div>
            </div>
            <div class="col-sm-12 mt-3">
               <a class="btn btn-outline-primary btn-block" href="{{route('customer.auth.login')}}">
                  <i class="fa fa-sign-in"></i> {{ __('sing_in')}}
               </a>
            </div>
         </div>
         </form>
      </div>
   </div>
   <!-- /Login v1 -->
</div>
</div>

<script>
   $('#inputCheckd').change(function() {
      if ($(this).is(':checked')) {
         $('#sign_in').removeAttr('disabled');
      } else {
         $('#sign_in').attr('disabled', 'disabled');
      }

   });
   $('#sign-up-form').submit(function(e) {
      e.preventDefault();
      $('#loading').show();
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
         error: function(err) {
            toastr.error(err, {
               CloseButton: true,
               ProgressBar: true
            });
         }
      });
      $("#loading").hide();
   });
</script>

@endsection