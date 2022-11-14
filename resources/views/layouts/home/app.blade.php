<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>@if(!empty($title)) @yield('title') - @endif Scudin.com: Online Shopping for Computers, Electronics, Automotive, Apparel, Books, Kitchen and more</title>
  <meta name="description" content="Default Description">
  <meta name="keywords" content="fashion, store, E-commerce">
  <meta name="robots" content="*">
  <?php $fav_logo = \App\Model\BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0] ?>
  <link rel="icon" href="{{ asset($fav_logo) }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset($fav_logo) }}" type="image/x-icon">

  <!-- CSS Style -->
  <link rel="stylesheet" href="{{ asset('style/style1.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/bootstrap.min.css') }} ">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/revslider.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/owl.carousel.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/owl.theme.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/jquery.bxslider.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/jquery.mobile-menu.css') }}">
  <link rel="stylesheet" href="{{ asset('style/main.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/style.css') }}" media="all">
  <link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/responsive.css') }}" media="all">
  <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css">
  <link href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}" rel="stylesheet">
  <script type="text/javascript" src="{{ asset('home/js/jquery.min.js') }}"></script>

  <link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700,800' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,400italic,700,800,900' rel='stylesheet' type='text/css'>

  <meta name="viewport" content="initial-scale=1.0, width=device-width">
  @stack('css')
  {{--dont touch this--}}
  <meta name="_token" content="{{csrf_token()}}">
  <style>
    .btn-primary {
      color: #fff;
      background-color: #3b71de !important;
      border-color: #3b71de !important;
    }

    .btn-secondary {
      color: #fff;
      background-color: #f58300 !important;
      border-color: #f58300 !important;
    }

    #loading {
      position: fixed;
      width: 100%;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background-color: rgba(255, 255, 255, 0.7);
      z-index: 9999;
      display: none;
    }

    @-webkit-keyframes spin {
      from {
        -webkit-transform: rotate(0deg);
      }

      to {
        -webkit-transform: rotate(360deg);
      }
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    #loading::after {
      content: '';
      display: block;
      position: absolute;
      left: 48%;
      top: 40%;
      width: 40px;
      height: 40px;
      border-style: solid;
      border-color: black;
      border-top-color: transparent;
      border-width: 4px;
      border-radius: 50%;
      -webkit-animation: spin .8s linear infinite;
      animation: spin .8s linear infinite;
    }
  </style>
</head>

<body>
  <div class="row">
    <div class="col-12">
      <div id="loading" style="display: none;">
      </div>
    </div>
  </div>

  <div id="page">
    @include('layouts.header')
    @yield('page_title')
    <div class="content">
      @yield('content')
    </div>
    @include('layouts.about.footer')
  </div>

  <!-- JavaScript -->
  <script type="text/javascript" src="{{ asset('home/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/revslider.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/common.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/countdown.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/jquery.bxslider.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('home/js/jquery.mobile-menu.min.js') }}"></script>
  <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script type="text/javascript" src="https://brm.io/js/libs/matchHeight/jquery.matchHeight.js"></script>
  {{--Toastr--}}
  @include('message')
  @include('layouts.js')
</body>

</html>