@extends('layouts.backend')

@section('title','Dashboard')


@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="page-header pb-2">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">{{__('Dashboard')}}</h1>
            </div>
            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{route('seller.product.list')}}">
                    <i class="tio-premium-outlined mr-1"></i> {{__('Products')}}
                </a>
            </div>
        </div>
    </div>
    @php
    $array=[];
    for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\OrderDetail::where(['seller_id'=> auth('seller')->id()])->whereBetween('created_at', [$from, $to])->count();
        }
        @endphp


        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="{{route('seller.orders.list',['pending'])}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">Pending Orders</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                @php
                                $pendingOrder = \App\Model\OrderDetail::where(['seller_id' => auth('seller')->id()])
                                ->where(['delivery_status'=>'pending'])
                                ->get()->count();

                                @endphp
                                <span class="card-title h2"> {{$pendingOrder}}</span>
                            </div>
                        </div>
                        <!-- End Row -->

                        <span class="badge badge-success">
                            <i class="tio-trending-up"></i> Jan - Dec
                        </span>
                    </div>
                </a>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                @php
                $array=[];
                for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\OrderDetail::where(['seller_id'=> auth('seller')->id()])->where(['delivery_status'=>'delivered'])->whereBetween('created_at', [$from, $to])->count();
                    }
                    @endphp
                    <a class="card card-hover-shadow h-100" href="{{route('seller.orders.list',['delivered'])}}">
                        <div class="card-body">
                            <h6 class="card-subtitle">{{__('Delivered')}}</h6>

                            <div class="row align-items-center gx-2 mb-1">
                                <div class="col-12">
                                    @php
                                    $deliveredOrder= \App\Model\OrderDetail::where(['seller_id' => auth('seller')->id()])
                                    ->where(['delivery_status'=>'delivered'])
                                    ->get()->count();
                                    @endphp
                                    <span class="card-title h2">{{$deliveredOrder}}</span>
                                </div>
                            </div>
                            <!-- End Row -->

                            <span class="badge badge-success">
                                <i class="tio-trending-up"></i> Jan - Dec
                            </span>
                        </div>
                    </a>
                    <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                @php
                $array=[];
                for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\OrderDetail::where(['seller_id'=> auth('seller')->id()])->where(['delivery_status'=>'returned'])->whereBetween('created_at', [$from, $to])->count();
                    }
                    @endphp
                    <a class="card card-hover-shadow h-100" href="{{route('seller.orders.list',['returned'])}}">
                        <div class="card-body">
                            <h6 class="card-subtitle">{{__('Returned')}}</h6>

                            <div class="row align-items-center gx-2 mb-1">
                                <div class="col-12">
                                    @php
                                    $returnedOrder= \App\Model\OrderDetail::where(['seller_id' => auth('seller')->id()])
                                    ->where(['delivery_status'=>'returned'])
                                    ->get()->count();

                                    @endphp
                                    <span class="card-title h2">{{$returnedOrder}}</span>
                                </div>
                            </div>
                            <!-- End Row -->
                            <span class="badge badge-warning">
                                <i class="tio-trending-down"></i> Jan - Dec
                            </span>
                        </div>
                    </a>
                    <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                @php
                $array=[];
                for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\OrderDetail::where(['seller_id'=> auth('seller')->id()])->where(['delivery_status'=>'failed'])->whereBetween('created_at', [$from, $to])->count();
                    }
                    @endphp
                    <a class="card card-hover-shadow h-100" href="{{route('seller.orders.list',['failed'])}}">
                        <div class="card-body">
                            <h6 class="card-subtitle">{{__('Failed')}}</h6>

                            <div class="row align-items-center gx-2 mb-1">
                                <div class="col-12">
                                    @php
                                    $failedOrder= \App\Model\OrderDetail::where(['seller_id' => auth('seller')->id()])
                                    ->where(['delivery_status'=>'failed'])
                                    ->get()->count();

                                    @endphp
                                    <span class="card-title h2">{{$failedOrder}}</span>
                                </div>
                            </div>
                            <!-- End Row -->

                            <span class="badge badge-danger">
                                <i class="tio-trending-down"></i> Jan - Dec
                            </span>
                        </div>
                    </a>
                    <!-- End Card -->
            </div>

        </div>

        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 for-card col-md-6 mb-4" style="cursor: pointer">
                <div class="card for-card-body-2 shadow h-100  badge-primary ">
                    <a href="javascript:" data-toggle="modal" data-target="#balance-modal">
                        <div class="card-body text-light">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold  text-uppercase for-card-text mb-1">
                                        {{__('balance')}} ( Withdraw )
                                    </div>
                                    @php
                                    $wallet = \App\Model\SellerWallet::where('seller_id',auth('seller')->id())->first();
                                    if(isset($wallet)==false){
                                    \Illuminate\Support\Facades\DB::table('seller_wallets')->insert([
                                    'seller_id'=>auth('seller')->id(),
                                    'balance'=>0,
                                    'withdrawn'=>0,
                                    'created_at'=>now(),
                                    'updated_at'=>now()
                                    ]);
                                    $wallet = \App\Model\SellerWallet::where('seller_id',auth('seller')->id())->first();
                                    }
                                    @endphp
                                    <div class="for-card-count">{{ \App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\Convert::default($wallet->balance), 2)}}</div>
                                </div>
                                <div class="col-auto  for-margin">
                                    <i class="fa fa-money-bill fa-2x for-fa-2 text-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 for-card col-md-6 mb-4" style="cursor: pointer">
                <div class="card  shadow h-100 for-card-body-3  badge-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class=" font-weight-bold for-card-text text-uppercase mb-1">{{__('withdrawn')}}</div>
                                <div class="for-card-count">{{ \App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\Convert::default($wallet->withdrawn), 2) }}</div>
                            </div>
                            <div class="col-auto for-margin">
                                <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 for-card col-md-6 mb-4" style="cursor: pointer">
                <div class="card r shadow h-100 for-card-body-4  badge-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class=" for-card-text font-weight-bold  text-uppercase mb-1">{{__('total_earning')}}</div>
                                <div class="for-card-count">{{ \App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\Convert::default($wallet->balance+$wallet->withdrawn ), 2)}}</div>
                            </div>
                            <div class="col-auto for-margin">
                                <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Withdraw Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('seller.withdraw.request')}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Amount:</label>
                                <input type="number" name="amount" value="{{\App\CPU\BackEndHelper::usd_to_currency($wallet->balance)}}" class="form-control" id="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @if(auth('seller')->user()->account_no==null || auth('seller')->user()->bank_name==null)
                            <button type="button" class="btn btn-primary" onclick="call_duty()">Incomplete bank info</button>
                            @else
                            <button type="submit" class="btn btn-primary">Request</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-12 mb-3 mb-lg-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    @php
                    $array=[];
                    for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\OrderDetail::where('seller_id',auth('seller')->id())->where(['delivery_status'=>'delivered'])->whereBetween('created_at', [$from, $to])->sum('price');
                        }
                        @endphp
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm mb-2 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        @php($this_month=\App\Model\OrderDetail::where('seller_id',auth('seller')->id())->where(['delivery_status'=>'delivered'])->whereBetween('updated_at', [date('Y-m-01'), date('Y-m-30')])->sum('price'))
                                        @php($amount=0)
                                        <span class="h1 mb-0">@foreach($array as $ar)@php($amount+=$ar)@endforeach{{\App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\BackEndHelper::usd_to_currency($amount), 2)}}</span>
                                        <span class="text-success ml-2">
                                            @php($amount=$amount!=0?$amount:0.01)
                                            <i class="tio-trending-up"></i> {{round(($this_month/$amount)*100)}} %
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-auto align-self-sm-end">
                                    <!-- Legend Indicators -->
                                    <div class="row font-size-sm">
                                        <div class="col-auto">
                                            <h5 class="card-header-title">Monthly Earning</h5>
                                        </div>
                                    </div>
                                    <!-- End Legend Indicators -->
                                </div>
                            </div>
                            <!-- End Row -->

                            <!-- Bar Chart -->
                            <div class="chartjs-custom">
                                <canvas id="updatingData" style="height: 20rem;"></canvas>
                            </div>
                            <!-- End Bar Chart -->
                        </div>
                        <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>

        <!-- Content Row -->
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Withdraw Request Table')}}</h5>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{__('SL#')}}</th>
                                        <th>{{__('amount')}}</th>
                                        <th>{{__('note')}}</th>
                                        <th>{{__('request_time')}}</th>
                                        <th>{{__('status')}}</th>
                                        <th style="width: 5px">Close</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdraw_req as $k=>$wr)
                                    <tr>
                                        <td scope="row">{{$k+1}}</td>
                                        <td>{{\App\CPU\Convert::default($wr['amount'])}}</td>
                                        <td>{{$wr->transaction_note}}</td>
                                        <td>{{$wr->created_at}}</td>
                                        <td>
                                            @if($wr->approved==0)
                                            <label class="badge badge-primary">Pending</label>
                                            @elseif($wr->approved==1)
                                            <label class="badge badge-success">Approved</label>
                                            @else
                                            <label class="badge badge-danger">Denied</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($wr->approved==0)
                                            {{-- <a href="{{route('seller.withdraw.close',[$wr['id']])}}"
                                            class="btn btn-danger btn-sm">
                                            {{__('Delete')}}
                                            </a> --}}
                                            <a class="btn btn-danger btn-sm" href="javascript:" onclick="form_alert('withdraw-{{$wr->id}}','Want to delete this  ?')">{{__('Delete')}}</a>
                                            <form action="{{route('seller.withdraw.close',[$wr['id']])}}" method="post" id="withdraw-{{$wr['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                            @else
                                            <label>complete</label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$withdraw_req->render('pagination')}}
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>

<script>
    var
        p = "#836AF9",
        b = "#28dac6",
        c = "#ffe802",
        u = "#2c9aff",
        h = "#84D0FF",
        y = "#EDF1F4",
        g = "rgba(0, 0, 0, 0.25)",
        w = "#666ee8",
        f = "#ff4961",
        x = "#6e6b7b",
        k = "rgba(200, 200, 200, 0.2)";
    var url = "{{route('chart.seller.day_based')}}";
    var Datee = new Array();
    var total = new Array();
    var quantity = new Array();
    $(document).ready(function() {
        $.get(url, function(response) {
            response.orders.forEach(function(data) {
                Datee.push(data.date);
                total.push(data.total);
                quantity.push(data.quantity)
            });
            console.log(total)
            var ctx = document.getElementById("updatingData");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Datee,
                    datasets: [{
                        label: 'Order Quantity',
                        data: quantity,
                        borderColor: p,
                        lineTension: 0.5,
                        pointStyle: "circle",
                        backgroundColor: f,
                        fill: !1,
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: "transparent",
                        pointHoverBorderColor: u,
                        pointHoverBackgroundColor: c,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: g,
                    }, {
                        label: 'Order Cost',
                        data: total,
                        borderColor: f,
                        lineTension: 0.5,
                        pointStyle: "circle",
                        backgroundColor: g,
                        fill: !1,
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: "transparent",
                        pointHoverBorderColor: u,
                        pointHoverBackgroundColor: g,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: p,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                        }
                    }
                }
            });
        });
    });
</script>


@endsection

@push('js')
<script src="{{asset('assets/back-end')}}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush
