<div id="header">
  <div class="header-container container">
    <div class="row">
      <div class="logo"> <a href="{{ url('/') }}" title="{{ website_title() }}">
          <div><img src="{{ website_logo() }}" height="50px" alt="{{ website_title() }}"></div>
        </a> </div>
      <div class="fl-nav-menu" style="background-color: transparent">
        <?php $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get(); ?>
        <nav>
          <div class="mm-toggle-wrap">
            <div class="mm-toggle">
              <i class="icon-align-justify" style="color: #fff"></i>
              <span class="mm-label">Menu</span>
            </div>
          </div>
          <div class="nav-inner">
            <!-- BEGIN NAV -->
            <ul id="nav" class="hidden-xs">
              @foreach($headerMenu->take(7) as $link)
              <li class="mega-menu" style="padding-right: 20px;">
                <a href="{{ $link->menu_link }}" class="level-top" title="{{ $link->menu_title }}">
                  {{ $link->menu_title }}
                </a>
              </li>
              @endforeach
            </ul>
            <!--nav-->
          </div>
        </nav>
      </div>
      <!--row-->
    </div>
    <div class="fl-header-right">
      <div class="fl-links">
        <div class="no-js">
          <a title="Company" class="clicker"></a>
          <div class="fl-nav-links">
            <div class="row" style="padding: 10px;">
              <div class="fl-language" style="width: 50%;">
                <select name="lang" class="form-control" id="lang">
                  <option disabled selected value="{{route('lang', App::getLocale())}}">{{ Config::get('languages')[App::getLocale()] }}</option>
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
                  <option value="{{ $currency->code }}"> {{$currency->symbol}} &nbsp; {{ $currency->name }} </option>
                  @endif
                  @endforeach
                </select>
              </div>
              <!--fl-currency-->
              <!-- END For version 1,2,3,4,6 -->
            </div>
            <ul class="links">
              @if(auth('customer')->check())
              <li><a href="{{route('dashboard')}}" title="My Account">{{ __('Dashboard') }}</a></li>
              <li><a href="{{route('account-oder')}}" title="{{ __('wish_list') }}">{{ __('my_order') }}</a></li>
              <li><a href="{{route('user-account')}}" title="{{ __('wish_list') }}">{{ __('my_profile') }}</a></li>
              <li><a href="{{route('wishlists')}}" title="{{ __('wish_list') }}">{{ __('wish_list') }}</a></li>
              <li><a href="{{ route('checkout-details') }}" title="{{ __('checkout') }}">{{ __('checkout') }}</a></li>
              <li><a href="{{ route('customer.auth.logout') }}" title="My Account">{{ __('logout') }}</a></li>
              @else
              <li><a href="{{ route('blog.list') }}" title="Blog"><span>Blog</span></a></li>
              <li class="last"><a href="{{ route('customer.auth.login') }}" title="Login"><span>{{ __('sing_in') }}</span></a></li>
              <li class="last"><a href="{{ route('customer.auth.register') }}" title="Login"><span>{{ __('sing_up') }}</span></a></li>
              <li class="last"><a href="{{ route('seller.auth.login') }}" title="Vendors Login"><span>{{ __('seller') }} {{ __('login') }}</span></a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <div class="fl-cart-contain" id="cart_items">
        @include('layouts.front-end.partials.cart')
      </div>
      <!--mini-cart-->
      <div class="collapse navbar-collapse">
        <form class="navbar-form" action="{{route('products')}}">
          @csrf
          <div class="input-group">
            <input name="data_from" value="search" hidden>
            <input name="page" value="1" hidden>
            <input class="GlobalNavSearch js-globalSearchInput " placeholder="{{ __('search') }}..." name="name">
            <label class="GlobalNavSearch-searchIcon" for="desktopSearchInput" data-reactid=".1.0.0.1"></label>
            <button type="submit" hidden></button>
          </div>
        </form>
      </div>
      <!--links-->
    </div>
  </div>
</div>