@extends('layouts.backend')

@section('title', 'Deliveries')

@section('css')
<!-- BEGIN: Page CSS-->
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/calendars/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/app-calendar.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<!-- END: Vendor CSS-->
<!-- END: Page CSS-->
@endsection

@section('content')
<!-- Full calendar start -->
<section>
<style>
    .header-right {
        display: none;
    }
</style>
  <div class="card">
    <canvas id="canvas" height="280" width="600"></canvas>
  </div>
</section>
<!-- Full calendar end -->
@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
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
  var Status = new Array();
  var quantity = new Array();
  $(document).ready(function() {
    $.get(url, function(response) {
      response.orders.forEach(function(data) {
        Datee.push(data.date);
        Status.push(data.total);
        quantity.push(data.quantity)
      });
      console.log(Status)
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
    $(".header-right").remove();
  });
</script>
@endsection
