@extends('layouts.home.app')
@section('title', 'My Dashboard')

@section('page_title')
<style>
  .CollectionGrid-tile {
    width: 25%;
  }

  @media screen and (max-width: 769px) {
    .CollectionGrid-tile {
      width: 50%;
    }
  }
</style>
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Dashboard</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<section class="main-container col2-right-layout">
  <div class="main container">
    <div class="row">
      <section class="col-main col-sm-9 col-xs-12 wow bounceInUp animated" style="visibility: visible;">
        <div class="my-account">
          <div class="dashboard">
            <p class="h3">{{ __('Hello')}}, {{auth('customer')->user()->f_name}}</p>
            <div class="CollectionGrid">
              <a class="CollectionGrid-tile hover-overlay-light" href="{{route('user-account')}}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-user" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                      <path d="M32,36.4c8.2,0,14.9-6.7,14.9-14.9S40.2,6.5,32,6.5s-14.9,6.7-14.9,14.9S23.8,36.4,32,36.4z M32,10 c6.3,0,11.4,5.1,11.4,11.4c0,6.3-5.1,11.4-11.4,11.4c-6.3,0-11.4-5.1-11.4-11.4C20.6,15.2,25.7,10,32,10z" />
                      <path d="M62.1,54.4c-8.3-7.1-19-11-30.1-11s-21.8,3.9-30.1,11C1.1,55,1,56.1,1.7,56.9c0.6,0.7,1.7,0.8,2.5,0.2 c7.7-6.5,17.6-10.1,27.9-10.1s20.2,3.6,27.9,10.1c0.3,0.3,0.7,0.4,1.1,0.4c0.5,0,1-0.2,1.3-0.6C63,56.1,62.9,55,62.1,54.4z" />
                    </g>
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('profile_info')}}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{ route('account-address') }}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-map" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                      <circle cx="32.7" cy="12.9" r="2" />
                      <path d="M58.2,17.9L41.3,14c0.1-0.4,0.1-0.7,0.1-1c0-4.9-3.8-8.8-8.7-8.8C27.9,4.2,24,8.1,24,13c0,1.2,0.5,2.8,1.2,4.5l-2.8,0.6
                    L8.7,14.2c-1.8-0.5-3.7-0.2-5.2,1c-1.5,1.1-2.3,2.8-2.3,4.7v29.6c0,2.6,1.8,5,4.3,5.7l16.8,4.7l19.4-4L55.5,59
                    c0.4,0.1,0.9,0.2,1.3,0.2c1.3,0,2.6-0.4,3.7-1.3c1.4-1.1,2.2-2.8,2.2-4.6V23.6C62.8,20.8,60.9,18.5,58.2,17.9z M32.8,7.7
                    c2.9,0,5.2,2.3,5.2,5.3c0,1.6-2,5.7-5.2,10.6c-3.2-4.8-5.2-8.9-5.2-10.6C27.5,10.1,29.9,7.7,32.8,7.7z M26.9,20.7
                    c1.2,2.1,2.5,4.2,3.8,6.1c0.5,0.7,1.2,1.1,2,1.1c0,0,0,0,0,0c0.8,0,1.6-0.4,2-1.1c1.8-2.7,3.9-5.9,5.2-8.8v34.7l-15.8,3.3V21.3
                    L26.9,20.7z M4.8,49.4V19.9c0-0.8,0.3-1.5,0.9-1.9c0.6-0.5,1.4-0.6,2.1-0.4l12.8,3.6v34.6l-14.1-4C5.5,51.5,4.8,50.5,4.8,49.4z
                    M59.3,53.3c0,0.7-0.3,1.4-0.9,1.9c-0.6,0.5-1.3,0.6-2,0.5l-12.9-3V18l13.9,3.2c1.1,0.3,1.9,1.2,1.9,2.3V53.3z" />
                    </g>
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('address')}}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{route('account-oder') }}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-package" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <path d="M62.5,21.1L57.8,6.6c-0.8-2.5-3.1-4.2-5.7-4.2H12.4c-2.5,0-4.8,1.6-5.6,4L1.6,21c-0.2,0.6-0.3,1.1-0.3,1.7v31.4
                    c0,4.1,3.3,7.4,7.4,7.4h46.7c4.1,0,7.4-3.3,7.4-7.4V22.7C62.8,22.2,62.7,21.7,62.5,21.1z M54.5,7.7l4.1,12.8H33.8V5.9h18.4
                    C53.2,5.9,54.2,6.6,54.5,7.7z M10.1,7.6c0.4-1,1.3-1.7,2.4-1.7h17.8v14.5H5.5L10.1,7.6z M55.3,58.1H8.7c-2.2,0-3.9-1.8-3.9-3.9V23.9
                    h54.5v30.2C59.3,56.3,57.5,58.1,55.3,58.1z" />
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('my_order')}}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{route('chat-with-seller')}}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-comments-alt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                      <path d="M56.8,10H7.2c-3.3,0-6,2.7-6,6V48c0,2.2,1.1,4.1,3,5.2c0.9,0.5,2,0.8,3,0.8c1,0,2-0.3,3-0.8l8.8-5.1
                      c0.4-0.2,0.8-0.3,1.2-0.3h36.5c3.3,0,6-2.7,6-6V16C62.8,12.7,60.1,10,56.8,10z M59.3,41.8c0,1.4-1.1,2.5-2.5,2.5H20.3
                      c-1,0-2.1,0.3-3,0.8l-8.8,5.1l0,0c-0.8,0.4-1.7,0.4-2.5,0c-0.8-0.4-1.2-1.2-1.2-2.1V16c0-1.4,1.1-2.5,2.5-2.5h49.6
                      c1.4,0,2.5,1.1,2.5,2.5V41.8z" />
                      <path d="M44.7,22H17.9c-1,0-1.8,0.8-1.8,1.8s0.8,1.8,1.8,1.8h26.9c1,0,1.8-0.8,1.8-1.8S45.7,22,44.7,22z" />
                      <path d="M40.5,33.3H17.9c-1,0-1.8,0.8-1.8,1.8s0.8,1.8,1.8,1.8h22.7c1,0,1.8-0.8,1.8-1.8S41.5,33.3,40.5,33.3z" />
                    </g>
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('Chat with Seller') }}
                </div>
              </a>
            </div>
            <div class="CollectionGrid" style="margin-top: 20px;">
              <a class="CollectionGrid-tile hover-overlay-light" href="{{route('wishlists')}}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-heart-filled" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <path d="M32,57.6c-0.8,0-1.6-0.3-2.2-0.8c-2.3-2-4.6-3.9-6.6-5.6l0,0c-5.8-4.9-10.9-9.2-14.4-13.4C4.8,33,3,28.6,3,23.7
                    c0-4.7,1.6-9.1,4.6-12.3c3-3.2,7.1-5,11.6-5c3.3,0,6.4,1.1,9.1,3.1c1.1,0.8,2,1.8,2.9,2.9c0.4,0.5,1.1,0.5,1.5,0
                    c0.9-1.1,1.9-2,2.9-2.9c2.7-2.1,5.8-3.1,9.1-3.1c4.5,0,8.6,1.8,11.6,5c3,3.2,4.6,7.6,4.6,12.3c0,4.9-1.8,9.3-5.8,14
                    c-3.5,4.2-8.6,8.5-14.4,13.4c-2,1.7-4.3,3.6-6.6,5.6C33.6,57.3,32.8,57.6,32,57.6z" />
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('wish_list') }}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{ route('account-transaction') }}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-harddrive" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <g>
                      <path d="M47.5,1.3H16.5c-4,0-7.3,3.3-7.3,7.3v46.8c0,4,3.3,7.3,7.3,7.3h31.1c4,0,7.3-3.3,7.3-7.3V8.6C54.9,4.5,51.6,1.3,47.5,1.3z
                      M51.4,55.4c0,2.1-1.7,3.8-3.8,3.8H16.5c-2.1,0-3.8-1.7-3.8-3.8V8.6c0-2.1,1.7-3.8,3.8-3.8h31.1c2.1,0,3.8,1.7,3.8,3.8V55.4z" />
                      <path d="M32.1,20.5c-6.4,0-11.5,5.2-11.5,11.5c0,2.5,0.8,4.9,2.3,6.9c-2.2,1.4-4.2,3-5,4.3c-1,1.7-1.3,3.7-0.8,5.6
                      c0.5,1.9,1.7,3.5,3.4,4.5c1.1,0.7,2.4,1,3.7,1c0.6,0,1.3-0.1,1.9-0.2c1.9-0.5,3.5-1.7,4.5-3.4c0.8-1.4,1.2-4.3,1.3-7
                      c0.1,0,0.1,0,0.2,0c6.4,0,11.5-5.2,11.5-11.5S38.4,20.5,32.1,20.5z M27.5,48.8c-0.5,0.9-1.3,1.5-2.3,1.8c-1,0.3-2,0.1-2.9-0.4
                      c-0.9-0.5-1.5-1.3-1.8-2.3c-0.3-1-0.1-2,0.4-2.9c0,0,0,0,0,0c0.7-1.2,4.3-3.5,7.6-5.4C28.5,43.6,28.1,47.7,27.5,48.8z M32.1,40
                      c0,0-0.1,0-0.1,0c0-1.6,0-2.9-0.1-3.4c0-0.6-0.4-1.1-0.9-1.4c-0.5-0.3-1.2-0.3-1.7,0c-0.6,0.3-1.9,1-3.5,1.9
                      c-1.1-1.4-1.8-3.2-1.8-5c0-4.4,3.6-8,8-8c4.4,0,8,3.6,8,8S36.5,40,32.1,40z" />
                      <path d="M44,48.8c-1.5,0-2.7,1.2-2.7,2.7c0,1.5,1.2,2.7,2.7,2.7c1.5,0,2.7-1.2,2.7-2.7C46.7,50,45.5,48.8,44,48.8z" />
                    </g>
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('My') .' '. __("Transactions") }}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{ route('account-tickets') }}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-headphone-alt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <path d="M62.7,32.9c-0.1-7.6-3.3-14.8-8.8-20.3c-6-5.9-14-9-22.5-8.9C15.1,4.1,1.8,17,1.3,32.9h0V34v6v6.9c0,1.4,1.1,2.6,2.4,2.7
                    l22.2,10.6H32c1,0,1.8-0.8,1.8-1.8S33,56.7,32,56.7h-5.3l-15.5-7.4c0.9-0.5,1.5-1.4,1.5-2.4V35.7c0-1.5-1.2-2.8-2.8-2.8H4.8
                    c0.6-14,12.3-25.4,26.7-25.6c7.5-0.1,14.6,2.6,20,7.9c4.9,4.8,7.6,11.1,7.8,17.8h-5.1c-1.5,0-2.8,1.2-2.8,2.8v11.2
                    c0,1.5,1.2,2.8,2.8,2.8H60c1.5,0,2.8-1.2,2.8-2.8V40v-6.5L62.7,32.9L62.7,32.9z M9.2,46.1H4.8V40v-3.5h4.4V46.1z M59.3,46.1h-4.4
                    v-9.7h4.4V40V46.1z" />
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('support_ticket') }}
                </div>
              </a>
              <a class="CollectionGrid-tile hover-overlay-light" href="{{route('track-order.index')}}">
                <div class="CollectionGrid-tileImage align-center">
                  <svg fill="#000000" width="76" height="76" version="1.1" id="lni_lni-search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <path d="M60.7,50.6L50,39.9c-1.3-1.3-3.1-2.1-5-2.1c-1.3,0-2.6,0.4-3.6,1l-6-6c6.3-7.6,5.9-18.8-1.2-25.9c-7.5-7.5-19.7-7.5-27.2,0
                      c-7.5,7.5-7.5,19.7,0,27.2c3.8,3.8,8.7,5.6,13.6,5.6c4.4,0,8.8-1.5,12.3-4.5l6,6c-0.7,1.1-1,2.3-1,3.6c0,1.9,0.7,3.7,2.1,5
                      l10.7,10.7c1.3,1.3,3.1,2.1,5,2.1c1.9,0,3.7-0.7,5-2.1s2.1-3.1,2.1-5C62.8,53.7,62,51.9,60.7,50.6z M9.4,31.6
                      c-6.1-6.1-6.1-16.1,0-22.3c3.1-3.1,7.1-4.6,11.1-4.6c4,0,8.1,1.5,11.1,4.6c6.1,6.1,6.1,16.1,0,22.3C25.5,37.8,15.5,37.8,9.4,31.6z
                      M58.2,58.2c-1.4,1.4-3.7,1.4-5.1,0L42.4,47.5c-0.7-0.7-1.1-1.6-1.1-2.6c0-1,0.4-1.9,1.1-2.6c0.7-0.7,1.6-1.1,2.6-1.1
                      c0.9,0,1.9,0.4,2.6,1.1l10.7,10.7C59.6,54.5,59.6,56.8,58.2,58.2z" />
                  </svg>
                </div>
                <div class="CollectionGrid-tileName js-dotdotdot">
                  {{ __('Track') .' '. __("Order") }}
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>
      <!--col-main col-sm-9 wow bounceInUp animated-->
      <aside class="col-right sidebar col-sm-3 col-xs-12 wow bounceInUp animated" style="visibility: visible;">
        @include('web-views.users-profile.partials._sidebar')
      </aside>
      <!--col-right sidebar col-sm-3 wow bounceInUp animated-->
    </div>
    <!--row-->
  </div>
  <!--main container-->
</section>
@stop