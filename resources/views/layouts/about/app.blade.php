<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? "Scudin" }}</title>
  <!-- Latest compiled and minified CSS -->
  <?php $fav_logo = \App\Model\BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0] ?>
  <link rel="icon" href="{{ asset($fav_logo) }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset($fav_logo) }}" type="image/x-icon">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('style/style1.css') }}">
  <link rel="stylesheet" href="{{ asset('style/main.css') }}">
  <style>
    html,
    body {
      max-width: 100%;
      overflow-x: hidden;
    }

    ._level-top:hover {
      color: #ccc;
    }
  </style>
</head>
<body style="background-color: #fff;">
  @include('layouts.header')
  <!-- Nav-xshop -->
  <a name="top" hidden></a>
  <section>
    @yield('content')
  </section>
  @include('layouts.about.footer')

  @include('message')
  @include('layouts.js')
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>

</html>