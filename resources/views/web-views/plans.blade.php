@extends('layouts.home.app')
@section('title', 'Ethos Accounts')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Ethos Accounts</h2>
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
            <!-- // Content Here -->
            <div class="panel">
              <div class="panel-body">
                <h1>Current Plan: {{ $curr_plan->plan_name }}</h1>
                @php $activePlanPrice = \App\Subscription::find(auth('customer')->user()->plan_id)->plan_price @endphp
                @forelse($plans as $k => $plan)
                <div class="col-12 col-md-4" style="padding: 20px;">
                  <div class="panel text-center" style="box-shadow: 5px 5px 5px 5px #888888;">
                    <div class="panel-body">
                      <img src="{{ asset('app-assets/images/illustration/Pot1.svg') }}" class="mb-2 mt-5" alt="svg img" />
                      <h3>{{ $plan->plan_name }}</h3>
                      <p class="panel-text">A simple start for everyone</p>
                      <div class="annual-plan">
                        <div class="plan-price mt-2 pb-2">
                          <sup class="font-medium-1 font-weight-bold text-primary">$</sup>
                          <span class="pricing-basic-value font-weight-bolder text-primary">{{ number_format($plan->plan_price, 2) }}</span>
                          <sub class="pricing-duration text-body font-medium-1 font-weight-bold">/
                            @if($plan->plan_duration == 30 )
                            {{ __('Monthly') }}
                            @elseif($plan->plan_duration == 7)
                            {{ __('Weekly') }}
                            @elseif($plan->plan_duration == 365 || $plan->plan_duration == 366)
                            {{ __('Annualy') }}
                            @elseif($plan->plan_duration == 0)
                            {{ __('Free for life') }}
                            @else
                            {{ $plan->plan_duration }}
                            @endif
                          </sub>
                        </div>
                        <small class="annual-pricing d-none text-muted"></small>
                      </div>
                      <ul class="list-group list-group-circle text-left">
                        <li class="list-group-item">
                          @if($plan->allowed_products > 0)
                          {{ $plan->allowed_products }} Maximum Product(s)
                          @elseif($plan->allowed_products == -1)
                          {{ __("Unlimited Products") }}
                          @endif
                        </li>
                        <li class="list-group-item equal">
                          @if(!empty($plan->description))
                          {!! $plan->description !!}
                          @endif
                        </li>
                      </ul>
                      @if(auth('customer')->user()->plan_id == $plan->id)
                      <button class="btn btn-block btn-outline-success mt-2" disabled>Your current plan</button>
                      @elseif($plan->plan_price < $activePlanPrice) <a href="{{ route('plans.buy', $plan->id) }}">
                        <button class="btn btn-block btn-outline-warning mt-2">Downgrade plan</button>
                        </a>
                        @else
                        <a href="{{ route('plans.buy', $plan->id) }}">
                          <button class="btn btn-block btn-outline-primary mt-2">Upgrade plan</button>
                        </a>
                        @endif
                    </div>
                  </div>
                </div>
                @empty
                <div class="panel">
                  <h3 class="text-center">No Plans Available at the moment, kindly check back later</h3>
                </div>
                @endforelse
              </div>
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
<style>
  .list-group.list-group-circle {
    border: none;
  }

  .text-left {
    text-align: left !important;
  }

  .list-group {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
  }

  .list-group.list-group-circle .list-group-item {
    border: none;
    position: relative;
    padding-left: 1.5rem;
  }

  .list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
  }

  .list-group-item {
    line-height: 1.5;
  }

  .list-group-item {
    position: relative;
    display: block;
    padding: 0.75rem 1.25rem;
    background-color: #FFF;
    border: 1px solid rgba(34, 41, 47, .125);
  }
</style>
@stop