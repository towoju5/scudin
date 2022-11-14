@php
$locale = session()->get('locale') ;
if ($locale==""){
$locale = "en";
}
\App\CPU\Helpers::currency_load();
$currency_code = session('currency_code');
$currency_symbol= session('currency_symbol');
if ($currency_symbol=="")
{
$system_default_currency_info = \session('system_default_currency_info');
$currency_symbol = $system_default_currency_info->symbol;
$currency_code = $system_default_currency_info->code;
}
$language=\App\CPU\Helpers::language_load();
$categories=\App\CPU\CategoryManager::parents()
@endphp
<header id="header" class=" typeheader-4">
  <!-- Header Top -->
  <div class="header-top hidden-compact">
    <div class="container">
      <div class="row">
        <div class="header-top-left col-lg-6 col-md-4 col-sm-6 col-xs-7">
          <ul class="top-link list-inline lang-curr">
            <li class="currency">
              <div class="btn-group currencies-block">
                <form action="{{ url('/') }}" method="post" enctype="multipart/form-data" id="currency">
                  <a class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                    <span class="icon icon-credit "></span> {{$currency_symbol}}  {{$currency_code}} <span class="fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu btn-xs">
                  @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                    <li> 
                      <a href="#" onclick="currency_change('{{ $currency->code }}')">
                        {{$currency->symbol}} &nbsp; {{ $currency->name }}
                      </a>
                    </li>
                  @endforeach
                  </ul>
                </form>
              </div>
            </li>
            <li class="language">
              <div class="btn-group languages-block ">
                <form action="{{ url('/') }}" method="post" enctype="multipart/form-data" id="bt-language"> <a class="btn-link dropdown-toggle" data-toggle="dropdown"> <img src="{{ asset('front/image/catalog/flags/gb.png') }}" alt="English" title="English"> <span class="">English</span> <span class="fa fa-angle-down"></span> </a>
                  <ul class="dropdown-menu">
                    @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                    <li>
                      <a href="{{route('lang', $lang)}}">
                        <img class="mr-2" width="20" src="{{asset('flags/list')}}/{{$lang}}.svg" alt="{{$language}}" /> {{$language}}
                      </a>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                </form>
              </div>
            </li>
          </ul>
        </div>
        <div class="header-top-right collapsed-block col-lg-6 col-md-8 col-sm-6 col-xs-5">
          <ul class="top-link list-inline">
            <li class="account" id="my_account"> <a href="#" title="My Account " class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span>My Account </span> <span class="fa fa-caret-down"></span> </a>
              <ul class="dropdown-menu " style="display: none;">
                <li><a href="{{ url('register') }}">Register</a> </li>
                <li><a href="{{ url('login') }}">Login</a> </li>
              </ul>
            </li>
            <li class="wishlist hidden-sm hidden-xs"><a href="#" id="wishlist-total" class="top-link-wishlist" title="Wish List (0) ">
                <!-- <i class="fa fa-heart"></i> --> Wish List (0)
              </a> </li>
            <li class="checkout hidden-sm hidden-xs"><a href="{{route('checkout-details')}}" class="btn-link" title="Checkout "><span><i class="fa fa-check-square-o"></i>Checkout </span></a> </li>
            <li class="hidden-xs"><a href="{{ url('login') }}"><i class="fa fa-lock"></i>Login</a> </li>
          </ul>
        </div>
      </div>
    </div>
  </div> <!-- //Header Top -->
  <!-- Header center -->
  <div class="header-middle">
    <div class="container">
      <div class="row">
        <!-- Logo -->
        <div class="navbar-logo col-lg-2 col-md-3 col-sm-12 col-xs-12">
          <div class="logo text-center">
            <a href="{{ url('/') }}">
              <img src="{{ website_logo() }}" title="{{ website_title() }}" alt="{{ website_title() }}" />
            </a>
          </div>
        </div> <!-- //end Logo -->
        <!-- Search -->
        <div class="middle2 col-lg-7 col-md-6">
          <div class="search-header-w">
            <div class="icon-search hidden-lg hidden-md hidden-sm"><i class="fa fa-search"></i></div>
            <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
              <form method="GET" action="{{ url('/') }}">
                <div id="search0" class="search input-group form-group">
                  <div class="select_category filter_type  icon-select hidden-sm hidden-xs"> 
                    <select class="no-border" name="category_id">
                    <option value="0">All Categories</option>
                    @foreach($categories as $category)
                      <option value="78">{{$category['name']}}</option>
                    @endforeach
                    </select> 
                  </div> 
                  <input class="autosearch-input form-control" type="text" value="" size="50" autocomplete="off" placeholder="Keyword here..." name="search"> <span class="input-group-btn"> <button type="submit" class="button-search btn btn-primary" name="submit_search"><i class="fa fa-search"></i></button> </span>
                </div> 
                <input type="hidden" name="route" value="product/search" />
              </form>
            </div>
          </div>
        </div> <!-- //end Search -->
        <div class="middle3 col-lg-3 col-md-3">
          <!--cart-->
          <div class="shopping_cart" id="cart_items">
            @include('layouts.front-end.partials.cart')
          </div>
          <!--//cart-->
        </div>
      </div>
    </div>
  </div> <!-- //Header center -->
  <?php /*
  <!-- Header Bottom -->
  <div class="header-bottom hidden-compact">
    <div class="container">
      <div class="row">
        <div class="bottom1 menu-vertical col-lg-2 col-md-3">
          <!-- Secondary menu -->
          <div class="responsive so-megamenu  megamenu-style-dev">
            <div class="so-vertical-menu ">
              <nav class="navbar-default">
                <div class="container-megamenu vertical">
                  <div id="menuHeading">
                    <div class="megamenuToogle-wrapper">
                      <div class="megamenuToogle-pattern">
                        <div class="container">
                          <div> <span></span> <span></span> <span></span> </div> All Categories
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="navbar-header"> <button type="button" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle"> <i class="fa fa-bars"></i> <span> All Categories </span> </button> </div>
                  <div class="vertical-wrapper"> <span id="remove-verticalmenu" class="fa fa-times"></span>
                    <div class="megamenu-pattern">
                      <div class="container-mega">
                        <ul class="megamenu">
                          <li class="item-vertical  with-sub-menu hover">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico10.png') }}" alt="icon"> <span>Gifts & Toys</span> <b class="caret"></b> </a>
                            <div class="sub-menu" data-subwidth="60">
                              <div class="content">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="row">
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Apparel</a>
                                              <ul>
                                                <li><a href="#">Accessories for Tablet PC</a> </li>
                                                <li><a href="#">Accessories for i Pad</a> </li>
                                                <li><a href="#">Accessories for iPhone</a> </li>
                                                <li><a href="#">Bags, Holiday Supplies</a> </li>
                                                <li><a href="#">Car Alarms and Security</a> </li>
                                                <li><a href="#">Car Audio &amp; Speakers</a> </li>
                                              </ul>
                                            </li>
                                            <li> <a href="#" class="main-menu">Cables &amp; Connectors</a>
                                              <ul>
                                                <li><a href="#">Cameras &amp; Photo</a> </li>
                                                <li><a href="#">Electronics</a> </li>
                                                <li><a href="#">Outdoor &amp; Traveling</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Camping &amp; Hiking</a>
                                              <ul>
                                                <li><a href="#">Earings</a> </li>
                                                <li><a href="#">Shaving &amp; Hair Removal</a> </li>
                                                <li><a href="#">Salon &amp; Spa Equipment</a> </li>
                                              </ul>
                                            </li>
                                            <li> <a href="#" class="main-menu">Smartphone &amp; Tablets</a>
                                              <ul>
                                                <li><a href="#">Sports &amp; Outdoors</a> </li>
                                                <li><a href="#">Bath &amp; Body</a> </li>
                                                <li><a href="#">Gadgets &amp; Auto Parts</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Bags, Holiday Supplies</a>
                                              <ul>
                                                <li><a href="#" onclick="window.location = '18_46.html';">Battereries &amp; Chargers</a> </li>
                                                <li><a href="#" onclick="window.location = '24_64.html';">Bath &amp; Body</a> </li>
                                                <li><a href="#" onclick="window.location = '18_45.html';">Headphones, Headsets</a> </li>
                                                <li><a href="#" onclick="window.location = '18_30.html';">Home Audio</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico1.png') }}" alt="icon"> <span>Fashion & Accessories</span> </a>
                          </li>
                          <li class="item-vertical  style1 with-sub-menu hover">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <span class="label"></span> <img src="{{ asset('front/image/catalog/menu/icons/ico9.png') }}" alt="icon"> <span>Electronic</span> <b class="caret"></b> </a>
                            <div class="sub-menu" data-subwidth="40">
                              <div class="content">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="row">
                                      <div class="col-md-12 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li><a href="#" class="main-menu">Smartphone</a>
                                              <ul>
                                                <li><a href="#">Esdipiscing</a> </li>
                                                <li><a href="#">Scanners</a> </li>
                                                <li><a href="#">Apple</a> </li>
                                                <li><a href="#">Dell</a> </li>
                                                <li><a href="#">Scanners</a> </li>
                                              </ul>
                                            </li>
                                            <li><a href="#" class="main-menu">Electronics</a>
                                              <ul>
                                                <li><a href="#">Asdipiscing</a> </li>
                                                <li><a href="#">Diam sit</a> </li>
                                                <li><a href="#">Labore et</a> </li>
                                                <li><a href="#">Monitors</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="row banner"> <a href="#"> <img src="{{ asset('front/image/catalog/menu/megabanner/vbanner1.jpg') }}" alt="banner1"> </a> </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <li class="item-vertical with-sub-menu hover">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico7.png') }}" alt="icon"> <span>Health &amp; Beauty</span> <b class="caret"></b> </a>
                            <div class="sub-menu" data-subwidth="60">
                              <div class="content">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="row">
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Car Alarms and Security</a>
                                              <ul>
                                                <li><a href="#">Car Audio &amp; Speakers</a> </li>
                                                <li><a href="#">Gadgets &amp; Auto Parts</a> </li>
                                                <li><a href="#">Gadgets &amp; Auto Parts</a> </li>
                                                <li><a href="#">Headphones, Headsets</a> </li>
                                              </ul>
                                            </li>
                                            <li> <a href="24.html" onclick="window.location = '24.html';" class="main-menu">Health &amp; Beauty</a>
                                              <ul>
                                                <li> <a href="#">Home Audio</a> </li>
                                                <li> <a href="#">Helicopters &amp; Parts</a> </li>
                                                <li> <a href="#">Outdoor &amp; Traveling</a> </li>
                                                <li> <a href="#">Toys &amp; Hobbies</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Electronics</a>
                                              <ul>
                                                <li> <a href="#">Earings</a> </li>
                                                <li> <a href="#">Salon &amp; Spa Equipment</a> </li>
                                                <li> <a href="#">Shaving &amp; Hair Removal</a> </li>
                                                <li> <a href="#">Smartphone &amp; Tablets</a> </li>
                                              </ul>
                                            </li>
                                            <li> <a href="#" class="main-menu">Sports &amp; Outdoors</a>
                                              <ul>
                                                <li> <a href="#">Flashlights &amp; Lamps</a> </li>
                                                <li> <a href="#">Fragrances</a> </li>
                                                <li> <a href="#">Fishing</a> </li>
                                                <li> <a href="#">FPV System &amp; Parts</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                      <div class="col-md-4 static-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">More Car Accessories</a>
                                              <ul>
                                                <li> <a href="#">Lighter &amp; Cigar Supplies</a> </li>
                                                <li> <a href="#">Mp3 Players &amp; Accessories</a> </li>
                                                <li> <a href="#">Men Watches</a> </li>
                                                <li> <a href="#">Mobile Accessories</a> </li>
                                              </ul>
                                            </li>
                                            <li> <a href="#" class="main-menu">Gadgets &amp; Auto Parts</a>
                                              <ul>
                                                <li> <a href="#">Gift &amp; Lifestyle Gadgets</a> </li>
                                                <li> <a href="#">Gift for Man</a> </li>
                                                <li> <a href="#">Gift for Woman</a> </li>
                                                <li> <a href="#">Gift for Woman</a> </li>
                                              </ul>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <li class="item-vertical css-menu with-sub-menu hover">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico6.png') }}" alt="icon"> <span>Smartphone &amp; Tablets</span> <b class="caret"></b> </a>
                            <div class="sub-menu" data-subwidth="20">
                              <div class="content">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="row">
                                      <div class="col-sm-12 hover-menu">
                                        <div class="menu">
                                          <ul>
                                            <li> <a href="#" class="main-menu">Headphones, Headsets</a> </li>
                                            <li> <a href="#" class="main-menu">Home Audio</a> </li>
                                            <li> <a href="#" class="main-menu">Health &amp; Beauty</a> </li>
                                            <li> <a href="#" class="main-menu">Helicopters &amp; Parts</a> </li>
                                            <li> <a href="#" class="main-menu">Helicopters &amp; Parts</a> </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico5.png') }}" alt="icon"> <span>Health & Beauty</span> </a>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico4.png') }}" alt="icon"> <span>Bathroom</span> </a>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico3.png') }}" alt="icon"> <span>Metallurgy</span> </a>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico2.png') }}" alt="icon"> <span>Bedroom</span> </a>
                          </li>
                          <li class="item-vertical">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico1.png') }}" alt="icon"> <span>Health &amp; Beauty</span> </a>
                          </li>
                          <li class="item-vertical" style="display: none;">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico11.png') }}" alt="icon"> <span>Toys &amp; Hobbies </span> </a>
                          </li>
                          <li class="item-vertical" style="display: none;">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico12.png') }}" alt="icon"> <span>Jewelry &amp; Watches</span> </a>
                          </li>
                          <li class="item-vertical" style="display: none;">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico9.png') }}" alt="icon"> <span>Home &amp; Lights</span> </a>
                          </li>
                          <li class="item-vertical" style="display: none;">
                            <p class="close-menu"> </p> <a href="#" class="clearfix"> <img src="{{ asset('front/image/catalog/menu/icons/ico6.png') }}" alt="icon"> <span>Metallurgy</span> </a>
                          </li>
                          <li class="loadmore"> <i class="fa fa-plus-square-o"></i> <span class="more-view">More Categories</span> </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </nav>
            </div>
          </div> <!-- // end Secondary menu -->
        </div> <!-- Main menu -->
        <div class="main-menu col-lg-10 col-md-9">
          <div class="responsive so-megamenu megamenu-style-dev">
            <nav class="navbar-default">
              <div class=" container-megamenu  horizontal open ">
                <div class="navbar-header"> <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> </div>
                <div class="megamenu-wrapper"> <span id="remove-megamenu" class="fa fa-times"></span>
                  <div class="megamenu-pattern">
                    <div class="container-mega">
                      <ul class="megamenu" data-transition="slide" data-animationtime="250">
                        <li class="home hover"> <a href="{{ url('/') }}">Home <b class="caret"></b></a>
                          <div class="sub-menu" style="width:100%;">
                            <div class="content">
                              <div class="row">
                                <div class="col-md-3"> <a href="{{ url('/') }}" class="image-link"> <span class="thumbnail"> <img class="img-responsive img-border" src="{{ asset('front/image/catalog/menu/home-1.jpg') }}" alt=""> </span>
                                    <h3 class="figcaption"> Home page - (Default) </h3>
                                  </a> </div>
                                <div class="col-md-3"> <a href="home2.html" class="image-link"> <span class="thumbnail"> <img class="img-responsive img-border" src="{{ asset('front/image/catalog/menu/home-2.jpg') }}" alt=""> </span>
                                    <h3 class="figcaption"> Home page - Layout 2 </h3>
                                  </a> </div>
                                <div class="col-md-3"> <a href="home3.html" class="image-link"> <span class="thumbnail"> <img class="img-responsive img-border" src="{{ asset('front/image/catalog/menu/home-3.jpg') }}" alt=""> </span>
                                    <h3 class="figcaption"> Home page - Layout 3 </h3>
                                  </a> </div>
                                <div class="col-md-3"> <a href="home4.html" class="image-link"> <span class="thumbnail"> <img class="img-responsive img-border" src="{{ asset('front/image/catalog/menu/home-4.jpg') }}" alt=""> </span>
                                    <h3 class="figcaption"> Home page - Layout 4 </h3>
                                  </a> </div> <!-- <div class="col-md-15"> <a href="#" class="image-link"> <span class="thumbnail"> <img class="img-responsive img-border" src="image/demo/feature/comming-soon.png" alt=""> </span> <h3 class="figcaption">Comming soon</h3> </a> </div> -->
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="with-sub-menu hover">
                          <p class="close-menu"></p> <a href="#" class="clearfix"> <strong>Features</strong> <img class="label-hot" src="{{ asset('front/image/catalog/menu/new-icon.png') }}" alt="icon items"> <b class="caret"></b> </a>
                          <div class="sub-menu" style="width: 100%; right: auto;">
                            <div class="content">
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="column"> <a href="#" class="title-submenu">Listing pages</a>
                                    <div>
                                      <ul class="row-list">
                                        <li><a href="category.html">Category Page 1 </a> </li>
                                        <li><a href="category-v2.html">Category Page 2</a> </li>
                                        <li><a href="category-v3.html">Category Page 3</a> </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="column"> <a href="#" class="title-submenu">Product pages</a>
                                    <div>
                                      <ul class="row-list">
                                        <li><a href="product.html">Product page 1</a> </li>
                                        <li><a href="product-v2.html">Product page 2</a> </li> <!-- <li><a href="product-v3.html">Image size - small</a></li> -->
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="column"> <a href="#" class="title-submenu">Shopping pages</a>
                                    <div>
                                      <ul class="row-list">
                                        <li><a href="cart.html">Shopping Cart Page</a> </li>
                                        <li><a href="{{route('checkout-details')}}">Checkout Page</a> </li>
                                        <li><a href="compare.html">Compare Page</a> </li>
                                        <li><a href="wishlist.html">Wishlist Page</a> </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="column"> <a href="#" class="title-submenu">My Account pages</a>
                                    <div>
                                      <ul class="row-list">
                                        <li><a href="{{ url('login') }}">Login Page</a> </li>
                                        <li><a href="register.html">Register Page</a> </li>
                                        <li><a href="my-account.html">My Account</a> </li>
                                        <li><a href="order-history.html">Order History</a> </li>
                                        <li><a href="order-information.html">Order Information</a> </li>
                                        <li><a href="return.html">Product Returns</a> </li>
                                        <li><a href="gift-voucher.html">Gift Voucher</a> </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="with-sub-menu hover">
                          <p class="close-menu"></p> <a href="#" class="clearfix"> <strong>Pages</strong> <b class="caret"></b> </a>
                          <div class="sub-menu" style="width: 40%; ">
                            <div class="content">
                              <div class="row">
                                <div class="col-md-6">
                                  <ul class="row-list">
                                    <li><a class="subcategory_item" href="faq.html">FAQ</a> </li>
                                    <li><a class="subcategory_item" href="sitemap.html">Site Map</a> </li>
                                    <li><a class="subcategory_item" href="contact.html">Contact us</a> </li>
                                    <li><a class="subcategory_item" href="banner-effect.html">Banner Effect</a> </li>
                                  </ul>
                                </div>
                                <div class="col-md-6">
                                  <ul class="row-list">
                                    <li><a class="subcategory_item" href="about-us.html">About Us 1</a> </li>
                                    <li><a class="subcategory_item" href="about-us-2.html">About Us 2</a> </li>
                                    <li><a class="subcategory_item" href="about-us-3.html">About Us 3</a> </li>
                                    <li><a class="subcategory_item" href="about-us-4.html">About Us 4</a> </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="with-sub-menu hover">
                          <p class="close-menu"></p> <a href="#" class="clearfix"> <strong>Categories</strong> <img class="label-hot" src="{{ asset('front/image/catalog/menu/hot-icon.png') }}" alt="icon items"> <b class="caret"></b> </a>
                          <div class="sub-menu" style="width: 100%; display: none;">
                            <div class="content">
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="row">
                                    <div class="col-md-3 img img1"> <a href="#"><img src="{{ asset('front/image/catalog/menu/megabanner/image-1.jpg') }}" alt="banner1"></a> </div>
                                    <div class="col-md-3 img img2"> <a href="#"><img src="{{ asset('front/image/catalog/menu/megabanner/image-2.jpg') }}" alt="banner2"></a> </div>
                                    <div class="col-md-3 img img3"> <a href="#"><img src="{{ asset('front/image/catalog/menu/megabanner/image-3.jpg') }}" alt="banner3"></a> </div>
                                    <div class="col-md-3 img img4"> <a href="#"><img src="{{ asset('front/image/catalog/menu/megabanner/image-4.jpg') }}" alt="banner4"></a> </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3"> <a href="#" class="title-submenu">Automotive</a>
                                  <div class="row">
                                    <div class="col-md-12 hover-menu">
                                      <div class="menu">
                                        <ul>
                                          <li><a href="#" class="main-menu">Car Alarms and Security</a> </li>
                                          <li><a href="#" class="main-menu">Car Audio &amp; Speakers</a> </li>
                                          <li><a href="#" class="main-menu">Gadgets &amp; Auto Parts</a> </li>
                                          <li><a href="#" class="main-menu">More Car Accessories</a> </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3"> <a href="#" class="title-submenu">Funitures</a>
                                  <div class="row">
                                    <div class="col-md-12 hover-menu">
                                      <div class="menu">
                                        <ul>
                                          <li><a href="#" class="main-menu">Bathroom</a> </li>
                                          <li><a href="#" class="main-menu">Bedroom</a> </li>
                                          <li><a href="#" class="main-menu">Decor</a> </li>
                                          <li><a href="#" class="main-menu">Living room</a> </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3"> <a href="#" class="title-submenu">Jewelry &amp; Watches</a>
                                  <div class="row">
                                    <div class="col-md-12 hover-menu">
                                      <div class="menu">
                                        <ul>
                                          <li><a href="#" class="main-menu">Earings</a> </li>
                                          <li><a href="#" class="main-menu">Wedding Rings</a> </li>
                                          <li><a href="#" class="main-menu">Men Watches</a> </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3"> <a href="#" class="title-submenu">Electronics</a>
                                  <div class="row">
                                    <div class="col-md-12 hover-menu">
                                      <div class="menu">
                                        <ul>
                                          <li><a href="#" class="main-menu">Computer</a> </li>
                                          <li><a href="#" class="main-menu">Smartphone</a> </li>
                                          <li><a href="#" class="main-menu">Tablets</a> </li>
                                          <li><a href="#" class="main-menu">Monitors</a> </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="">
                          <p class="close-menu"></p> <a href="#" class="clearfix"> <strong>Accessories</strong> </a>
                        </li>
                        <li class="">
                          <p class="close-menu"></p> <a href="blog-page.html" class="clearfix"> <strong>Blog</strong> <span class="label"></span> </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </div> <!-- //end Main menu -->
      </div>
    </div>
  </div> */ ?>
</header>