<header class="header-style-1" style="background-color: #000;">
  <?php $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get();
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
    .my-group .form-control {
      width: 70%;
    }
  </style>
  <!-- ============================================== TOP MENU ============================================== -->
  <div class="top-bar animate-dropdown">
    <div class="container">
      <div class="header-top-inner">
        <div class="cnt-account">
          <ul class="list-unstyled">
            @if(auth('customer')->check())
            <li><a href="{{route('dashboard')}}" title="My Account"><i class="icon fa fa-user"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{route('account-oder')}}" title="{{ __('wish_list') }}">{{ __('my_order') }}</a></li>
            <li><a href="{{route('user-account')}}" title="{{ __('wish_list') }}">{{ __('my_profile') }}</a></li>
            <li><a href="{{route('wishlists')}}" title="{{ __('wish_list') }}">{{ __('wish_list') }}</a></li>
            <li><a href="{{ route('checkout-details') }}" title="{{ __('checkout') }}">{{ __('checkout') }}</a></li>
            <li><a href="{{ route('customer.auth.logout') }}" title="My Account">{{ __('logout') }}</a></li>
            @else
            <li><a href="{{ route('dashboard') }}">My Account</a></li>
            <li><a href="{{ route('shop-cart') }}"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
            <li><a href="{{ route('checkout-details') }}"><i class="icon fa fa-check"></i>{{ __('checkout') }}</a></li>
            <li><a href="{{ route('customer.auth.login') }}"><i class="icon fa fa-lock"></i>{{ __('sing_in') }}</a></li>
            <li><a href="{{ route('seller.auth.login') }}"><i class="icon fa fa-lock"></i>{{ __('seller') }} {{ __('login') }}</a></li>
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
                <li><a href="#" onclick="currency_change('{{ $currency->code }}')">{{$currency->symbol}} &nbsp; {{ $currency->name }}</a></li>
                @endif
                @endforeach
              </ul>
            </li>
            <li class="dropdown dropdown-small">
              <a href="{{route('lang', App::getLocale())}}" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
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
  <div class="main-header" style="background-color: #000;">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 logo-holder">
          <!-- ============================================================= LOGO ============================================================= -->
          <div class="logo">
            <a href="{{ url('/') }}">
              <img src="{{ website_logo() }}" height="50px" alt="{{ website_title() }}">
            </a>
          </div>
          <!-- /.logo -->
          <!-- ============================================================= LOGO : END ============================================================= -->
        </div>
        <!-- /.logo-holder -->

        <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
          <!-- /.contact-row -->
          <!-- ============================================================= SEARCH AREA ============================================================= -->
          <div class="search-area">
            <form action="{{route('products')}}" id="__search">
              <input name="data_from" value="search" hidden>
              <input name="page" value="1" hidden>
              <div class="input-group my-group">
                <?php ($categories = \App\CPU\CategoryManager::parents()) ?>
                <select class="selectpicker form-control input-lg" style="width: 30%;border-radius: 0px;" data-live-search="true" role="menu" name="category" id="category">
                  <option value="" disabled selected> All Categories</option>
                  @foreach($categories as $category)
                  <option value="xoxo">{{$category['name']}}</option>
                  @if($category->childes->count()>0)
                  @foreach($category['childes'] as $subCategory)
                  <option value="xoxo">- {{$subCategory['name']}}</option>
                  @if($subCategory->childes->count()>0)
                  @foreach($subCategory['childes'] as $subSubCategory)
                  <option value="xoxo">-- {{$subSubCategory['name']}}</option>
                  @endforeach
                  @endif
                  @endforeach
                  @endif
                  @endforeach
                </select>
                <input type="text" class="form-control input-lg" name="snpid" placeholder="Search products, brands and categories">
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

        <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
          <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
          <div class="dropdown dropdown-cart">
            @include('layouts.front-end.partials.cart')
            <!-- /.dropdown-menu-->
          </div>
          <!-- /.dropdown-cart -->

          <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
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
    <div class="container">
      <div class="yamm navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="nav-bg-class">
          <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
            <div class="nav-outer">
              <ul class="nav navbar-nav">
                <?php $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get(); ?>
                <li class="active dropdown yamm-fw">
                  <a href="{{ url('/') }}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Home</a>
                </li>
                @foreach($headerMenu->take(7) as $link)
                <li class="active dropdown yamm-fw">
                  <a href="{{ $link->menu_link }}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ $link->menu_title }}</a>
                </li>
                @endforeach
                <li class="dropdown  navbar-right special-menu"> <a href="#">Todays offer</a> </li>
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
<div class="container">
  <div style="padding: 10px;"> Go Quickly to:
    @foreach($categories->take(10) as $category)
    <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
      {{$category['name']}}
    </a>, &nbsp;
    @endforeach
  </div>
</div>
<!-- /.Quick goto categories list -->