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
            <div class="welcome-msg">
              <p class="hello h4">Hello {{ session()->get('_user')->l_name }},</p>
              <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account
                activity and update your account information. Select a link below to view or edit information.</p>
            </div>
            <div class="recent-orders">
              <div class="title-buttons"> <strong>Recent Orders</strong> <?php /* <a href="#">View All</a> */ ?></div>
              <div class="table-responsive">
                <table class="data-table table-striped" id="my-orders-table">

                  <thead>
                    <tr class="first last">
                      <th>{{ __('Order#') }} </th>
                      <th>{{ __('Seller') }}</th>
                      <th>{{ __('Order')}} {{ __('Date') }}</th>
                      <th><span class="nobr">{{ __('Order') }} {{ __('Total') }}</span></th>
                      <th> {{ __('Status') }}</th>
                      <!-- <th>Status</th> -->
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($orders as $order)
                    <tr class="first odd">
                      @if($order['id']>0)
                      <td class="bodytr font-weight-bold">
                        {{ __('ID')}}: {{$order['id']}}
                      </td>
                      <td class="sellerName">
                        <span class="">
                          {{ $order->sellerName ? $order->sellerName->seller ? $order->sellerName->seller->f_name. ' '.$order->sellerName->seller->l_name : "Not Set" : "Not Set" }}
                        </span>
                      </td>
                      <td class="bodytr orderDate"><span class="">{{$order['created_at']}}</span></td>
                      <td class="bodytr">
                        @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                        <span class="badge badge-danger" style="padding: 10px">
                          {{$order['order_status']}}
                        </span>
                        <a style="margin: 10px" href="{{route('customer.payment-mobile',['order_id'=>$order['id'],'customer_id'=>auth('customer')->id()])}}" class="btn btn-secondary btn-sm">Pay Now</a>
                        @else
                        <span class="badge badge-info" style="padding: 10px">
                          {{$order['order_status']}}
                        </span>
                        @endif
                      </td>
                      <td class="bodytr">
                        {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}
                      </td>
                      <td class="bodytr">
                        <a href="{{ route('account-order-details', ['id'=>$order->id]) }}" class="btn btn-primary p-2">
                          <i class="lni lni-eye"></i>
                        </a>
                      </td>
                      @else

                      <td></td>
                      <td></td>
                      <td>
                        <center class="mt-3 mb-2"> NO Order Found</center>

                      </td>
                      <td></td>
                      <td></td>

                      @endif
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6">
                        <h3 style="text-align: center">No Orders Yet. Kindly Place Order to get started!</h3>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="row">
                {{ $orders->render('pagination') }}
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
  .lni {
    size: 24px;
  }
</style>
@stop