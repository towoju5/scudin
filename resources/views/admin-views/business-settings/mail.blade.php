@extends('layouts.backend')
@section('title','Mail Template')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{__('general_business_settings')}}</h4>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('admin.business-settings.mail-settings')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 mb-3">
                                <label for="editor">{{__('Password Reset Success')}}</label>
                                <p><small>Use !new_password to display New Password</small></p>
                                <textarea class="form-control" id="password_reset_success" name="password_reset_success">{{$password_reset_success}}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Password Reset')}}</label>
                                <p><small>Use !link to display Password Reset URL</small></p>
                                <textarea class="form-control" id="password_reset" name="password_reset">{{ $password_reset }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('User Registration')}}</label>
                                <p><small>Use !user to display User FullName</small></p>
                                <textarea class="form-control" id="user_registration" name="user_registration">{{ $user_registration }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Seller Registration')}}</label>
                                <p><small>Use !user to display ShopName</small></p>
                                <textarea class="form-control" id="seller_reg_email" name="seller_reg_email">{{ $seller_reg_email }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Subscription Plan')}}</label>
                                <p><small>Use !plan to display plan name</small></p>
                                <textarea class="form-control" id="subscription_plan" name="subscription_plan">{{ $subscription_plan }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Plan Expiration')}}</label>
                                <p><small>Use !plan to display plan name</small></p>
                                <textarea class="form-control" id="plan_expiration" name="plan_expiration">{{ $plan_expiration }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Plan Auto Renewal notification')}} </label>
                                <p><small>5days Upfront Notice. Use !plan to display plan name</small></p>
                                <textarea class="form-control" id="plan_expiration_notice" name="plan_expiration_notice">{{ $plan_expiration_notice }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('General Invoice')}} </label>
                                <p><small>5days Upfront Notice. Use !plan to display plan name</small></p>
                                <textarea class="form-control" readonly id="general_invoice" name="general_invoice">{{ $general_invoice }}</textarea>
                            </div>
                            <div class="col-md-12  mb-3">
                                <label for="editor">{{__('Plan Expired')}} </label>
                                <p><small>5days Upfront Notice. Use !plan to display plan name</small></p>
                                <textarea class="form-control" readonly id="plan_expired" name="plan_expired">{{ $plan_expired }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input class="form-control btn-primary" type="submit" name="btn">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
  label {
    font-weight: 600;
    font-size: 1.857rem!important;
  }
</style>
@endsection
