@extends('layouts.home.app')
@section('title', 'Order Tracking')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Order Tracking - {{$orderDetails['id']}}</h2>
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
            <?php
            $order = \App\Model\OrderDetail::where('order_id', $orderDetails->id)->get();
            ?>
            <div class="btn-primary">
              <div class=" d-lg-flex justify-content-between py-2 py-lg-3">

                <div class="order-lg-1 pr-lg-4 text-center text-lg-left" style="padding: 5px;">
                  <h4 class="text-light mb-0">Order ID : <span class="h4 font-weight-normal text-light">{{$orderDetails['id']}}</span></h4>
                </div>
              </div>
            </div>
            <!-- Page Content-->
            <div class="mb-md-3">
              <!-- Details-->
              <div class="row" style="background: #e2f0ff; margin: 0; width: 100%; padding: 5px;">
                <div class="col-sm-4">
                  <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">Order Status:</span><br>
                    <span class="text-uppercase ">{{$orderDetails['order_status']}}</span>
                    {{-- <span class="text-uppercase ">Courier</span> --}}
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">Payment Status:</span> <br>
                    <span class="text-uppercase">{{$orderDetails['payment_status']}}</span>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2"> Order Placed On: </span> <br>
                    <span class="text-uppercase" style="font-weight: 600; color: <?= $web_config['primary_color'] ?>">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$orderDetails['updated_at'])->format('Y-m-d')}}</span>
                  </div>
                </div>
              </div>
              <div class="modal-body pb-0">
                @php( $totalTax = 0)

                @php($sub_total=0)
                @php($total_tax=0)
                @php($total_shipping_cost=0)
                @php($total_discount_on_product=0)
                @foreach($order as $product)
                @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())
                @php($sub_total+=$product['price']*$product['qty'])
                @php($total_tax+=$product['tax'])
                @php($total_shipping_cost+=\App\Model\ShippingMethod::find($product['shipping_method_id'])->cost)
                @php($total_discount_on_product+=$product['discount'])

                <div class="row" style="padding-bottom: 15px;">
                  <div class="col-md-5">
                    <div style="float: left; padding: 10px">
                      <a class="d-inline-block mx-auto mr-sm-4" href="{{route('product',$productDetails->slug)}}" style="width: 10rem;">
                        <img src="{{ asset($productDetails->thumbnail) }}" width="50px" height="50px">
                      </a>
                    </div>
                    <div class="media-body pt-2">
                      <h4 class="product-title font-size-base mb-2"><a href="{{route('product',$productDetails->slug)}}">{{$productDetails['name']}}</a>
                      </h4>
                      @if($product['variation'])
                      @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                      <div class="text-muted"><span class="mr-2">{{$key1}} :</span>{{$variation}}</div>
                      @endforeach
                      @endif
                      <div class="font-size-lg text-accent pt-2">{{\App\CPU\Helpers::currency_converter($product['price'])}}</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="text-muted">Quantity: {{$product['qty']}}</div>
                    <div class="text-muted">Tax: {{\App\CPU\Helpers::currency_converter($product['tax'])}}
                    </div>
                    <div class="text-muted mb-2">Subtotal: {{\App\CPU\Helpers::currency_converter($product['price']*$product['qty'])}}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="px-2 py-1">
                      <span class="text-muted">Subtotal : &nbsp;&nbsp;{{\App\CPU\Helpers::currency_converter($sub_total)}}</span>
                      <span></span>
                    </div><?php /*
                    <div class="px-2 py-1">
                      <span class="text-muted">Shipping : &nbsp;&nbsp;{{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}</span>
                      <span></span>
                    </div> */ ?>
                    <div class="px-2 py-1">
                      <span class="text-muted">Tax : &nbsp;&nbsp;{{\App\CPU\Helpers::currency_converter($total_tax)}}</span>
                      <span></span>
                    </div>


                    <div class="px-2 py-1">
                      <span class="text-muted">Discount : &nbsp;&nbsp;</span>
                      - {{\App\CPU\Helpers::currency_converter($product['discount'])}}
                      <span></span>
                    </div>

                    <div class="px-2 py-1">
                      <span class="text-muted">Total : &nbsp;&nbsp; </span>
                      <span class="font-size-lg">
                        {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-($orderDetails->discount)-$total_discount_on_product)}}
                      </span>
                    </div>

                    @if($productDetails->product_type == 1)
                    <div class="px-2 py-1">
                      <a href="{{ $productDetails->download_url }}">
                        <button class="btn btn-primary"> Download Now </button>
                      </a>
                    </div>
                    @endif

                  </div>
                </div>
                <hr>
                @endforeach
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
@stop