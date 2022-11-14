@extends('layouts.backend')
@section('title','Payment Method')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{__('payment_method')}}</h4>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{__('Paypal')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                    <form action="{{route('admin.business-settings.payment-method.update',['paypal'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{__('Paypal')}} {{__('Payment')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{__('Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{__('Inactive')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{__('Paypal')}} {{__('Client')}}{{__('ID')}}  </label><br>
                                <input type="text" class="form-control" name="paypal_client_id"
                                       value="{{env('APP_MODE')=='demo'?'':($config['paypal_client_id'])}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{__('Paypal')}} {{__('Secret')}} </label><br>
                                <input type="text" class="form-control" name="paypal_secret"
                                       value="{{env('APP_MODE')=='demo'?'':($config['paypal_secret'])}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{__('save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{__('Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{__('Stripe')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                    <form action="{{route('admin.business-settings.payment-method.update',['stripe'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{__('stripe')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{__('Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{__('Published')}}{{__('Key')}}  </label><br>
                                <input type="text" class="form-control" name="published_key"
                                       value="{{env('APP_MODE')=='demo'?'':($config['published_key'])}}">
                            </div>

                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{__('api_key')}}</label><br>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')=='demo'?'':($config['api_key'])}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{__('save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{__('Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
