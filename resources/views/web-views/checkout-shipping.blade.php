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
<?php
$sub_total = 0;
$total_tax = 0;
$total_shipping_cost = 0;
$total_discount_on_product = 0;
$_msg = "";
if (session()->has('cart') && count(session()->get('cart')) > 0) :
  foreach (session('cart') as $key => $cartItem) :
    $sub_total += $cartItem['price'] * $cartItem['quantity'];
    $total_tax += $cartItem['tax'] * $cartItem['quantity'];
    $total_shipping_cost += $cartItem['shipping_cost'];
    $total_discount_on_product += $cartItem['discount'] * $cartItem['quantity'];
  endforeach;
else :
  $_msg = "<span>Empty Cart</span>";
endif
?>
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
              <li id="opc-billing" class="section">
                <div class="step-title"> <span class="number">1</span>
                  <h3 class="one_page_heading"> Shipping Address </h3>
                </div>
              </li>
              <li id="opc-shipping_method" class="section allow active">
                <div class="step-title"> <span class="number">2</span>
                  <h3 class="one_page_heading"> Cart Preview </h3>
                </div>
                <div id="checkout-step-shipping_method" class="step a-item">
                  <form id="co-shipping-method-form" action="#">


                    <div id="onepage-checkout-shipping-method-additional-load">

                      <!-- BEGIN CART COLLATERALS -->
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="totals">
                            <h3>Checkout Preview</h3>
                            <div class="inner">
                              <table id="shopping-cart-totals-table" class="table shopping-cart-table-total">
                                <tbody>
                                  <tr>
                                    <td class="a-left" colspan="1"> Subtotal </td>
                                    <td class="a-right">
                                      <span class="price">{{\App\CPU\Helpers::currency_converter($sub_total)}}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="a-left" colspan="1"> Tax </td>
                                    <td class="a-right">
                                      <span class="price">{{\App\CPU\Helpers::currency_converter($total_tax)}}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="a-left" colspan="1"> Shipping Fee </td>
                                    <td class="a-right">
                                      <span class="price">{{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}</span>
                                    </td>
                                  </tr>
                                  @if(session()->has('coupon_discount'))
                                  <tr>
                                    <td class="a-left" colspan="1"> Discount on Product </td>
                                    <td class="a-right">
                                      <span class="price"> - {{ ($coupon_dis = session()->has('coupon_discount')) ?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}} </span>
                                    </td>
                                  </tr>
                                  @else
                                  <tr>
                                    <td class="a-left" colspan="1"> Discount on Product </td>
                                    <td class="a-right">
                                      <span class="price"> - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}</span>
                                    </td>
                                  </tr>
                                  @php($coupon_dis=0)
                                  @endif
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td class="a-left" colspan="1">
                                      <strong>Grand Total</strong>
                                    </td>
                                    <td class="a-right">
                                      <strong><span class="price">{{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}</span></strong>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                            <!--inner-->
                          </div>
                          <!--totals-->
                        </div>
                        <!--col-sm-4-->
                      </div>
                      <!--cart-collaterals-->

                    </div>
                    <div class="buttons-set" id="shipping-method-buttons-container">
                      <button type="button" class="button continue" onClick="proceed_to_next()"><span>Continue</span></button>
                      <a href="#" onClick="window.history.back(); return false;"><small> « </small>Back</a>
                      <span id="shipping-method-please-wait" class="please-wait" style="display:none;">
                        <img src="{{ asset('home/images/opc-ajax-loader.gif') }}" alt="Loading next step..." class="v-middle"> Loading next step...
                      </span>
                    </div>
                  </form>
                </div>
              </li>
              <li id="opc-payment" class="section">
                <div class="step-title"> <span class="number">3</span>
                  <h3 class="one_page_heading"> Payment Information</h3>
                </div>
              </li>
              <li id="opc-review" class="section">
                <div class="step-title"> <span class="number">4</span>
                  <h3 class="one_page_heading"> Order Review</h3>
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
    location.href = '{{ route("checkout-payment") }}';
  }


  function proceed_to_next() {
    location.href = '{{ route("checkout-payment") }}';
  }
</script>
@endpush