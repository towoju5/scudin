@extends('layouts.backend')

@section('title', 'Sales Report')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/charts/chart-apex.css">
<!-- END: Page CSS-->
@endsection

@section('content')
<section class="app-user-list">
  <div class="row match-height">
    <!-- Medal Card -->
    <div class="col-xl-3 col-md-6 col-12">
      <div class="card card-congratulation-medal">
        <div class="card-body">
          <h5>{{ @$shop->shop_name }}</h5>
          <p class="card-text font-small-3">All Time Sales</p>
          <h3 class="mb-75 mt-2 pt-50">
            <a href="javascript:void(0);">{{ $all_time }}</a>
          </h3>
          <a href="{{ route('seller.orders.list',['all']) }}"><button type="button" class="btn btn-primary">View
              Orders</button></a>
          <!-- <img src="{{ url('/') }}/app-assets/images/illustration/badge.svg" class="congratulation-medal" alt="Medal Pic" /> -->
        </div>
      </div>
    </div>
    <!--/ Medal Card -->

    <!-- Statistics Card -->
    <div class="col-xl-9 col-md-6 col-12">
      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title"><strong>{{ @$shop->shop_name }}</strong> Sales History</h4>
          <div class="d-flex align-items-center">
            <!-- <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p> -->
          </div>
        </div>
        <div class="card-body statistics-body">
          <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-primary mr-1">
                  <div class="avatar-content">
                    <i data-feather="trending-up" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{ $today }}</h4>
                  <p class="card-text font-small-3 mb-0">Today's sales</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-info mr-1">
                  <div class="avatar-content">
                    <i data-feather="user" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{ $week }}</h4>
                  <p class="card-text font-small-3 mb-0">Last 7days</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
              <div class="media">
                <div class="avatar bg-light-danger mr-1">
                  <div class="avatar-content">
                    <i data-feather="box" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{ $month }}</h4>
                  <p class="card-text font-small-3 mb-0">Last 30days</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="media">
                <div class="avatar bg-light-success mr-1">
                  <div class="avatar-content">
                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{ $year }}</h4>
                  <p class="card-text font-small-3 mb-0">Last 365days</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Card -->
  </div>
  <div class="row match-height">
    <!--Bar Chart Start -->
    <div class="col-xl-6 col-12">
      <div class="card">
        <div
          class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
          <div class="header-left">
            <h4 class="card-title">Latest Statistics</h4>
          </div>
        </div>
        <div class="card-body">
          <canvas id="canvas" height="280" width="600"></canvas>
        </div>
      </div>
    </div>
    <!-- Bar Chart End -->

    <!-- Heatmap Chart Starts -->
    <div class="col-xl-6 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Daily Sales States</h4>
        </div>
        <div class="card-body">
          <div id="heatmap-chart"></div>
        </div>
      </div>
    </div>
    <!-- Heatmap Chart Ends -->
  </div>
</section>

<script src="{{ url('/') }}/app-assets/vendors/js/charts/chart.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="{{ url('/') }}/app-assets/js/scripts/charts/chart-chartjs.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/charts/apexcharts.min.js"></script>

<script>
var chartWrapper = $('.chartjs'),
    flatPicker = $('.flat-picker'),
    barChartEx = $('.bar-chart-ex'),
    horizontalBarChartEx = $('.horizontal-bar-chart-ex'),
    lineChartEx = $('.line-chart-ex'),
    radarChartEx = $('.radar-chart-ex'),
    polarAreaChartEx = $('.polar-area-chart-ex'),
    bubbleChartEx = $('.bubble-chart-ex'),
    doughnutChartEx = $('.doughnut-chart-ex'),
    scatterChartEx = $('.scatter-chart-ex'),
    lineAreaChartEx = $('.line-area-chart-ex');

  // Color Variables
  var primaryColorShade = '#836AF9',
    yellowColor = '#ffe800',
    successColorShade = '#28dac6',
    warningColorShade = '#ffe802',
    warningLightColor = '#FDAC34',
    infoColorShade = '#299AFF',
    greyColor = '#4F5D70',
    blueColor = '#2c9aff',
    blueLightColor = '#84D0FF',
    greyLightColor = '#EDF1F4',
    tooltipShadow = 'rgba(0, 0, 0, 0.25)',
    lineChartPrimary = '#666ee8',
    lineChartDanger = '#ff4961',
    labelColor = '#6e6b7b',
    grid_line_color = 'rgba(200, 200, 200, 0.2)'; // RGBA color helps in dark layout

  // Detect Dark Layout
  if ($('html').hasClass('dark-layout')) {
    labelColor = '#b4b7bd';
  }

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
  var Status = new Array();
  var quantity = new Array();
  $(document).ready(function () {
    $.get(url, function (response) {
      response.orders.forEach(function (data) {
        Datee.push(data.date);
        Status.push(data.total);
        quantity.push(data.quantity)
      });
      var ctx = document.getElementById("canvas");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: Datee,
          datasets: [{
            label: 'Orders By Date',
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
          }]
        },
        type: 'bar',
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
              borderSkipped: 'bottom'
            }
          },
          responsive: true,
          maintainAspectRatio: false,
          responsiveAnimationDuration: 500,
          legend: {
            display: false
          },
          tooltips: {
            // Updated default tooltip UI
            shadowOffsetX: 1,
            shadowOffsetY: 1,
            shadowBlur: 8,
            shadowColor: tooltipShadow,
            backgroundColor: window.colors.solid.white,
            titleFontColor: window.colors.solid.black,
            bodyFontColor: window.colors.solid.black
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true,
                  color: grid_line_color,
                  zeroLineColor: grid_line_color
                },
                scaleLabel: {
                  display: false
                },
                ticks: {
                  fontColor: labelColor
                }
              }
            ],
            yAxes: [
              {
                display: true,
                gridLines: {
                  color: grid_line_color,
                  zeroLineColor: grid_line_color
                },
                ticks: {
                  stepSize: 100,
                  min: 0,
                  max: 400,
                  fontColor: labelColor
                }
              }
            ]
          }
        },
      });
    });
  });
</script>
@endsection
