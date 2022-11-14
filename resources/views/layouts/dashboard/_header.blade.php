<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
  <div class="navbar-container d-flex content">
    <div class="bookmark-wrapper d-flex align-items-center">
      <ul class="nav navbar-nav d-xl-none">
        <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
      </ul>
      <ul class="nav navbar-nav bookmark-icons">
      </ul>
    </div>
    <ul class="nav navbar-nav align-items-center ml-auto">
      <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
          <a class="dropdown-item" href="{{ route('lang', 'en') }}" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a>
          <a class="dropdown-item" href="{{ route('lang', 'fr') }}" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a>
          <a class="dropdown-item" href="{{ route('lang', 'de') }}" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a>
          <a class="dropdown-item" href="{{ route('lang', 'pt') }}" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a>
        </div>
      </li>
      <li class="nav-item d-none d-lg-block">
        <a class="nav-link nav-link-style">
          <i class="ficon" data-feather="moon"></i>
        </a>
      </li>
      <li class="nav-item dropdown dropdown-cart mr-25">
        <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
          <i class="ficon" data-feather="message-circle"></i>
          <!-- <span class="badge badge-pill badge-primary badge-up cart-item-count">0</span> -->
        </a>
      </li>
      <li class="nav-item dropdown dropdown-notification mr-25">
        <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
          <i class="ficon" data-feather="bell"></i>
      </li>
      <li class="nav-item dropdown dropdown-user">
        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="user-nav d-sm-flex d-none">
            @if(auth('admin')->check())
            <span class="user-name font-weight-bolder">{{ auth('admin')->user()->name }}</span>
            <span class="user-status">Admin</span>
          </div><span class="avatar">
            <img class="round" src="{{ asset(auth('admin')->user()->image) ?? url('app-assets/images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="40" width="40">
            <span class="avatar-status-online"></span></span>
          @else
          <span class="user-name font-weight-bolder">{{ auth('seller')->user()->f_name }}</span>
          <span class="user-status">Seller</span>
  </div><span class="avatar">
    <?php $shop = App\Model\Shop::where('seller_id', auth('seller')->user()->id)->first(); ?>
    <img class="round" src="{{ asset($shop->image) ?? url('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40">
    <span class="avatar-status-online"></span></span>
  @endif
  </a>
  <div class="dropdown-menu dropdown-menu-right dropdown-content" aria-labelledby="dropdown-user">
    @if(auth('admin')->check())
    <a class="dropdown-item" href="{{ route('admin.profile.view') }}"><i class="mr-50" data-feather="user"></i> {{ __('profile')}}</a>
    <a class="dropdown-item" href="{{ route('admin.contact.list') }}"><i class="mr-50" data-feather="mail"></i> {{ __('customer_message')}} </a>
    <a class="dropdown-item" href="{{ route('admin.support-ticket.view') }}"><i class="mr-50" data-feather="message-square"></i> {{ __('support_ticket')}}</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('admin.business-settings.seller-settings.index') }}"><i class="mr-50" data-feather="settings"></i> Settings</a>
    <a class="dropdown-item" href="{{ route('admin.subscription.list') }}"><i class="mr-50" data-feather="credit-card"></i> Pricing</a>
    <a class="dropdown-item" href="{{ route('admin.fees.pricing') }}"><i class="mr-50" data-feather="framer"></i> Fees & Pricing</a>
    <a class="dropdown-item" href="{{ route('admin.helpTopic.list') }}"><i class="mr-50" data-feather="help-circle"></i> FAQ</a>
    <a class="dropdown-item" href="{{ route('admin.auth.logout') }}"><i class="mr-50" data-feather="power"></i> Logout</a>
    @else
    <a class="dropdown-item" href="{{ route('seller.profile.view') }}"><i class="mr-50" data-feather="user"></i> {{ __('profile')}}</a>
    <a class="dropdown-item" href="{{ route('seller.reviews.list') }}"><i class="mr-50" data-feather="mail"></i> {{ __('reviews') }}</a>
    <a class="dropdown-item" href="{{route('seller.orders.list',['all'])}}"><i class="mr-50" data-feather="check-square"></i> {{ __('orders') }}</a>
    <a class="dropdown-item" href="{{ route('seller.messages.chat') }}"><i class="mr-50" data-feather="message-square"></i> {{ __('customer_message') }}</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('seller.business-settings.shipping-method.add') }}"><i class="mr-50" data-feather="settings"></i> {{ __('business_settings') }}</a>
    <a class="dropdown-item" href="{{ route('vendor.subscription') }}"><i class="mr-50" data-feather="credit-card"></i> {{ __('Subscription') }}</a>
    <a class="dropdown-item" href="{{ route('seller.fees.pricing') }}"><i class="mr-50" data-feather="framer"></i> Fees & Pricing</a>
    <a class="dropdown-item" href="{{ route('shopView', auth('seller')->id()) }}"><i class="mr-50" data-feather="cpu"></i> View Shop</a>
    <a class="dropdown-item" href="{{ route('seller.auth.logout') }}"><i class="mr-50" data-feather="power"></i> Logout</a>
    @endif
  </div>
  </li>
  </ul>
  </div>
</nav>

<!-- END: Header-->