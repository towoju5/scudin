@extends('layouts.home.app')
@section('title', 'Checkout')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Order Placement Successful</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<section class="main-container col2-right-layout">
  <div class="main-container col2-right-layout">
    <div class="main container panel">
      <div class="row">
        <div class="panel-body">
          @if(auth('customer')->check())
          <div class=" p-5">
            <div class="row">
              <div class="col-md-6">
                <h5 style="font-size: 20px; font-weight: 900">{{ __('your_order_confirm')}}
                  !</h5>
              </div>
              <div class="col-md-6 ">
                <p class="float-right">{{ __('Order')}} {{ __('No')}} :
                  <strong>{{$order_id}}</strong>
                </p>
              </div>
            </div>

            <span class="font-weight-bold d-block mt-4" style="font-size: 17px;">{{ __('Hello')}}, {{auth('customer')->user()->f_name}}</span>
            <span>Your order has been confirmed and will be shipped according to the method you selected!</span>
            @php($order=\App\Model\Order::with(['details'])->where('id',$order_id)->first())

            <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
              <table class="table table-borderless">
                <tbody>
                  <tr style="background: #E2F0FF">
                    <td col="3">
                      <div class="py-2">
                        <span class="d-block spandHeadO">{{ __('shipping_address')}}: </span>
                        <span class="spanTr">{{ $order->address }}</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-6 table-responsive" style="float: left;">
              <table class="data-table table-striped" id="my-orders-table">
                <tbody>
                  @php($sub_total=0)
                  @php($total_tax=0)
                  @php($total_shipping_cost=0)
                  @php($total_discount_on_product=0)
                  @foreach($order->details as $detail)
                  <tr>
                    <div class="row">
                      <div>
                        <td>
                          <img src="{{ asset($detail->product->thumbnail) }}" width="100">
                        </td>
                        <td>
                          <span class="font-name">{{$detail->product['name']}}
                          </span>
                          <br>
                          <small>
                            QTY : {{$detail['qty']}}
                          </small>
                          <div class="product-qty">
                            @foreach(json_decode($detail['variation'],true) as $key1 =>$variation)
                            <div class="text-muted">
                              <span class="d-block">{{$key1}} : {{$variation}} </span>
                            </div>
                            @endforeach
                          </div>
                        </td>
                        <td>
                          <div class="text-right"><span class="font-weight-bold amount">{{\App\CPU\Helpers::currency_converter($detail['price'])}}</span>
                          </div>
                        </td>
                      </div>
                    </div>
                  </tr>
                  @php($sub_total+=$detail['price']*$detail['qty'])
                  @php($total_tax+=$detail['tax'])
                  @php($total_shipping_cost+=$detail->shipping->cost)
                  @php($total_discount_on_product+=$detail['discount'])
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="col-md-6" style="float: right;">
              <div class="panel">
                <table class="table table-borderless">
                  <tbody class="totals">
                    <tr>
                      <td>
                        <div class="text-left">
                          <span class="product-qty ">{{ __('Items')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right"><span>{{$order->details->count()}}</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="text-left"><span class="product-qty ">{{ __('Subtotal')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right">
                          <span>{{\App\CPU\Helpers::currency_converter($sub_total)}}</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="text-left"><span class="product-qty ">{{ __('text_fee')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right">
                          <span>{{\App\CPU\Helpers::currency_converter($total_tax)}}</span>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="text-left"><span class="product-qty ">{{ __('Shipping')}} {{ __('Fee')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right">
                          <span>{{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}</span>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="text-left"><span class="product-qty ">{{ __('Discount')}} {{ __('on_product')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right">
                          <span>- {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}</span>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="text-left"><span class="product-qty ">{{ __('Coupon')}} {{ __('Discount')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right">
                          <span>- {{\App\CPU\Helpers::currency_converter($order->discount_amount)}}</span>
                        </div>
                      </td>
                    </tr>

                    <tr class="border-top border-bottom">
                      <td>
                        <div class="text-left"><span class="font-weight-bold">{{ __('Total')}}</span>
                        </div>
                      </td>
                      <td>
                        <div class="text-right"><span class="font-weight-bold amount ">{{\App\CPU\Helpers::currency_converter($order->order_amount)}}</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <p> {{ __('shipping_confirmation_email')}}!</p>

            <p class="font-weight-bold mb-2">{{ __('thanks_for_shopping_with')}}!</p>
            <br>

            <div class="row" style="padding: 0 10px 0 10px;">
              <div style="float: left;">
                <a href="{{route('home')}}" class="btn btn-primary">
                  {{ __('go_to_shopping')}}
                </a>
              </div>

              <div style="float: right;">
                <a href="{{route('track-order.last')}}" class="btn btn-secondary pull-right">
                  {{ __('Track')}} {{ __('Order')}}
                </a>
              </div>
            </div>
          </div>
          @else
          <center>
            <h5>Order Complete</h5>
          </center>
          @endif
        </div>
      </div>
      <!--row-->
    </div>
    <!--main-container-inner-->
  </div>
</section>
@stop

@push('js')

@endpush