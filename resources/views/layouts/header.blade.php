<header class="header-style-1 isp" style="background-color: #000;">
   <?php
   $_catty = $_REQUEST['category'] ?? NULL;
   $searchy = $_REQUEST['name'] ?? NULL;
   $Menu1      = App\MenuLink::where(['menu_type' => 'header_1'])->first();
   $searchMenu = App\MenuLink::where(['menu_type' => 'header_2'])->get();
   $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get();
   $locale = session()->get('locale');
   if ($locale == "") {
      $locale = "en";
   }
   \App\CPU\Helpers::currency_load();
   $currency_code = session('currency_code');
   $currency_symbol = session('currency_symbol');
   if ($currency_symbol == "") {
      $system_default_currency_info = \session('system_default_currency_info');
      $currency_symbol = $system_default_currency_info->symbol;
      $currency_code = $system_default_currency_info->code;
   }
   $language = \App\CPU\Helpers::language_load();
   $categories = \App\CPU\CategoryManager::parents()
   ?>
   <style>
      .main-header .top-search-holder .search-area .search-button {
         background-color: #E1A006 !important;
         border: 1px solid #E1A006 !important;
      }

      .dropdown-submenu {
         position: relative;
      }

      .dropdown-submenu .dropdown-menu {
         /* top: 0;
      left: 100%; */
         margin-top: -1px;
         min-width: 250px;
      }

      .my-group .form-control {
         width: 70%;
      }

      ._show {
         @media (min-width: 1000px) {
            display: block;
         }
      }

      .text-white {
         color: #fff;
      }

      @media only screen and (min-width: 768px) {
         .autodrop {
            display: block;
         }
      }


      .tox-statusbar__branding {
         display: none;
      }

      .icaret {
         background-color: #0070c0 !important;
         padding: 4px;
         position: absolute;
         left: 90%;
         /* top: 45%; */
         color: #fff;
         border-radius: 3px;
      }

      .dropdown-submenu:hover>.dropdown-menu {
         display: block;
         color: initial !important;
      }

      .d-submenu:hover>.drop-down-menu {
         display: block;
         color: initial !important;
      }

      .header-style-1 .header-nav {
         background: #0070c0 !important;
      }
   </style>

   <div class="main-header visible-xs visible-sm visible-md" style="background-color: #000;">
      <div class="container">
         <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-4 animate-dropdown top-cart-row" style="min-width: 34%;">
               <div class="row">
                  <div class="col-xs-4 col-sm-6 col-md-6">
                     <a class="visible-xs visible-sm visible-md" href="{{ url('/') }}">
                        <img src="{{ website_logo() }}" height="50px" style="max-width: 100%;" alt="{{ website_title() }}">
                     </a>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                     <div class="dropdown dropdown-cart cart_items" id="cart_items" style="float: left;">
                        @include('layouts.front-end.partials.cart')
                     </div>
                  </div>
                  <div class="col-xs-2">
                     <div class="fl-header-right">
                        <div class="fl-links">
                           <div class="no-js">
                              <a title="Company" class="clicker"></a>
                              <div class="fl-nav-links">
                                 <div class="row" style="padding: 10px;">
                                    <div class="fl-language" style="width: 50%;">
                                       <select name="lang" class="form-control" id="lang">
                                          <option disabled selected value="{{route('lang', App::getLocale())}}">
                                             {{ Config::get('languages')[App::getLocale()] }}
                                          </option>
                                          @foreach (Config::get('languages') as $lang => $language)
                                          @if ($lang != App::getLocale())
                                          <option value="{{route('lang', $lang)}}">{{$language}}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                    <!--fl-language-->
                                    <!-- END For version 1,2,3,4,6 -->
                                    <!-- For version 1,2,3,4,6 -->
                                    <div class="fl-currency" style="width: 40%;">
                                       <select name="currency" class="form-control" id="currency" onchange="currency_change(this.value)">
                                          <option disabled selected> {{$currency_symbol}} {{$currency_code}} </option>
                                          @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                          @if ($currency_symbol != $currency->symbol)
                                          <option value="{{ $currency->code }}"> {{$currency->symbol}} &nbsp;
                                             {{ $currency->name }}
                                          </option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                    <!--fl-currency-->
                                    <!-- END For version 1,2,3,4,6 -->
                                 </div>
                                 <ul class="links">
                                    @if(auth('customer')->check())
                                    <li><a href="{{route('dashboard')}}" title="My Account">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li><a href="{{route('account-oder')}}" title="{{ __('wish_list') }}">{{ __('my_order') }}</a></li>
                                    <li><a href="{{route('user-account')}}" title="{{ __('wish_list') }}">{{ __('my_profile') }}</a></li>
                                    <li><a href="{{route('wishlists')}}" title="{{ __('wish_list') }}">{{ __('wish_list') }}</a></li>
                                    <li><a href="{{ route('checkout-details') }}" title="{{ __('checkout') }}">{{ __('checkout') }}</a></li>
                                    <li><a href="{{ route('customer.auth.logout') }}" title="My Account">{{ __('logout') }}</a></li>
                                    @else
                                    <li><a href="{{ route('blog.list') }}" title="Blog"><span>Blog</span></a></li>
                                    <li class="last"><a href="{{ route('customer.auth.login') }}" title="Login"><span>{{ __('sing_in') }}</span></a></li>
                                    <li class="last"><a href="{{ route('customer.auth.register') }}" title="Login"><span>{{ __('sing_up') }}</span></a></li>
                                    <li class="last"><a href="{{ route('seller.dashboard') }}" title="Vendors Login"><span>{{ __('seller') }} {{ __('login') }}</span></a>
                                    </li>
                                    @endif
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5 top-search-holder" style="min-width: 48%;">
               <!-- /.contact-row -->
               <!-- ============================================================= SEARCH AREA ============================================================= -->
               <div class="search-area">
                  <form action="{{route('products')}}" id="__search">
                     <input name="data_from" value="search" hidden>
                     <input name="page" value="1" hidden>
                     <div class="input-group my-group">
                        <?php ($categories = \App\CPU\CategoryManager::parents()) ?>
                        <select class="selectpicker form-control input-lg" style="width: 30%!important;border-radius: 0px;" data-live-search="true" role="menu" name="category" id="category">
                           <option value="" disabled selected> All</option>
                           @foreach($categories as $category)
                           <option @if($_catty==$category->id) selected @endif value="{{$category['id']}}">{{$category['name']}}</option>
                           @if($category->childes->count()>0)
                           @foreach($category['childes'] as $subCategory)
                           <option @if($_catty==$category->id) selected @endif value="{{$subCategory['id']}}">- {{$subCategory['name']}}</option>
                           @if($subCategory->childes->count()>0)
                           @foreach($subCategory['childes'] as $subSubCategory)
                           <option @if($_catty==$category->id) selected @endif value="{{$subSubCategory['id']}}">-- {{$subSubCategory['name']}}</option>
                           @endforeach
                           @endif
                           @endforeach
                           @endif
                           @endforeach
                        </select>
                        <input type="text" autocomplete="off" style="width: 70%" class="form-control input-lg" name="name" value="{{ $searchy }}" placeholder="Search Scudin Products">
                        <span class="input-group-btn">
                           <button class="btn btn-default search-button" type="submit"></button>
                        </span>

                     </div>
                  </form>
               </div>
               <!-- /.search-area -->
               <!-- ============================================================= SEARCH AREA : END ============================================================= -->
            </div>
         </div>
         <!-- /.row -->

      </div>
      <!-- /.container -->

   </div>
   <!-- ============================================== TOP MENU ============================================== -->
   <div class="top-bar animate-dropdown hidden-sm hidden-xs hidden-md">
      <div class="container">
         <div class="header-top-inner">
            <div class="cnt-account">
               <ul class="list-unstyled">
                  @if(auth('customer')->check())
                  <li><a href="{{route('dashboard')}}" title="My Account"><i class="icon fa fa-user"></i>{{ __('Dashboard') }}</a></li>
                  <li><a href="{{route('account-oder')}}" title="{{ __('wish_list') }}">{{ __('my_order') }}</a></li>
                  <li><a href="{{route('user-account')}}" title="{{ __('wish_list') }}">{{ __('my_profile') }}</a></li>
                  <li><a href="{{route('wishlists')}}" title="{{ __('wish_list') }}">{{ __('wish_list') }}</a></li>
                  <li><a href="{{ route('checkout-details') }}" title="{{ __('checkout') }}">{{ __('checkout') }}</a>
                  </li>
                  <li><a href="{{ route('customer.auth.logout') }}" title="My Account">{{ __('logout') }}</a></li>
                  @else
                  <li><a href="{{ route('blog.list') }}" title="Blog"><span>Blog</span></a></li>
                  <li><a href="{{ route('shop-cart') }}"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
                  <li><a href="{{ route('checkout-details') }}"><i class="icon fa fa-check"></i>{{ __('checkout') }}</a>
                  </li>
                  <li><a href="{{ route('customer.auth.login') }}"><i class="icon fa fa-lock"></i>{{ __('sing_in') }}</a></li>
                  <li class="last"><a href="{{ route('customer.auth.register') }}" title="Login"><span>{{ __('sing_up') }}</span></a></li>
                  <li><a href="{{ route('seller.auth.login') }}"><i class="icon fa fa-lock"></i>{{ __('Seller') }}
                        {{ __('Login') }}</a></li>
                  @endif
               </ul>
            </div>
            <!-- /.cnt-account -->

            <div class="cnt-block">
               <ul class="list-unstyled list-inline">
                  <li class="dropdown dropdown-small">
                     <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                        <span class="value">{{$currency_symbol}} {{$currency_code}} </span>
                        <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                        @if ($currency_symbol != $currency->symbol)
                        <li><a href="#" onclick="currency_change('{{ $currency->code }}')">{{$currency->symbol}} &nbsp;
                              {{ $currency->name }}</a></li>
                        @endif
                        @endforeach
                     </ul>
                  </li>
                  <li class="dropdown dropdown-small">
                     <a href="javascript:" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                        <span class="value">{{ Config::get('languages')[App::getLocale()] }} </span>
                        <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                        <li>
                           <a href="{{route('lang', $lang)}}">{{$language}}</a>
                        </li>
                        @endif
                        @endforeach
                     </ul>
                  </li>
               </ul>
               <!-- /.list-unstyled -->
            </div>
            <!-- /.cnt-cart -->
            <div class="clearfix"></div>
         </div>
         <!-- /.header-top-inner -->
      </div>
      <!-- /.container -->
   </div>
   <!-- /.header-top -->
   <!-- ============================================== TOP MENU : END ============================================== -->

   <div class="main-header hidden-sm hidden-xs hidden-md" style="background-color: #000;">
      <div class="container-fluid">
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder" style="width: 22%; margin-top: 0px; ">
               <!-- ============================================================= LOGO ============================================================= -->
               <div class="logo hidden-sm hidden-xs" style="padding-right: 5px;">
                  <a href="{{ url('/') }}">
                     <img src="{{ website_logo() }}" height="50px" alt="{{ website_title() }}">
                  </a>
                  @if(!empty($Menu1))
                  <a class="_show hidden-sm hidden-xs hovr" style="color:#fff; padding-left: 10px" href="{{ $Menu1->menu_link }}">
                     {{ $Menu1->menu_title }}
                  </a>
                  @endif
               </div>
               <!-- /.logo -->
               <!-- ============================================================= LOGO : END ============================================================= -->
            </div>
            <!-- /.logo-holder -->

            <div class="col-xs-12 col-sm-12 col-md-5 top-search-holder" style="min-width: 41%;">
               <!-- /.contact-row -->
               <!-- ============================================================= SEARCH AREA ============================================================= -->
               <div class="search-area">
                  <form action="{{route('products')}}" id="__search">
                     <input name="data_from" value="search" hidden>
                     <input name="page" value="1" hidden>
                     <div class="input-group my-group">
                        <?php ($categories = \App\CPU\CategoryManager::parents());  ?>
                        <select class="selectpicker form-control input-lg" style="width: 30%;border-radius: 0px;" data-live-search="true" role="menu" name="category" id="category">
                           <option value="" disabled selected> All</option>
                           @foreach($categories as $category)
                           <option @if($_catty==$category->id) selected @endif value="{{$category['id']}}">{{$category['name']}}</option>
                           @if($category->childes->count()>0)
                           @foreach($category['childes'] as $subCategory)
                           <option @if($_catty==$subCategory->id) selected @endif value="{{$subCategory['id']}}">- {{$subCategory['name']}}</option>
                           @if($subCategory->childes->count()>0)
                           @foreach($subCategory['childes'] as $subSubCategory)
                           <option @if($_catty==$subSubCategory->id) selected @endif value="{{$subSubCategory['id']}}">-- {{$subSubCategory['name']}}</option>
                           @endforeach
                           @endif
                           @endforeach
                           @endif
                           @endforeach
                        </select>
                        <input type="text" autocomplete="off" style="width: 70%" class="form-control input-lg" name="name" value="{{ $searchy }}" placeholder="Search Scudin Products">
                        <span class="input-group-btn">
                           <button class="btn btn-default search-button" type="submit"></button>
                        </span>

                     </div>
                  </form>
               </div>
               <!-- /.search-area -->
               <!-- ============================================================= SEARCH AREA : END ============================================================= -->
            </div>
            <!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-4 animate-dropdown top-cart-row" style="min-width: 34%;">
               <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                     <a class="visible-xs visible-sm visible-md" href="{{ url('/') }}">
                        <img src="{{ website_logo() }}" height="50px" alt="{{ website_title() }}">
                     </a>
                     <div style="margin-top: 12px">
                        @foreach($searchMenu->take(2) as $ll )
                        <a class="hidden-sm hidden-xs hidden-md hovr" style="color:#fff; padding-left: 20px" href="{{ $ll->menu_link }}">
                           {{ $ll->menu_title }}
                        </a>
                        @endforeach
                     </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                     <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                     <div class="dropdown dropdown-cart cart_items" id="cart_items2" style="float: left;">
                        @include('layouts.front-end.partials.cart')
                        <!-- /.dropdown-menu-->
                     </div>
                     <!-- /.dropdown-cart -->

                     <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                  </div>
               </div>
            </div>
            <!-- /.top-cart-row -->
         </div>
         <!-- /.row -->

      </div>
      <!-- /.container -->

   </div>
   <!-- /.main-header -->
   <!-- ============================================== NAVBAR ============================================== -->
   <div class="header-nav animate-dropdown">
      <div class="container-fluid" style="padding-left: 0px;">
         <div class="yamm navbar navbar-default" role="navigation">
            <div class="navbar-header visible-xs visible-sm visible-md">
               <div class="mm-toggle-wrap" style="float: left">
                  <div class="mm-toggle">
                     <i class="icon-align-justify" style="color: #fff"></i>
                     <i class="icon fa fa-align-justify fa-fw"></i>
                  </div>
               </div>
            </div>
            <div class="nav-bg-class">
               <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse" style="float: left;">
                  <div class="nav-outer">
                     <ul class="nav navbar-nav">
                        <li class="dropdown-submenu">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="icon fa fa-align-justify fa-fw"></i>All
                              <span class="caret"></span>
                           </a>
                           <ul class="dropdown-menu" style="max-height: 700px">
                              @foreach($categories as $category)
                              <!-- <li> <a tabindex="-1" href="#">2nd level dropdown</a> </li> -->
                              <li class="dropdown-submenu">
                                 <a class="test" href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                    &emsp; {{$category['name']}}
                                    <?php if ($category->childes->count() > 0) : ?>
                                       <span class="icaret fa fa-angle-right"></span>
                                    <?php endif ?>
                                 </a>
                                 @if($category->childes->count()>0)
                                 <ul class="dropdown-menu" style="top: 0; left: 100%;">
                                    @foreach($category['childes'] as $subCategory)
                                    <li class="d-submenu">
                                       <a href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                          &emsp; - {{$subCategory['name']}}
                                          <?php if ($subCategory->childes->count() > 0) : ?>
                                             <span class="icaret fa fa-angle-right"></span>
                                          <?php endif ?>
                                       </a>
                                       @if($subCategory->childes->count()>0)
                                       <ul class="dropdown-menu drop-down-menu" style="top: 0; left: 100%;">
                                          @foreach($subCategory['childes'] as $subSubCategory)
                                          <li>
                                             <a href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">&emsp;
                                                -- {{$subSubCategory['name']}}
                                             </a>
                                          </li>
                                          @endforeach
                                       </ul>
                                       @endif
                                    </li>
                                    @endforeach
                                 </ul>
                                 @endif
                              </li>
                              @endforeach
                           </ul>
                        </li>
                        <?php $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get(); ?>
                        <li class="active dropdown yamm-fw">
                           <a href="{{ url('/') }}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Home</a>
                        </li>
                        @foreach($headerMenu->take(7) as $link)
                        <li class="active dropdown yamm-fw">
                           <a href="{{ $link->menu_link }}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ $link->menu_title }}</a>
                        </li>
                        @endforeach
                        <!-- <li class="dropdown  navbar-right special-menu"> <a href="#">Todays offer</a> </li> -->
                     </ul>
                     <!-- /.navbar-nav -->
                     <div class="clearfix"></div>
                  </div>
                  <!-- /.nav-outer -->
               </div>
               <!-- /.navbar-collapse -->

            </div>
            <!-- /.nav-bg-class -->
         </div>
         <!-- /.navbar-default -->
      </div>
      <!-- /.container-class -->

   </div>
   <!-- /.header-nav -->
   <!-- ============================================== NAVBAR : END ============================================== -->

</header>
<!-- Quick goto categories list -->
<div class="panel hidden-xs hidden-sm hidden-md" style="margin-bottom: 0px">
   <div class="container-fluid">
      <div style="padding: 8px;"> Go Quickly to:
         @foreach($categories->take(10) as $category)
         <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
            {{$category['name']}}
         </a>, &nbsp;
         @endforeach
      </div>
   </div>
</div>
<script>
   $('.dropdown-toggle').click(function(e) {
      if ($(document).width() > 768) {
         e.preventDefault();
         var url = $(this).attr('href');
         if (url !== '#') {
            window.location.href = url;
         }
      }
   });

   // $(document).ready(function() {
   //    $('.dropdown-submenu a.test').on("click", function(e) {
   //       $(this).next('ul').toggle();
   //       e.stopPropagation();
   //       e.preventDefault();
   //    });
   // });
</script>
<!-- /.Quick goto categories list -->