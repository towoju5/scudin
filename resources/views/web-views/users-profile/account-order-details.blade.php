@extends('layouts.home.app')
@section('title', 'My orders')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>My orders</h2>
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
            <div class="recent-orders">
              <div class="title-buttons"> <strong>Recent Orders</strong> <?php /* <a href="#">View All</a> */ ?></div>
              <div class="table-responsive">
                @if (isset($order['seller_id']) != 0)
                @php($shopName=\App\Model\Shop::where('seller_id', $order['seller_id'])->first())
                @endif
                <table class="data-table table-striped" id="my-orders-table">
                  <thead>
                    <tr class="first last">
                      <th>{{ __('Order#') }} </th>
                      <th>{{ __('order_date') }}</th>
                      <th> {{ __('shipping_address') }}</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="first odd">
                      <td class="bodytr font-weight-bold">
                        {{ __('ID')}}: {{ $order->id }}
                      </td>
                      <td class="bodytr orderDate"><span class=""> {{ date('d M, Y',strtotime($order->created_at)) }} </span></td>
                      <td class="bodytr">
                        {{ $order->address }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="col-md-7">
                  <table class="table table-borderless">
                    <tbody>
                      @php($sub_total=0)
                      @php($total_tax=0)
                      @php($total_shipping_cost=0)
                      @php($total_discount_on_product=0)

                      @foreach ($order_details as $key=>$detail)
                      @php($product=json_decode($detail->product_details,true))
                      <tr>
                        <div class="row">
                          <?php $link = route('product', $product['slug']) ?>
                          <div class="col-md-6" onclick="location.href='{{ $link }}'">
                            <td width="30%" class="for-tab-img">
                              <img class="d-block main_banner_img" src="{{ asset('storage/app/public/product/'.$product['thumbnail']) }}" alt="{{ $product['name'] }}" width="60">
                            </td>
                            <td width="60%" class="for-glaxy-name">
                              <a href="{{route('product',[$product['slug']])}}">{{isset($product['name']) ? $product['name'] : ''}}</a>
                            </td>
                          </div>
                          <td width="20%">
                            <span class="font-weight-bold amount text-capitalize">{{$detail->delivery_status}}</span> {{--if order table changed then change the status--}}
                          </td>
                          <div class="col-md-6">
                            <td width="20%">
                              <div class="text-right">
                                <span class="font-weight-bold amount">{{\App\CPU\Helpers::currency_converter($detail->price)}} </span>
                                <br>
                                <span>qty: {{$detail->qty}}</span>
                              </div>
                            </td>
                          </div>
                        </div>
                        <td>
                          @if($order->order_status=='delivered')
                          <a href="javascript:" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#review-{{$detail->id}}">Review</a>
                          @else
                          <a href="javascript:" class="btn btn-primary btn-sm disabled">Review {{$order->order_status}}</a>
                          @endif
                        </td>
                      </tr>
                      @php($sub_total+=$detail->price*$detail->qty)
                      @php($total_tax+=$detail->tax)
                      @php($total_shipping_cost+=$detail->cost)
                      @php($total_discount_on_product+=$detail->discount)
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-5">
                  {{-- Calculation --}}
                  <div class="row d-flex justify-content-end">
                    <div class="col-md-12">
                      <table class="table table-borderless">
                        <tbody class="totals">
                          <tr>
                            <td>
                              <div class="text-left"><span class="product-qty ">{{ __('Item')}}</span></div>
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
                </div>
                <div class="justify-content mt-4 for-mobile-glaxy" style="width: 100%;">
                  <a href="{{route('generate-invoice',[$order->id])}}" class="btn btn-primary for-glaxy-mobile" style="width:49%;">
                    {{ __('generate_invoice')}}
                  </a>
                  <a id="track_order" class="btn btn-secondary" type="button" style="width:50%;">
                    {{ __('Track')}} {{ __('Order')}}
                  </a>

                </div>
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
<!-- Modal -->
@foreach ($order_details as $key=>$detail)
@if($detail->delivery_status=='delivered')
@php($product=json_decode($detail->product_details,true))
<div class="modal fade" id="review-{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          {{$product['name']}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('review.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Rating</label>
            <select class="form-control" name="rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Comment</label>
            <input name="product_id" value="{{$detail->product_id}}" hidden>
            <input name="order_id" value="{{ $order->id }}" hidden>
            <textarea class="form-control" name="comment"></textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Attachment</label>
            <div class="row" id="coba"></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit Review</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endforeach
@stop

@push('js')
<script>
  $(document).ready(function() {

    $('#track_order').on('click', function() {
      let order_id, phone_number;
      order_id = "{{$order->id}}";
      phone_number = "{{$order->customer_phone}}";

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{route('track-order.result')}}",
        method: 'POST',
        data: {
          order_id: order_id,
          phone_number: phone_number,
        },
        success: function() {
          var url = "{{route('track-order.result-view')}}" + '?order_id=' + '{{$order->id}}' +
            '&phone_number=' + '{{$order->customer_phone}}';
          window.location.href = url;
        }
      });
    })
  })
</script>

<script src="{{asset('assets/front-end/js/spartan-multi-image-picker.js')}}"></script>
<script type="text/javascript">
  $(function() {
    $("#coba").spartanMultiImagePicker({
      fieldName: 'fileUpload[]',
      maxCount: 5,
      rowHeight: '150px',
      groupClassName: 'col-md-4',
      maxFileSize: '',
      placeholderImage: {
        image: "{{asset('assets/front-end/img/image-place-holder.png')}}",
        width: '100%'
      },
      dropFileLabel: "Drop Here",
      onAddRow: function(index, file) {

      },
      onRenderedPreview: function(index) {

      },
      onRemoveRow: function(index) {

      },
      onExtensionErr: function(index, file) {
        toastr.error('Please only input png or jpg type file', {
          CloseButton: true,
          ProgressBar: true
        });
      },
      onSizeErr: function(index, file) {
        toastr.error('File size too big', {
          CloseButton: true,
          ProgressBar: true
        });
      }
    });
  });
</script>
@endpush