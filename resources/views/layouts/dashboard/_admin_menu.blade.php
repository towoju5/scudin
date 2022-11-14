<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('vendor.dashboard') }}">
          <span class="brand-logo">
            <img src="{{ website_logo() }}" title="{{ website_title() }}" alt="{{ website_title() }}" />
          </span>
          <h2 class="brand-text">{{ website_title() }}</h2>
        </a></li>
      <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class="nav-item {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.dashboard') }}">
          <i data-feather='monitor'></i>
          <span class="menu-item text-truncate" data-i18n="dashboard">{{ __('Dashboard') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="d-flex align-items-center" href="#">
          <i data-feather="briefcase"></i>
          <span class="menu-title text-truncate" data-i18n="Invoice">{{ __('Products') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('product.index') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('All Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('product.add') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('product.add') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Add New Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('cat.index') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('cat.index') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="Preview">{{ __('Products Categories') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('product.attributes') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('product.attributes') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="Edit">{{ __('Attributes') }}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('order.*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('order.index') }}">
          <i data-feather='shopping-cart'></i>
          <span class="menu-item text-truncate" data-i18n="orders">{{ __('Orders') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('coupon.index') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('coupon.index') }}">
          <i data-feather='gift'></i>
          <span class="menu-item text-truncate" data-i18n="coupons">{{ __('Coupons') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.reports') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.reports') }}">
          <i data-feather='trending-up'></i>
          <span class="menu-item text-truncate" data-i18n="reports">{{ __('Reports') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.delivery.time') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.delivery.time') }}">
          <i data-feather='clock'></i>
          <span class="menu-item text-truncate" data-i18n="delivery-time">{{ __('Delivery Time') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.review') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.review') }}">
          <i data-feather='message-circle'></i>
          <span class="menu-item text-truncate" data-i18n="review">{{ __('Reviews') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.withdraw') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.withdraw') }}">
          <i data-feather='download-cloud'></i>
          <span class="menu-item text-truncate" data-i18n="withdraw">{{ __('Withdraw') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.return.request') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.return.request') }}">
          <i data-feather='repeat'></i>
          <span class="menu-item text-truncate" data-i18n="return-request">{{ __('Return Request') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.analytics') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.analytics') }}">
          <i data-feather='bar-chart'></i>
          <span class="menu-item text-truncate" data-i18n="Analytics">{{ __('Analytics') }}</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.subscription') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.subscription') }}">
          <i data-feather='dollar-sign'></i>
          <span class="menu-item text-truncate" data-i18n="Subscription">{{ __('Subscription') }}</span>
        </a>
      </li>

      <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Invoice</span></a>
        <ul class="menu-content">
          <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">List</span></a>
          </li>
          <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Preview</span></a>
          </li>
          <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">Edit</span></a>
          </li>
          <li><a class="d-flex align-items-center" href="app-invoice-add.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">Add</span></a>
          </li>
        </ul>
      </li>

    </ul>
  </div>
</div>
<!-- END: Main Menu-->