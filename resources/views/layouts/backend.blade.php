<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="description" content=" Scudin.com: Online Shopping for Computers, Electronics, Automotive, Apparel, Books, Kitchen and more">
  <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="Emmanuel Towoju">
  <title>@yield('title') - {{ website_title() }}</title>
  <?php $fav_logo = \App\Model\BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0] ?>
  <link rel="apple-touch-icon" href="{{ asset($fav_logo) }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset($fav_logo) }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.1/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap-extended.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/colors.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/components.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/dark-layout.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/bordered-layout.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/semi-dark-layout.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/tagsinput.css') }}">
  <!-- BEGIN: Page CSS-->
  @yield('css')
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/icon-set/style.css">
  <!-- END: Custom CSS-->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <meta name="_token" content="{{ csrf_token() }}" />
  <style>
    .tox-statusbar__branding {
      display: none;
    }

    .page-header {
      background: white;
      margin-bottom: 15px;
      padding: 15px
    }

    .icon-soft-info {
      color: #00c9db;
      background: rgba(0, 201, 219, .1);
    }

    .icon-circle {
      border-radius: 50%;
    }

    .icon {
      /* display: -ms-inline-flexbox; */
      display: inline-flex;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      -ms-flex-pack: center;
      justify-content: center;
      -ms-flex-align: center;
      align-items: center;
      font-size: 1.09375rem;
      width: 2.625rem;
      height: 2.625rem;
    }

    .btn-primary {
      background: #e1a006 !important;
      color: #FFF !important;
      border-color: #e1a006 !important;
    }

    /* .btn-primary {
      color: #fff;
      background-color: #7367f0;
      border-color: #7367f0;
    } */

    .btn-primary:hover {
      color: #fff;
      background-color: #e1a006 !important;
      ;
      border-color: #e1a006 !important;
      ;
    }

    .btn-primary:focus,
    .btn-primary.focus {
      color: #fff;
      background-color: #e1a006 !important;
      ;
      border-color: #e1a006 !important;
      ;
      box-shadow: 0 0 0 0.2rem rgba(136, 126, 242, 0.5);
    }

    .btn-primary.disabled,
    .btn-primary:disabled {
      color: #fff;
      background-color: #7367f0;
      border-color: #7367f0;
    }

    .btn-primary:not(:disabled):not(.disabled):active,
    .btn-primary:not(:disabled):not(.disabled).active,
    .show>.btn-primary.dropdown-toggle {
      color: #fff;
      background-color: #e1a006 !important;
      ;
      border-color: #3e2dea;
    }

    .btn-primary:not(:disabled):not(.disabled):active:focus,
    .btn-primary:not(:disabled):not(.disabled).active:focus,
    .show>.btn-primary.dropdown-toggle:focus {
      box-shadow: 0 0 0 0.2rem rgba(136, 126, 242, 0.5);
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

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

  @include('layouts.dashboard._header')
  @include('layouts.dashboard._menu')

  <!-- BEGIN: Content-->
  <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
      <div class="content-body">
        <div id="loading">
        </div>
        <!-- profile info section -->
        @yield('content')
        <!--/ profile info section -->

      </div>
    </div>
  </div>
  <!-- END: Content-->

  <!-- <div class="sidenav-overlay"></div>
  <div class="drag-target"></div> -->


  <!-- BEGIN: Body-->


  @php($company_copyright_text=\App\Model\BusinessSetting::where(['type'=>'company_copyright_text'])->first())
  <!-- BEGIN: Footer-->
  <footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
      <span class="float-md-left d-block d-md-inline-block mt-25">
        {{ $company_copyright_text->value }}
      </span>
      <!-- <span class="float-md-right d-none d-md-block">
        Hand-crafted & Made with
        <i data-feather="heart"></i> By 
        <a target="_blank" href="https://towoju.com">
          Woju Technologies
        </a> 
      </span> -->
    </p>
  </footer>
  <!-- END: Footer-->

  <!-- BEGIN: Page Vendor JS-->
  @yield('js')

  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="{{ asset('app-assets/js/tagsinput.js') }}"></script>
  <script src="{{ url('/') }}/app-assets/js/core/app-menu.min.js"></script>
  <script src="{{ url('/') }}/app-assets/js/core/app.min.js"></script>
  <script src="{{ url('/') }}/app-assets/js/scripts/customizer.min.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="{{ url('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ url('/') }}/app-assets/js/scripts/pages/page-profile.min.js"></script>
  <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script src="{{ url('app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
  <!-- END: Page JS-->
  {{--ck editor--}}
  <script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
  <script type="text/javascript" src="{{ asset('front/js/spartan-multi-image-picker.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

  {{--ck editor--}}
  @include('flash.message')
  @include('message')

  @stack('js')
  <script>
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    })
  </script>
  <script>
    var darkMode = 'darkMode';
    $(document).on('ready', function() {
      // initialization of select2
      $('.js-select2-custom').each(function() {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
      });
    });

    // get color mode dark or light
    $(document).ready(function() {
      if (readCookie(darkMode)) {
        $('html').addClass('loaded light-layout dark-layout');
      } else {
        $('html').addClass('loaded light-layout');
      }
    });
    // set & unset dark mode
    $('.nav-link-style').click(function() {
      if (checkCookie(darkMode)) {
        eraseCookie(darkMode)
      } else {
        createCookie(darkMode, '1', 365)
      }
    });

    function createCookie(name, value, days) {
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
      } else var expires = "";
      document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function checkCookie(cname) {
      let username = readCookie(cname);
      if (username != "") {
        return true;
      } else {
        return false;
      }
    }

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

    // function eraseCookie(name, path, domain) {
    //   if (checkCookie(name)) {
    //     document.cookie = name + "=" + '' + -99999999 + "; path=/";
    //     return false;
    //   }
    // }

    function eraseCookie(name) {
      createCookie(name, "", null, null, null, 1);
    }    
    
    var check_table = document.getElementById("dataTable");
    if(check_table == null || check_tabl == null) {
        $('table').DataTable();
    }
  </script>
  <style>
    .dropdown-menu .dropdown-item>li>a:hover {
      background-image: none;
      background-color: #fff !important;
    }

    .navbar {
      background: none;
    }

    .dropdown-content a:hover {
      background-color: transparent;
    }

    .dataTables_wrapper>.row {
      margin: 1rem;
    }

    #datatable_filter {
      float: right;
    }
  </style>


</body>
<!-- END: Body-->

</html>
