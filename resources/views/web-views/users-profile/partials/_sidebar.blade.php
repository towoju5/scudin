<div class="block block-account">
  <div class="block-title"> My Account </div>
  <div class="block-content">
    <ul>
      <li><a class="{{ Request::is('dashboard*')?'active-menu':'' }}" href="{{ route('dashboard') }}"><span>Account Dashboard</span></a></li>
      <li><a class="{{ Request::is('plans/*')?'active-menu':'' }}" href="{{ route('plans.list') }}"><span>Subscription Plans</span></a></li>
      <li><a class="{{Request::is('user-account*')?'active-menu':''}}" href="{{route('user-account')}}"><span> {{ __('profile_info')}} </span></a></li>
      <li><a class="{{Request::is('account-address*')?'active-menu':''}}" href="{{ route('account-address') }}"><span> {{ __('address')}} </span></a></li>
      <li><a class="{{Request::is('account-oder*') || Request::is('account-order-details*') ? 'active-menu' :''}}" href="{{route('account-oder') }}"><span> {{ __('my_order')}} </span></a></li>
      <li><a class="{{Request::is('chat*')?'active-menu':''}}" href="{{route('chat-with-seller')}}"><span> {{ __('Chat with Seller') }}</span></a></li>
      <!-- <li><a href="#"><span> Recurring Profiles</span></a></li>
      <li><a href="#"><span> My Product Reviews</span></a></li> -->
      <li><a class="{{Request::is('wishlists*')?'active-menu':''}}" href="{{route('wishlists')}}"><span> {{ __('wish_list') }} </span></a></li>
      <li><a class="{{Request::is('account-transaction*')?'active-menu':''}}" href="{{ route('account-transaction') }}"><span> {{ __('My') . __("Transactions") }} </span></a></li>
      <li><a class="{{(Request::is('account-ticket*') || Request::is('support-ticket*'))?'active-menu':''}}" href="{{ route('account-tickets') }}"><span> {{ __('support_ticket') }} </span></a></li>
      <li class="last"><a class="{{Request::is('track-order*')?'active-menu':''}}" href="{{route('track-order.index')}}"><span>{{ __('Track') . __("Order") }}</span></a></li>
    </ul>
  </div>
  <!--block-content-->
</div>

<style>
  .active-menu>span {
    color: blue;
  }
</style>