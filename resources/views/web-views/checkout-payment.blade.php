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
<style>
  .stripe-button-el {
    display: none;
  }
</style>
<section class="main-container col2-right-layout">
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-9 wow bounceInUp animated animated" style="visibility: visible;">
          @csrf
          <ol class="one-page-checkout" id="checkoutSteps">
            <form method="post" action="" id="address-form">
              <li id="opc-billing" class="section">
                <div class="step-title"> <span class="number">1</span>
                  <h3 class="one_page_heading"> Billing & Shipping Information </h3>
                </div>
              </li>
              <li id="opc-billing" class="section">
                <div class="step-title"> <span class="number">2</span>
                  <h3 class="one_page_heading"> Billing & Shipping Information </h3>
                </div>
              </li>
            </form>
            <li id="opc-payment" class="section allow active">
              <div class="step-title"> <span class="number">3</span>
                <h3 class="one_page_heading"> Payment Information</h3>
              </div>
              <div id="checkout-step-payment" class="step a-item">

                <!-- <form action="#" id="co-payment-form"> -->
                  <fieldset>
                    <dl class="sp-methods" id="checkout-payment-method-load">
                      <div class="row">
                        <?php /*
                        @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                        @if($config['status'])
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                          <div class="card">
                            <div class="card-body" style="height: 100px">
                              <a href="{{route('checkout-complete',['payment_method'=>'cash_on_delivery'])}}">
                                <img width="100%" src="{{asset('assets/front-end/img/cod.png')}}" />
                              </a>
                            </div>
                          </div>
                        </div>
                        @endif
                        */ ?>

                        @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                        @if($config['status'])
                        <div class="col-md-6 mb-4" style="cursor: pointer; margin-bottom: 3rem">
                          <!-- <div class="card"> -->
                            <div class="card-body">
                              <form class="needs-validation" method="POST" id="payment-form" action="{{route('pay-paypal')}}">
                                {{ csrf_field() }}
                                <button type="submit" id="paypal_submit" hidden></button>
                                <img width="100%" style="max-height: 110px" src="{{asset('assets/front-end/img/paypal.svg')}}" onclick="$('#paypal_submit').click()"/>                                
                              </form>
                            <!-- </div> -->
                          </div>
                        </div>
                        @endif



                        @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                        @php($value = \App\CPU\CartManager::cart_grand_total(session('cart')) - $coupon_discount)

                        @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                        @if($config['status'])
                        <div class="col-md-6 mt-2" style="cursor: pointer; margin-bottom: 10px">
                          <!-- <div class="card"> -->
                            <div class="card-body">
                              @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                              <form class="needs-validation" method="POST" id="payment-form" action="{{route('pay-stripe')}}">
                                {{ csrf_field() }}
                                <img width="100%" style="margin-top: -10px; max-height: 110px" src="{{asset('assets/front-end/img/stripe.png')}}" onclick="$('.stripe-button-el').click()">
                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{$config['published_key']}}" data-amount="{{($value-$coupon_discount)*100}}" data-name="{{auth('customer')->user()->f_name.' '.auth('customer')->user()->l_name}}" data-description="" data-image="{{asset(auth('customer')->user()->image)}}" data-email="{{auth('customer')->user()->email}}" data-locale="auto" data-currency="USD">
                                </script>
                              </form>
                            </div>
                          <!-- </div> -->
                        </div>
                        @endif

                      </div>
                    </dl>
                  </fieldset>
                <!-- </form> -->
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
        </section>
        <aside class="col-right sidebar col-sm-3 wow bounceInUp animated animated" style="visibility: visible;">
          <div id="checkout-progress-wrapper">
            <div class="block block-progress">
              <div class="block-title"> Your Checkout </div>
              <div class="block-content">
                <div>
                  <div id="billing-progress-opcheckout">
                    <span> Billing Address</span>
                  </div>
                  <div id="shipping-progress-opcheckout">
                    <span> Shipping Address</span>
                  </div>
                  <div id="shipping_method-progress-opcheckout">
                    <span> Shipping Method</span>
                  </div>
                  <div id="payment-progress-opcheckout">
                    <span> Payment Method</span>
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

  function shippingMethodsave() {
    // save shippingMethod => set-shipping-method
    $.ajax({
      url: '{{ route("customer.set-shipping-method") }}',
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
    } else {
      toastr.error('Please fill all required fields', {
        CloseButton: true,
        ProgressBar: true
      });
    }
  }
</script>
@endpush