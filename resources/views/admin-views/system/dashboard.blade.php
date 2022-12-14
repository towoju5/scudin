@extends('layouts.backend')

@section('title','Dashboard')

@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header pb-2">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">{{__('Dashboard')}}</h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{route('admin.product.list', 'in_house')}}">
                    <i class="tio-premium-outlined mr-1"></i> {{__('Products')}}
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    @php
    $array=[];
    for ($i=1;$i<=12;$i++){ 
        $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\Order::whereBetween('created_at', [$from, $to])->count();
    }
    @endphp
    <!-- Stats -->
    <div class="row gx-2 gx-lg-3">
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['status'=>'all'])}}">
                <div class="card-body">
                    <h6 class="card-subtitle">Total Orders</h6>

                    <div class="row align-items-center gx-2 mb-1">
                        <div class="col-6">
                            <span class="card-title h2">{{\App\Model\Order::all()->count()}}</span>
                        </div>

                        <div class="col-6">
                            <!-- Chart -->
                            <div class="chartjs-custom" style="height: 3rem;">
                                <canvas class="js-chart"></canvas>
                            </div>
                            <!-- End Chart -->
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
            for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\Order::where(['order_status'=>'delivered'])->whereBetween('created_at', [$from, $to])->count();
                }
                @endphp
                <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['status'=>'delivered'])}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">{{__('Delivered')}}</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{\App\Model\Order::where(['order_status'=>'delivered'])->count()}}</span>
                            </div>

                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem;">
                                    <canvas class="js-chart"></canvas>
                                </div>
                                <!-- End Chart -->
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
            for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\Order::where(['order_status'=>'returned'])->whereBetween('created_at', [$from, $to])->count();
                }
                @endphp
                <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['status'=>'returned'])}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">{{__('Returned')}}</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{\App\Model\Order::where(['order_status'=>'returned'])->count()}}</span>
                            </div>

                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem;">
                                    <canvas class="js-chart"></canvas>
                                </div>
                                <!-- End Chart -->
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
            for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\Order::where(['order_status'=>'failed'])->whereBetween('created_at', [$from, $to])->count();
                }
                @endphp
                <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['status'=>'failed'])}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">{{__('Failed')}}</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <span class="card-title h2">{{\App\Model\Order::where(['order_status'=>'failed'])->count()}}</span>
                            </div>

                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom" style="height: 3rem;">
                                    <!-- <canvas class="js-chart"></canvas> -->
                                </div>
                                <!-- End Chart -->
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
    <!-- End Stats -->
    <div class="row gx-2 gx-lg-3">
        <div class="col-lg-12 mb-3 mb-lg-12">
            <!-- Card -->
            <div class="card h-100">
                <!-- Body -->
                @php
                $array=[];
                for ($i=1;$i<=12;$i++){ $from=date('Y-'.$i.'-01'); $to=date('Y-'.$i.'-30'); $array[$i]=\App\Model\Order::where(['order_status'=>'delivered'])->whereBetween('created_at', [$from, $to])->sum('order_amount');
                    }
                    @endphp
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    @php($this_month=\App\Model\Order::where(['order_status'=>'delivered'])->whereBetween('updated_at', [date('Y-m-01'), date('Y-m-30')])->sum('order_amount'))
                                    @php($amount=0)
                                    <span class="h1 mb-0">@foreach($array as $ar)@php($amount+=$ar)@endforeach{{\App\CPU\BackEndHelper::currency_symbol().\App\CPU\BackEndHelper::usd_to_currency($amount)}}</span>
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

    <div class="row gx-2 gx-lg-3 mt-2">
        <div class="col-lg-6 mb-3 mb-lg-0">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4>{{__('bestsellings')}}</h4>
                </div>
                <div class="row">
                    @foreach($bestSellProduct as $key => $bestSell)
                    @if($bestSell->product)
                    <div class="col-4 pt-2" style="cursor: pointer">
                        <a href="{{route('product',$bestSell->product->slug)}}" target="_blank" style="text-decoration: none;
                                    color: #8f919f;">
                            <img style="vertical-align: middle;max-height: 100px" width="120" src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$bestSell->product['thumbnail']}}" alt="">
                            <div class="mt-3">
                                <p class="p-2"> {{strlen($bestSell->product['name']) > 10? substr($bestSell->product['name'], 0, 12).'...':$bestSell->product['name'] }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4>{{__('new_selling')}}</h4>
                </div>
                <div class="row">
                    @foreach($newSellingProduct as $key => $newSell)
                    @if($newSell->product)
                    <div class="col-4 pt-2" style="cursor: pointer">
                        <a href="{{route('product',$newSell->product->slug)}}" target="_blank" style="text-decoration: none;
                                    color: #8f919f;">
                            <img style="vertical-align: middle;max-height: 100px" width="120" src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$newSell->product['thumbnail']}}" alt="">
                            <div class="mt-3">
                                <p class="p-2"> {{strlen($newSell->product['name']) > 10? substr($newSell->product['name'], 0, 12).'...': $newSell->product['name']}}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
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
                                    {{-- <th>{{__('note')}}</th> --}}
                                    <th>{{__('request_time')}}</th>
                                    <th>{{__('status')}}</th>
                                    <th style="width: 5px">Close</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraw_req as $k=>$wr)
                                <tr>
                                    <td scope="row">{{$k+1}}</td>
                                    <td>{{\App\CPU\BackEndHelper::usd_to_currency($wr['amount'])}} {{\currency_symbol()}}</td>
                                    {{-- <td>{{$wr->transaction_note}}</td> --}}
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
                                        <a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}" class="btn btn-primary btn-sm">
                                            {{__('View')}}
                                        </a>
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

<script>
  var
    p = "#836AF9",
    b = "#28dac6",
    C = "#ffe802",
    u = "#2c9aff",
    h = "#84D0FF",
    y = "#EDF1F4",
    g = "rgba(0, 0, 0, 0.25)",
    w = "#666ee8",
    f = "#ff4961",
    x = "#6e6b7b",
    k = "rgba(200, 200, 200, 0.2)";
  var url = "{{route('chart.day_based')}}";
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
            pointHoverBackgroundColor: g,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: g,
          },{
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


@push('script_2')
<script>
    // INITIALIZATION OF CHARTJS
    // =======================================================
    Chart.plugins.unregister(ChartDataLabels);

    $('.js-chart').each(function() {
        $.HSCore.components.HSChartJS.init($(this));
    });

    var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

    // CALL WHEN TAB IS CLICKED
    // =======================================================
    $('[data-toggle="chart-bar"]').click(function(e) {
        let keyDataset = $(e.currentTarget).attr('data-datasets')

        if (keyDataset === 'lastWeek') {
            updatingChart.data.labels = ["Apr 22", "Apr 23", "Apr 24", "Apr 25", "Apr 26", "Apr 27", "Apr 28", "Apr 29", "Apr 30", "Apr 31"];
            updatingChart.data.datasets = [{
                    "data": [120, 250, 300, 200, 300, 290, 350, 100, 125, 320],
                    "backgroundColor": "#377dff",
                    "hoverBackgroundColor": "#377dff",
                    "borderColor": "#377dff"
                },
                {
                    "data": [250, 130, 322, 144, 129, 300, 260, 120, 260, 245, 110],
                    "backgroundColor": "#e7eaf3",
                    "borderColor": "#e7eaf3"
                }
            ];
            updatingChart.update();
        } else {
            updatingChart.data.labels = ["May 1", "May 2", "May 3", "May 4", "May 5", "May 6", "May 7", "May 8", "May 9", "May 10"];
            updatingChart.data.datasets = [{
                    "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220],
                    "backgroundColor": "#377dff",
                    "hoverBackgroundColor": "#377dff",
                    "borderColor": "#377dff"
                },
                {
                    "data": [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120],
                    "backgroundColor": "#e7eaf3",
                    "borderColor": "#e7eaf3"
                }
            ]
            updatingChart.update();
        }
    })


    // INITIALIZATION OF BUBBLE CHARTJS WITH DATALABELS PLUGIN
    // =======================================================
    $('.js-chart-datalabels').each(function() {
        $.HSCore.components.HSChartJS.init($(this), {
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    datalabels: {
                        anchor: function(context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.r < 20 ? 'end' : 'center';
                        },
                        align: function(context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.r < 20 ? 'end' : 'center';
                        },
                        color: function(context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.r < 20 ? context.dataset.backgroundColor : context.dataset.color;
                        },
                        font: function(context) {
                            var value = context.dataset.data[context.dataIndex],
                                fontSize = 25;

                            if (value.r > 50) {
                                fontSize = 35;
                            }

                            if (value.r > 70) {
                                fontSize = 55;
                            }

                            return {
                                weight: 'lighter',
                                size: fontSize
                            };
                        },
                        offset: 2,
                        padding: 0
                    }
                }
            },
        });
    });
</script>
@endpush