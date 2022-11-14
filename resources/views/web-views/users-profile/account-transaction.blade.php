@extends('layouts.home.app')
@section('title', 'Transaction History')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Transaction History</h2>
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
            <div class="box-shadow-sm">
              <div style="overflow: auto">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr style="background: <?= $web_config['secondary_color'] ?>">
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO ">{{ __('Tranx')}} {{ __('ID')}}</span></div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2 ml-2"><span class="d-block spandHeadO ">{{ __('payment_method')}}</span></div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO">{{ __('Status')}} </span></div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO"> {{ __('Total')}}</span></div>
                      </td>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($transactionHistory as $history)
                    <tr>
                      <td class="bodytr font-weight-bold" style="color: #92C6FF;"><span class="marl">{{$history['id']}}</span></td>
                      <td class="sellerName bodytr "><span class="">{{$history['payment_method']}}</span></td>
                      <td class="bodytr"><span class="">{{$history['payment_status']}}</span>
                      </td>
                      <td class="bodytr"><span class=" amount ">{{\App\CPU\Helpers::currency_converter($history->order->order_amount)}}</span></td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="4" class="text-center">
                        <h3>Transaction History is Empty</h3>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
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