@extends('layouts.backend')

@section('title', 'Deliveries')

@section('css')
<!-- BEGIN: Page CSS-->
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/calendars/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/app-calendar.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<!-- END: Vendor CSS-->
<!-- END: Page CSS-->
@endsection

@section('content')

<section id="pricing-plan">

  <!-- pricing plan cards -->
  <div class="row pricing-card">
    <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
      <div class="row">
        @php $activePlanPrice = \App\Subscription::find(auth('seller')->user()->plan_id) @endphp
        <?php if(empty($activePlanPrice)){
          $activePlanPrice = 0;
        } else {
          $activePlanPrice = $activePlanPrice->plan_price;
        } ?>
        @foreach($plans as $plan)
        <div class="col-12 col-md-4">
          <div class="card basic-pricing text-center">
            <div class="card-body">
              <img src="{{ asset('app-assets/images/illustration/Pot1.svg') }}" class="mb-2 mt-5" alt="svg img" />
              <h3>{{ $plan->plan_name }}</h3>
              <p class="card-text">A simple start for everyone</p>
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
                <?php /* <li class="list-group-item">Unlimited forms and surveys</li>
                <li class="list-group-item">Unlimited fields</li>
                <li class="list-group-item">Basic form creation tools</li> */ ?>
                <li class="list-group-item equal">
                  @if(!empty($plan->description))
                  {!! $plan->description !!}
                  @endif
                </li>
              </ul>
              @if(auth('seller')->user()->plan_id == $plan->id)
              <button class="btn btn-block btn-outline-success mt-2" disabled>Your current plan</button>
              @elseif($plan->plan_price < $activePlanPrice) <a href="{{ route('seller.subscription.buy', $plan->id) }}">
                <button class="btn btn-block btn-outline-warning mt-2">Downgrade plan</button>
                </a>
              @else
                <a href="{{ route('seller.subscription.buy', $plan->id) }}">
                  <button class="btn btn-block btn-outline-primary mt-2">Upgrade plan</button>
                </a>
              @endif
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
  <!--/ pricing plan cards -->

</section>
@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/calendar/fullcalendar.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="{{ url('/') }}/app-assets/js/scripts/pages/app-calendar-events.js"></script>
<script src="{{ url('/') }}/app-assets/js/scripts/pages/app-calendar.js"></script>
<script type="text/javascript" src="https://brm.io/js/libs/matchHeight/jquery.matchHeight.js"></script>
<script>
  $(function() {
    $('.equal').matchHeight();
  });
</script>
@endsection