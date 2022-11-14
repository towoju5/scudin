@extends('layouts.home.app')
@section('title', 'Track Order')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Track Order</h2>
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
            <div style="margin: 0 auto; padding: 15px;">
              <h1 style="padding: 20px; text-align: center;">Track Order</h1>

              <form action="{{route('track-order.result')}}" type="submit" method="post" style="padding: 35px;">
                @csrf

                @if(session()->has('Error'))
                <div class="alert alert-danger alert-block">
                  <span type="" class="closet " data-dismiss="alert">×</span>
                  <strong>{{ session()->get('Error') }}</strong>
                </div>
                @endif

                <div class="form-group">
                  <label for="order_id" class="h4">{{ __('Order ID') }}</label>
                  <input class="form-control prepended-form-control" type="text" name="order_id" id="order_id" placeholder="Enter Your Order ID" required>
                </div>
                <div class="form-group">
                  <label for="phone_number" class="h4">{{ __('Phone Number') }}</label>
                  <input class="form-control prepended-form-control" type="number" name="phone_number" id="phone_number" placeholder="Enter Your Phone Number" required>
                </div>
                <div class="text-center">
                  <button class="btn btn-primary btn-lg" type="submit" name="trackOrder"> <i class="lni lni-search"></i> Track Order</button>
                </div>
              </form>
            </div>
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
<?php /*
    $tracking = new Ups\Tracking($accessKey, $userId, $password);
    try {
          return $shipment = $tracking->track('TRACKING NUMBER');
    
          foreach($shipment->Package->Activity as $activity) {
                var_dump($activity);
          }
    
    } catch (Exception $e) {
          var_dump($e);
    }

    */ ?>
@stop