@extends('layouts.backend')
@section('title', __('enviroment_variable_settings'))

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-2">
        <h4 class="mb-0 text-black-50 text-uppercase">{{__('enviroment_variable_settings')}} </h4>
    </div>

    <div class="row" style="padding-bottom: 20px">

        <div class="col-md-8">
            <div class="card-header">
                <h5>Constant Enviroment Settings</h5>
            </div>
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <form autocomplete="off" action="{{route('admin.business-settings.seller-settings.update-seller-settings')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="HUBSPOT_API_KEY">{{ __(str_replace('_', ' ', 'HUBSPOT_API_KEY')) }}</label>
                            <input type="text" name="HUBSPOT_API_KEY" id="HUBSPOT_API_KEY" value="{{ getenv('HUBSPOT_API_KEY') }}" class="form-control">
                        </div>

                        <hr>
                        <h4>• Footer Column Settings <br> <small>Please use - instead of space</small></h4>
                        <div class="form-group text-uppercase">
                            <label for="column_1">{{ __(str_replace('_', ' ', 'column_1')) }}</label>
                            <input type="text" name="column_1" id="column_1" value="{{ getenv('column_1') }}" class="form-control">
                        </div>
                        <div class="form-group text-uppercase">
                            <label for="column_2">{{ __(str_replace('_', ' ', 'column_2')) }}</label>
                            <input type="text" name="column_2" id="column_2" value="{{ getenv('column_2') }}" class="form-control">
                        </div>
                        <div class="form-group text-uppercase">
                            <label for="column_3">{{ __(str_replace('_', ' ', 'column_3')) }}</label>
                            <input type="text" name="column_3" id="column_3" value="{{ getenv('column_3') }}" class="form-control">
                        </div>
                        <div class="form-group text-uppercase">
                            <label for="column_4">{{ __(str_replace('_', ' ', 'column_4')) }}</label>
                            <input type="text" name="column_4" id="column_4" value="{{ getenv('column_4') }}" class="form-control">
                        </div>

                        <hr>
                        <h4>• UPS Settings</h4>
                        <div class="form-group">
                            <label for="UPS_USER_ID">{{ __(str_replace('_', ' ', 'UPS_USER_ID')) }}</label>
                            <input type="text" name="UPS_USER_ID" id="UPS_USER_ID" value="{{ getenv('UPS_USER_ID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="UPS_PASSWORD">{{ __(str_replace('_', ' ', 'UPS_PASSWORD')) }}</label>
                            <input type="text" name="UPS_PASSWORD" id="UPS_PASSWORD" value="{{ getenv('UPS_PASSWORD') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="UPS_SHIPPER_NUMBER">{{ __(str_replace('_', ' ', 'UPS_SHIPPER_NUMBER')) }}</label>
                            <input type="text" name="UPS_SHIPPER_NUMBER" id="UPS_SHIPPER_NUMBER" value="{{ getenv('UPS_SHIPPER_NUMBER') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="UPS_ACCESS_KEY">{{ __(str_replace('_', ' ', 'UPS_ACCESS_KEY')) }}</label>
                            <input type="text" name="UPS_ACCESS_KEY" id="UPS_ACCESS_KEY" value="{{ getenv('UPS_ACCESS_KEY') }}" class="form-control">
                        </div>

                        <hr>
                        <h4>• FedEx Settings</h4>
                        <div class="form-group">
                            <label for="FEDEX_KEY">{{ __(str_replace('_', ' ', 'FEDEX_KEY')) }}</label>
                            <input type="text" name="FEDEX_KEY" id="FEDEX_KEY" value="{{ getenv('FEDEX_KEY') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="FEDEX_PASSWORD">{{ __(str_replace('_', ' ', 'FEDEX_PASSWORD')) }}</label>
                            <input type="text" name="FEDEX_PASSWORD" id="FEDEX_PASSWORD" value="{{ getenv('FEDEX_PASSWORD') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="FEDEX_ACCOUNT_NUMBER">{{ __(str_replace('_', ' ', 'FEDEX_ACCOUNT_NUMBER')) }}</label>
                            <input type="text" name="FEDEX_ACCOUNT_NUMBER" id="FEDEX_ACCOUNT_NUMBER" value="{{ getenv('FEDEX_ACCOUNT_NUMBER') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="FEDEX_METER_NUMBER">{{ __(str_replace('_', ' ', 'FEDEX_METER_NUMBER')) }}</label>
                            <input type="text" name="FEDEX_METER_NUMBER" id="FEDEX_METER_NUMBER" value="{{ getenv('FEDEX_METER_NUMBER') }}" class="form-control">
                        </div>
                        <hr>
                        <h4>• Twillio Settings</h4>
                        <div class="form-group">
                            <label for="TWILIO_SID">{{ __(str_replace('_', ' ', 'TWILIO_SID')) }}</label>
                            <input type="text" name="TWILIO_SID" id="TWILIO_SID" value="{{ getenv('TWILIO_SID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="TWILIO_TOKEN">{{ __(str_replace('_', ' ', 'TWILIO_TOKEN')) }}</label>
                            <input type="text" name="TWILIO_TOKEN" id="TWILIO_TOKEN" value="{{ getenv('TWILIO_TOKEN') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="TWILIO_FROM">{{ __(str_replace('_', ' ', 'TWILIO_FROM')) }}</label>
                            <input type="text" name="TWILIO_FROM" id="TWILIO_FROM" value="{{ getenv('TWILIO_FROM') }}" class="form-control">
                        </div>
                        <!-- <div class="form-group">
                            <label for="FEDEX_METER_NUMBER">{{ __(str_replace('_', ' ', 'FEDEX_METER_NUMBER')) }}</label>
                            <input type="text" name="FEDEX_METER_NUMBER" id="FEDEX_METER_NUMBER" value="{{ getenv('FEDEX_METER_NUMBER') }}" class="form-control">
                        </div> -->
                        <hr>
                        <h4>• Social Login</h4>
                        <div class="form-group">
                            <label for="FB_CLIENT_ID">{{ __(str_replace('_', ' ', 'FB_CLIENT_ID')) }}</label>
                            <input type="text" name="FB_CLIENT_ID" id="FB_CLIENT_ID" value="{{ getenv('FB_CLIENT_ID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="FB_CLIENT_SECRET">{{ __(str_replace('_', ' ', 'FB_CLIENT_SECRET')) }}</label>
                            <input type="text" name="FB_CLIENT_SECRET" id="FB_CLIENT_SECRET" value="{{ getenv('FB_CLIENT_SECRET') }}" class="form-control">
                            <p>Facebook callback url: <small><?= url(getenv('FACEBOOK_CALLBACK')) ?></small></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="GOOGLE_CLIENT_ID">{{ __(str_replace('_', ' ', 'GOOGLE_CLIENT_ID')) }}</label>
                            <input type="text" name="GOOGLE_CLIENT_ID" id="GOOGLE_CLIENT_ID" value="{{ getenv('GOOGLE_CLIENT_ID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="GOOGLE_CLIENT_SECRET">{{ __(str_replace('_', ' ', 'GOOGLE_CLIENT_SECRET')) }}</label>
                            <input type="text" name="GOOGLE_CLIENT_SECRET" id="GOOGLE_CLIENT_SECRET" value="{{ getenv('GOOGLE_CLIENT_SECRET') }}" class="form-control">
                            <p>Google callback url: <small><?= url(getenv('GOOGLE_CALLBACK')) ?></small></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="TWITTER_CLIENT_ID">{{ __(str_replace('_', ' ', 'TWITTER_CLIENT_ID')) }}</label>
                            <input type="text" name="TWITTER_CLIENT_ID" id="TWITTER_CLIENT_ID" value="{{ getenv('TWITTER_CLIENT_ID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="TWITTER_CLIENT_SECRET">{{ __(str_replace('_', ' ', 'TWITTER_CLIENT_SECRET')) }}</label>
                            <input type="text" name="TWITTER_CLIENT_SECRET" id="TWITTER_CLIENT_SECRET" value="{{ getenv('TWITTER_CLIENT_SECRET') }}" class="form-control">
                            <p>TWITTER callback url: <small><?= url(getenv('TWITTER_CALLBACK')) ?></small></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="GITHUB_CLIENT_ID">{{ __(str_replace('_', ' ', 'GITHUB_CLIENT_ID')) }}</label>
                            <input type="text" name="GITHUB_CLIENT_ID" id="GITHUB_CLIENT_ID" value="{{ getenv('GITHUB_CLIENT_ID') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="GITHUB_CLIENT_SECRET">{{ __(str_replace('_', ' ', 'GITHUB_CLIENT_SECRET')) }}</label>
                            <input type="text" name="GITHUB_CLIENT_SECRET" id="GITHUB_CLIENT_SECRET" value="{{ getenv('GITHUB_CLIENT_SECRET') }}" class="form-control">
                            <p>GITHUB callback url: <small><?= url(getenv('GITHUB_CALLBACK')) ?></small></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="min-width: 150px;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @php($seller_registration=\App\Model\BusinessSetting::where('type','seller_registration')->first()->value)
        <div class="col-md-4">
            <div class="card-header">
                <h5>Seller Registration</h5>
            </div>
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <form action="{{route('admin.business-settings.seller-settings.update-seller-registration')}}" method="post">
                        @csrf
                        <label>Seller Registration on/off</label>
                        <div class="form-check">
                            <input class="form-check-input" name="seller_registration" type="radio" value="1" id="defaultCheck1" <?= $seller_registration==1 ? 'checked':'' ?>>
                            <label class="form-check-label" for="defaultCheck1">
                                Turn on
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="seller_registration" type="radio" value="0" id="defaultCheck2" {{$seller_registration==0?'checked':''}}>
                            <label class="form-check-label" for="defaultCheck2">
                                Turn off
                            </label>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary float-right ml-3">{{__('Save')}}</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
<script src="{{ asset('assets/select2/js/select2.min.js')}}"></script>
@endpush