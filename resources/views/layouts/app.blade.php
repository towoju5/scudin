<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->
<?php $fav_logo = \App\Model\BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0] ?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="TOWOJU I.T HUB">
  <title>Scudin.com: Online Shopping for Computers, Electronics, Automotive, Apparel, Books, Kitchen and more</title>
  <link rel="apple-touch-icon" href="{{ asset($fav_logo) }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset($fav_logo) }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
  <link rel="stylesheet" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap-extended.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/colors.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/components.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/dark-layout.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/bordered-layout.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/semi-dark-layout.min.css">
  @yield('css')
  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/style.css">
  <!-- END: Custom CSS-->
  <style>
    #best-seller .owl-item .item {
      float: none !important;
    }

    .loader {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .btn-scudin {
      background: #e1a006;
      color: #FFF !important;
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

  <!-- BEGIN: Vendor JS-->
  <script src="{{ url('/') }}/app-assets/vendors/js/vendors.min.js"></script>
  <!-- BEGIN Vendor JS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
  <!-- BEGIN: Content-->
  <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <div id="loading" class="content-header row">
      </div>
      <div class="content-body">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- END: Content-->

  <!-- BEGIN: Page Vendor JS-->
  <!-- <script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script> -->
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="{{ url('/') }}/app-assets/js/core/app-menu.min.js"></script>
  <script src="{{ url('/') }}/app-assets/js/core/app.min.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="{{ url('/') }}/app-assets/js/scripts/pages/page-auth-login.js"></script>
  <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <!-- END: Page JS-->
  @yield('js')
  @include('flash.message')
  @include('message')
  <script>
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    })

    function form_alert(id, message) {
      Swal.fire({
        title: 'Are you sure?',
        text: message,
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: 'default',
        confirmButtonColor: '#377dff',
        cancelButtonText: 'No',
        confirmButtonText: 'Yes',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $('#' + id).submit()
        }
      })
    }
  </script>
</body>
<!-- END: Body-->

</html>