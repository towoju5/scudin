@extends('layouts.home.app')
@section('title', 'Checkout')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Checkout</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
@php($shipping_addresses=\App\Model\ShippingAddress::where('customer_id',auth('customer')->id())->get())
<section class="main-container col2-right-layout">
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-9 wow bounceInUp animated animated" style="visibility: visible;">
          <form method="post" action="" id="address-form">
            @csrf
            <ol class="one-page-checkout" id="checkoutSteps">
              <li id="opc-billing" class="section allow active">
                <div class="step-title"> <span class="number">1</span>
                  <h3 class="one_page_heading"> Billing & Shipping Information </h3>
                </div>
                <div id="checkout-step-billing" class="step a-item">
                  <div class="card-body" style="padding: 0!important;">
                    <ul class="list-group">
                      <div class="row">
                        <?php //var_dump(userLocation()); ?>
                        @foreach($shipping_addresses as $key=>$address)
                        <div class="col-md-6" style="padding-bottom: 10px;">
                          <li class="list-group-item mb-2 mt-2" style="cursor: pointer;background: rgba(245,245,245,0.51)" onclick="$('#sh-{{$address->id}}').prop( 'checked', true )">
                            <input type="radio" name="shipping_method_id" id="sh-{{$address['id']}}" value="{{$address['id']}}" {{$key==0?'checked':''}}>
                            <span class="checkmark" style="margin-right: 10px"></span>
                            <label class="badge" style="background: <?= $web_config['primary_color'] ?>; color:white !important;">{{$address['address_type']}}</label>
                            <small>
                              <i class="fa fa-phone"></i> {{$address['phone']}}
                            </small>
                            <hr>
                            <span>{{ __('contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                            <span>{{ __('address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}</span>
                          </li>
                        </div>
                        @endforeach
                      </div>
                      <li class="list-group-item mb-2 mt-2" onclick="anotherAddress()">
                        <input type="radio" name="shipping_method_id" id="sh-0" value="0" data-toggle="collapse" data-target="#collapseThree" {{$shipping_addresses->count()==0?'checked':''}}>
                        <span class="checkmark" style="margin-right: 10px"></span>
                        <button type="button" onclick="$('#accordion').show()" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#collapseThree">{{ __('Another')}} {{ __('address')}}
                        </button>
                        <div id="accordion" hidden>
                          <div id="collapseThree" class="show hide collapse {{$shipping_addresses->count()==0?'show':''}}" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('contact_person_name')}}
                                  <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="contact_person_name" {{$shipping_addresses->count()==0?'required':''}}>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('Phone')}}<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="phone" {{$shipping_addresses->count()==0?'required':''}}>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">{{ __('address')}} {{ __('Type')}}</label>
                                <select class="form-control" name="address_type">
                                  <option value="permanent">{{ __('Permanent')}}</option>
                                  <option value="home">{{ __('Home')}}</option>
                                  <option value="others">{{ __('Others')}}</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('City')}} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="city" {{$shipping_addresses->count()==0?'required':''}}>
                              </div>

                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('zip_code')}} <span style="color: red">*</span></label>
                                <input type="number" class="form-control" name="zip" {{$shipping_addresses->count()==0?'required':''}}>
                              </div>

                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('address')}} <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="address" {{$shipping_addresses->count()==0?'required':''}}>
                              </div>
                              <div class="form-check">
                                <input type="checkbox" name="save_address" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">
                                  {{ __('save_this_address')}}
                                </label>
                              </div>
                              <button type="submit" class="btn btn-primary" style="display: none" id="address_submit"></button>
                            </div>
                          </div>
                        </div>
                      </li>
                      <br>
                      <li>
                        <!-- <button type="button" class="btn btn-primary" onClick="proceed_to_next()" id="shippingMethod" style="float:right">
                          <i class="fa fa-arrow-right"></i> {{ __('Next')}}
                        </button> -->
                        <button type="button" class="button continue" onClick="proceed_to_next()"><span>Continue</span></button>
                        <!-- <button type="button" class="btn btn-primary" id="shippingAddress">
                          {{ __('Previous')}}
                        </button> -->
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              
              <li id="opc-shipping_method" class="section">
                <div class="step-title"> <span class="number">2</span>
                  <h3 class="one_page_heading"> Shipping Method</h3>
                </div>
                <div id="checkout-step-shipping_method" class="step a-item" hidden>
                  <form id="co-shipping-method-form" action="#">
                    <div id="checkout-shipping-method-load">
                      <p>Shipping Method: </p>
                      <p>Shipping Cost: </p>
                      <hr>
                      @foreach(session()->get('cart') as $key => $items)
                      {{ $items['shipping_method_id'] }}
                      <hr>
                      @endforeach
                      <hr> 
                    </div>

                    <div id="onepage-checkout-shipping-method-additional-load">

                    </div>
                    <div class="buttons-set" id="shipping-method-buttons-container">
                      <button type="button" class="button continue" onClick="proceed_to_next()"><span>Continue</span></button>
                      <a href="#" onClick="window.history.back(); return false;"><small>« </small>Back</a> <span id="shipping-method-please-wait" class="please-wait" style="display:none;"> <img src="{{ asset('home/images/opc-ajax-loader.gif') }}" alt="Loading next step..." title="Loading next step..." class="v-middle"> Loading next step... </span>
                    </div>
                  </form>
                </div>
              </li>
              <li id="opc-payment" class="section">
                <div class="step-title"> <span class="number">3</span>
                  <h3 class="one_page_heading"> Payment Information</h3>
                </div>
                <div id="checkout-step-payment" class="step a-item" hidden>

                  <form action="#" id="co-payment-form">
                    <fieldset>
                      <dl class="sp-methods" id="checkout-payment-method-load">
                        <div class="row">
                          @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                          @if($config['status'])
                          <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                              <div class="card-body" style="height: 100px">
                                <a href="{{route('checkout-complete',['payment_method'=>'cash_on_delivery'])}}">
                                  <img width="150" src="{{asset('assets/front-end/img/cod.png')}}" />
                                </a>
                              </div>
                            </div>
                          </div>
                          @endif

                          @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                          @if($config['status'])
                          <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                              <div class="card-body" style="height: 100px">
                                <form class="needs-validation" method="POST" id="payment-form" action="{{route('pay-paypal')}}">
                                  {{ csrf_field() }}
                                  <button class="btn btn-block" type="submit">
                                    <img width="150" src="{{asset('assets/front-end/img/paypal.png')}}" />
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                          @endif



                          @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                          @php($value = \App\CPU\CartManager::cart_grand_total(session('cart')) - $coupon_discount)

                          @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                          @if($config['status'])
                          <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                              <div class="card-body" style="height: 100px">
                                @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                                <form class="needs-validation" method="POST" id="payment-form" action="{{route('pay-stripe')}}">
                                  {{ csrf_field() }}
                                  <button class="btn btn-block" type="button" onclick="$('.stripe-button-el').click()">
                                    <img width="150" style="margin-top: -10px" src="{{asset('assets/front-end/img/stripe.png')}}" />
                                  </button>
                                  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{$config['published_key']}}" data-amount="{{($value-$coupon_discount)*100}}" data-name="{{auth('customer')->user()->f_name}}" data-description="" data-image="" data-locale="auto" data-currency="USD">
                                  </script>
                                </form>
                              </div>
                            </div>
                          </div>
                          @endif

                        </div>
                      </dl>
                    </fieldset>
                  </form>
                  <div class="tool-tip" id="payment-tool-tip" style="display:none;">
                    <div class="btn-close"><a href="#" id="payment-tool-tip-close" title="Close">Close</a></div>
                    <div class="tool-tip-content"></div>
                  </div>
                  <div class="buttons-set" id="payment-buttons-container">
                    <button type="button" class="button" onClick="window.history.back()"><span>« Back to Shipping Information</span></button>
                  </div>

                </div>
              </li>
              <li id="opc-review" class="section">
                <div class="step-title"> <span class="number">4</span>
                  <h3 class="one_page_heading"> Order Review</h3>
                </div>
                <div id="checkout-step-review" class="step a-item" style="display:none;">
                  <div class="order-review" id="checkout-review-load">
                    <!-- Content loaded dynamically -->
                  </div>
                </div>
              </li>
            </ol>
          </form>

          <br>
        </section>
        <aside class="col-right sidebar col-sm-3 wow bounceInUp animated animated" style="visibility: visible;">
          <div id="checkout-progress-wrapper">
            <div class="block block-progress">
              <div class="block-title"> Your Checkout </div>
              <div class="block-content">
                <div>
                  <div id="billing-progress-opcheckout">
                    <span> Billing Address & Shipping Address</span>
                  </div>
                  <div id="shipping-progress-opcheckout">
                    <span></span>
                  </div>
                  <!-- <div id="shipping_method-progress-opcheckout">
                    <span> Shipping Method</span>
                  </div> -->
                  <div id="payment-progress-opcheckout">
                    <span> Delivery Process</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>
        <!--col-right sidebar-->
      </div>
      <!--row-->
    </div>
    <!--main-container-inner-->
  </div>
</section>
@stop

@push('js')

<script>
  function anotherAddress() {
    $('#sh-0').prop('checked', true);
    $("#collapseThree").collapse();
  }

  $(document).ready(function() { // when next is clicked
    $('#shippingMethod').on('click', function() {
      $("#opc-shipping_method").addClass('allow active');
      $("#opc-billing").removeClass('allow active');
      $("#checkout-step-billing").hide();
      $("#checkout-step-shipping_method").focus().show();
    })

    $('#shippingAddress').on('click', function() {
      var $btn = $(this).button('loading')
      alert('You click me dude: shippingAddress')
      $btn.button('reset')
    })
  });


  function set_shipping() {
    $.ajax({
      url: '{{ route("customer.choose-shipping-address") }}',
      dataType: 'json',
      type: 'post',
      data: $('#address-form').serialize(),
      beforeSend: function() {
        $('#loading').show();
      },
      success: function(data) {
        if (data.errors) {
          for (var i = 0; i < data.errors.length; i++) {
            toastr.error(data.errors[i].message, {
              CloseButton: true,
              ProgressBar: true
            });
          }
        } else {
          location.href = '{{ route("checkout-payment") }}';
        }
      },
      complete: function() {
        $('#loading').hide();
      },
      error: function() {
        toastr.error('Something went wrong!', {
          CloseButton: true,
          ProgressBar: true
        });
      }
    });
  }


  function proceed_to_next() {

    let allAreFilled = true;
    document.getElementById("address-form").querySelectorAll("[required]").forEach(function(i) {
      if (!allAreFilled) return;
      if (!i.value) allAreFilled = false;
      if (i.type === "radio") {
        let radioValueCheck = false;
        document.getElementById("address-form").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
          if (r.checked) radioValueCheck = true;
        });
        allAreFilled = radioValueCheck;
      }
    });


    if (allAreFilled) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: '{{ route("customer.choose-shipping-address") }}',
        dataType: 'json',
        type: 'post',
        data: $('#address-form').serialize(),
        beforeSend: function() {
          $('#loading').show();
        },
        success: function(data) {
          if (data.errors) {
            for (var i = 0; i < data.errors.length; i++) {
              toastr.error(data.errors[i].message, {
                CloseButton: true,
                ProgressBar: true
              });
            }
          } else {
            location.href = '{{ route("checkout-shipping") }}';
          }
        },
        complete: function() {
          $('#loading').hide();
        },
        error: function() {
          toastr.error('Something went wrong!', {
            CloseButton: true,
            ProgressBar: true
          });
        }
      });
    } else {
      toastr.error('Please fill all required fields', {
        CloseButton: true,
        ProgressBar: true
      });
    }
  }
</script>
@endpush