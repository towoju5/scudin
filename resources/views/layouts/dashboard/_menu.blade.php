<!-- BEGIN: Main Menu -->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        @if(auth('admin')->check())
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
          @else
          <a class="navbar-brand" href="{{ route('seller.dashboard') }}">
            @endif
            <!-- <span class="brand-logo">
            <img src="{{ website_logo() }}" title="{{ website_title() }}" alt="{{ website_title() }}" />
          </span> -->
            <h1 class="brand mx-auto" style="color: #e1a006; font-weight:bold;">{{ website_title() }}</h1>
          </a>
      </li>
      <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    @if(auth('admin')->check())
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('admin.dashboard') }}">
          <i data-feather='monitor'></i>
          <span class="menu-item text-truncate" data-i18n="dashboard">{{ __('Dashboard') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('admin/product/*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="#">
          <i data-feather='shopping-bag'></i>
          <span class="menu-title text-truncate" data-i18n="Invoice">{{ __('Products') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ Request::is('admin/product/list/in_house') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{route('admin.product.list',['in_house'])}}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('All Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('admin/product/add-new') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{route('admin.product.add-new')}}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Add New Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('admin/product/list/seller') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('admin.product.list',['seller']) }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Seller Products') }}</span>
            </a>
          </li>

          <li class="nav-item {{ Request::is('admin/product/bulk-import') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('admin.product.bulk-import') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('import_product') }}</span>
            </a>
          </li>

        </ul>
      </li>
      <!-- Pages -->
      <li class="nav-item {{(Request::is('admin/category*') ||Request::is('admin/sub*')) ?'active':''}}">
        <a class="d-flex align-items-center" href="#">
          <i data-feather="briefcase"></i>
          <span class="menu-title text-truncate" data-i18n="Invoice">{{ __('category') }}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">

          <li class="nav-item {{Request::is('admin/category/view')?'active':''}}">
            <a class="nav-link " href="{{route('admin.category.view')}}" title="add new category">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('category')}}</span>
            </a>

          </li>
          <li class="nav-item {{Request::is('admin/sub-category/view')?'active':''}}">
            <a class="nav-link " href="{{route('admin.sub-category.view')}}" title="add new sub-category">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('sub_category')}}</span>
            </a>


          </li>
          <li class="nav-item {{Request::is('admin/sub-sub-category/view')?'active':''}}">
            <a class="nav-link " href="{{route('admin.sub-sub-category.view')}}" title="add new sub-sub-category">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('sub_sub_category')}}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{Request::is('admin/seller*')?'active':''}}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='archive'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Order')}}">{{__('Sellers')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/sellers/seller-list')?'active':''}}">
            <a class="nav-link " href="{{route('admin.sellers.seller-list')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('seller_list')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/sellers/withdraw_list')?'active':''}}">
            <a class="nav-link " href="{{route('admin.sellers.withdraw_list')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Withdraw')}} {{__('List')}}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{Request::is('admin/attr*')?'active':''}}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='box'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Order')}}">{{__('Attributes')}} & {{__('Units')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/attribute/*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.attribute.view')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Attributes')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/units/*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.units.view')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Units')}}</span>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item  {{ Request::is('admin/orders*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='shopping-cart'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Order')}}">{{__('Order')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/orders/list/all')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['all'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('All')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/orders/list/pending')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['pending'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Pending')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/orders/list/processing')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['processing'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Processing')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/orders/list/delivered')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['delivered'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Delivered')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/orders/list/returned')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['returned'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Returned')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/orders/list/failed')?'active':''}}">
            <a class="nav-link " href="{{route('admin.orders.list',['failed'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Failed')}}</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Pages -->
      <li class="nav-item {{ Request::is('admin.coupon.add-new') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('admin.coupon.add-new') }}">
          <i data-feather='gift'></i>
          <span class="menu-item text-truncate" data-i18n="coupons">{{ __('Coupons') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('admin/brand/*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{route('admin.brand.add-new')}}">
          <i data-feather='bold'></i>
          <span class="menu-item text-truncate" data-i18n="List">{{ __('Brand') }}</span>
        </a>
      </li>

      <li class="nav-item {{Request::is('admin/employee*')?'active':''}}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='users'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Employee')}}"> {{__('Employee')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/employee/add-new')?'active':''}}">
            <a class="nav-link " href="{{route('admin.employee.add-new')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('add_new')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/employee/list')?'active':''}}">
            <a class="nav-link " href="{{route('admin.employee.list')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('List')}}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{Request::is('admin/menu*')?'active':''}}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='columns'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Employee')}}"> {{__('Menu')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/menu/add')?'active':''}}">
            <a class="nav-link " href="{{route('admin.menu.add')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('add_new')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/menu/list')?'active':''}}">
            <a class="nav-link " href="{{route('admin.menu.list')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('List')}}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/banner*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.banner.list') }}" title="Pages">
          <i class="fa fa-image"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ __('Banner')}}
          </span>
        </a>
      </li>

      <li class="nav-item {{Request::is('admin/blog*')?'active':''}}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='book'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Blog')}}"> {{__('Blog')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('admin/blog/create')?'active':''}}">
            <a class="nav-link " href="{{route('admin.blog.create')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('add_new')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/blog/index')?'active':''}}">
            <a class="nav-link " href="{{route('admin.blog.index')}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('List')}}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/deal*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="Pages">
          <i class="tio-image nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ __('all_deals')}}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
          <li class="nav-item {{Request::is('admin/deal/flash')?'active':''}}">
            <a class="nav-link " href="{{route('admin.deal.flash')}}" title="add new flash deal">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('flash_deal')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/deal/day')?'active':''}}">
            <a class="nav-link " href="{{route('admin.deal.day')}}" title=" deal List">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('deal_of_the_day')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/deal/feature')?'active':''}}">
            <a class="nav-link " href="{{route('admin.deal.feature')}}" title=" deal List">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('feature_deal')}}</span>
            </a>
          </li>

        </ul>
      </li>


      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/mail/*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="Pages">
          <i class="tio-image nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ __('Send Emails')}}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
          <li class="nav-item {{Request::is('admin/mail/system-wide')?'active':''}}">
            <a class="nav-link " href="{{route('admin.send.mail')}}" title="add new flash deal">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('General Email')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/mail/mail-user')?'active':''}}">
            <a class="nav-link " href="{{route('admin.user.send.mail')}}" title=" deal List">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Mail Single User')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/mail/mail-seller')?'active':''}}">
            <a class="nav-link " href="{{route('admin.seller.send.mail')}}" title=" deal List">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Mail Single Seller')}}</span>
            </a>
          </li>

        </ul>
      </li>


      <!-- End Pages -->
      <li class="nav-item {{Request::is('admin/customer/*')?'active':''}}">
        <a class="d-flex align-items-center" href="{{ route('admin.customer.list') }}">
          <i class="tio-poi-user nav-icon"></i>
          <span class="menu-item text-truncate" data-i18n="reports">{{ __('Customer')}} {{ __('List')}}</span>
        </a>
      </li>


      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/reviews*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.reviews.list')}}" title="Pages">
          <i class="tio-star nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ __('Product')}} {{ __('Reviews')}}
          </span>
        </a>
      </li>

      <!-- Pages -->
      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/contact*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.contact.list')}}" title="Pages">
          <i class="tio-messages nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ __('customer_message')}}
          </span>
        </a>
      </li>

      <!-- End Pages -->

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/support-ticket*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.support-ticket.view')}}" title="Pages">
          <i class="tio-chat nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
            {{ __('support_ticket')}}
          </span>
        </a>
      </li>

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings*')||Request::is('admin/currency*')|| Request::is('admin/helpTopic*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="Pages">
          <i class="tio-settings nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ __('business_settings')}}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
          <li class="nav-item {{Request::is('admin/business-settings/mail')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.mail.index')}}" title=" mail config">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('mail_config')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/mail-update')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.mail-settings')}}" title=" mail config">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Mail')}} {{ __('Templates')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/shipping-method/add')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.shipping-method.add')}}" title=" shippitng method">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('shipping_method')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/currency/view')?'active':''}}">
            <a class="nav-link " href="{{route('admin.currency.view')}}" title="add new currency">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Currency')}}</span>
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu {{Request::is('admin/colors*')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.colors') }}" title="Colors">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Colors')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/payment-method')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.payment-method.index')}}" title="add new payment method">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('payment_method')}}</span>
            </a>
          </li>
          {{--<a class="collapse-item {{Request::is('admin/business-settings/sms*')?'active':''}}"
          href="{{route('admin.business-settings.sms-gateway.index')}}">{{ __('sms_gateway')}}</a>--}}

          <li class="nav-item {{Request::is('admin/helpTopic/list')?'active':''}}">
            <a class="nav-link " href="{{route('admin.helpTopic.list')}}" title="add new Faq">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('faq')}}</span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/promotion/*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.promotion.list')}}" title="Promotion Plan">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Promotion Plan')}}</span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/business-settings/about-us')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.about-us')}}" title="add new about us">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('about_us')}}</span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/business-settings/terms-condition')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.terms-condition')}}" title="add new about us">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('terms_and_condition')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/privacy-policy')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.privacy-policy')}}" title="privacy_policy">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('privacy_policy')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/return-policy')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.return-policy')}}" title="return_policy">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('return_policy')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/units/*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.units.view')}}" title="add new  units">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('units')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/web-config')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.web-config.index')}}" title="change web config">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('web_config')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('admin/business-settings/fcm-index')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.fcm-index')}}" title="add new banner">
              <i data-feather="circle"></i>
              <span class="text-truncate">Push Notification</span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/business-settings/social-media')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.social-media')}}" title="change social media">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('social_media')}}</span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/business-settings/seller-settings*')?'active':''}}">
            <a class="nav-link " href="{{route('admin.business-settings.seller-settings.index')}}" title="change seller settings">
              <i data-feather="circle"></i>
              <!-- <span class="text-truncate">{{ __('seller_settings')}}</span> -->
              <span class="text-truncate">Enviroment Settings</span>
            </a>
          </li>

        </ul>
      </li>

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="Pages">
          <i class="tio-report-outlined nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ __('Report')}}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
          <li class="nav-item {{Request::is('admin/report/earning')?'active':''}}">
            <a class="nav-link " href="{{route('admin.report.earning')}}" title="add new banner">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{ __('Earning')}} {{ __('Report')}} </span>
            </a>
          </li>

          <li class="nav-item {{Request::is('admin/report/order')?'active':''}}">
            <a class="d-flex align-items-center" href="{{route('admin.report.order')}}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="reports">{{ __('Order')}} {{ __('Report')}} </span>
            </a>
          </li>

        </ul>
      </li>

      <li class="navbar-vertical-aside-has-menu {{Request::is('admin/plans*')?'active':''}}">
        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="Pages">
          <i class="dollar-sign nav-icon"></i>
          <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ __('Subscription')}}</span>
        </a>
        <ul class="js-navbar-vertical-aside-submenu nav nav-sub">

          <li class="navbar-vertical-aside-has-menu {{Request::is('admin/plans/list')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.subscription.list') }}" title="Pages">
              <i data-feather="circle"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                {{ __('Subscription Plans')}}
              </span>
            </a>
          </li>

          <li class="navbar-vertical-aside-has-menu {{Request::is('admin/plans/sub-list')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.subscription.sub.list') }}" title="Pages">
              <i data-feather="circle"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                {{ __('List of Subscribers')}}
              </span>
            </a>
          </li>

        </ul>
      </li>

    </ul>
    @elseif(auth('seller')->check())
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="nav-item {{ Request::is('seller/dashboard') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('seller.dashboard') }}">
          <i data-feather='monitor'></i>
          <span class="menu-item text-truncate" data-i18n="dashboard">{{ __('Dashboard') }}</span>
        </a>
      </li>
      <li class="nav-item  {{ Request::is('seller/product*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather="briefcase"></i>
          <span class="menu-title text-truncate" data-i18n="Invoice">{{ __('Products') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ Request::is('seller/product/list') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('seller.product.list') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('All Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('seller.product.add-new') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('seller.product.add-new') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Add New Products') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('seller/product/bulk-import') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('seller.product.bulk-import') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('import_product') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('seller/product/sponsor-product') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route('seller.product.promote') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Sponsored Product') }}</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- Orders -->
      <li class="nav-item  {{ Request::is('seller/orders*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="javascript:">
          <i data-feather='shopping-cart'></i>
          <span class="menu-title text-truncate" data-i18n="{{__('Order')}}">{{__('Order')}}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{Request::is('seller/orders/list/all')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['all'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('All')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('seller/orders/list/pending')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['pending'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Pending')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('seller/orders/list/processing')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['processing'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Processing')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('seller/orders/list/delivered')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['delivered'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Delivered')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('seller/orders/list/returned')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['returned'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Returned')}}</span>
            </a>
          </li>
          <li class="nav-item {{Request::is('seller/orders/list/failed')?'active':''}}">
            <a class="nav-link " href="{{route('seller.orders.list',['failed'])}}" title="">
              <i data-feather="circle"></i>
              <span class="text-truncate">{{__('Failed')}}</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Orders -->

      <li class="nav-item {{ Request::is('seller/coupon*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('seller.coupon.add-new') }}">
          <i data-feather='gift'></i>
          <span class="menu-item text-truncate" data-i18n="coupons">{{ __('Coupons') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/shop/reports') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.reports') }}">
          <i data-feather='trending-up'></i>
          <span class="menu-item text-truncate" data-i18n="reports">{{ __('Reports') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/shop/delivery') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.delivery.time') }}">
          <i data-feather='clock'></i>
          <span class="menu-item text-truncate" data-i18n="delivery-time">{{ __('Delivery Time') }}</span>
        </a>
      </li>
      <li class="nav-item  {{Request::is('seller/messages*')?'active':''}}">
        <a class="d-flex align-items-center" href="{{ route('seller.messages.chat') }}">
          <i class="tio-email nav-icon"></i>
          <span class="menu-item text-truncate" data-i18n="review">{{ __('messages') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/reviews/list') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('seller.reviews.list') }}">
          <i data-feather='message-circle'></i>
          <span class="menu-item text-truncate" data-i18n="review">{{ __('Reviews') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/withdraw/*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('seller.withdraw.index') }}">
          <i data-feather='download-cloud'></i>
          <span class="menu-item text-truncate" data-i18n="withdraw">{{ __('Withdraw') }}</span>
        </a>
      </li> {{--
      <li class="nav-item  {{Request::is('seller/orders/list/returned')?'active':''}}">
      <a class="d-flex align-items-center" href="{{ route('seller.orders.list', ['returned']) }}">
        <i data-feather='repeat'></i>
        <span class="menu-item text-truncate" data-i18n="return-request">{{ __('Return Request') }}</span>
      </a>
      </li> --}}

      <li class="{{Request::is('seller/business-settings*')||Request::is('seller/currency*')|| Request::is('seller/helpTopic*')?'active':''}} nav-item">
        <a class="d-flex align-items-center" href="#">
          <i class="tio-settings nav-icon"></i>
          <span class="menu-title text-truncate" data-i18n="Invoice">{{ __('business_settings') }}</span>
        </a>
        <ul class="menu-content">
          <li class="{{Request::is('seller/business-settings/shipping-method/add')?'active':''}}">
            <a class="d-flex align-items-center" href="{{ route('seller.business-settings.shipping-method.add') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('shipping_method') }}</span>
            </a>
          </li>
          <li class="{{Request::is('seller/shop/view')?'active':''}}">
            <a class="d-flex align-items-center" href="{{ route('seller.shop.view') }}">
              <i data-feather="circle"></i>
              <span class="menu-item text-truncate" data-i18n="List">{{ __('Shop Info') }}</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ Request::is('seller/shop/staff') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('staff.index') }}">
          <i data-feather='users'></i>
          <span class="menu-item text-truncate" data-i18n="return-request">{{ __('Staff') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/shop/analytics') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.analytics') }}">
          <i data-feather='bar-chart'></i>
          <span class="menu-item text-truncate" data-i18n="Analytics">{{ __('Analytics') }}</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('seller/shop/subscription') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route('vendor.subscription') }}">
          <i data-feather='dollar-sign'></i>
          <span class="menu-item text-truncate" data-i18n="Subscription">{{ __('Subscription') }}</span>
        </a>
      </li>
    </ul>
    @endif
  </div>
</div>
<!-- END: Main Menu-->
@push('js')
<script>
  $(document).ready(function() {
    $('table').DataTable();
  });
</script>
@endpush