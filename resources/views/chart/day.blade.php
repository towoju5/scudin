<!-- index.blade.php -->

<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">
</head>

<body>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading"><b>Charts</b></div>
        <div class="panel-body">
          <canvas id="canvas" height="280" width="600"></canvas>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
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
    });
  </script>
</body>

</html>