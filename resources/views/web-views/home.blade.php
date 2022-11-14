@extends('layouts.home.app')

@section('title', '')

@section('content')

@php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
<div id="myCarousel" class="carousel slide">
  <!-- Items -->
  <div class="carousel-inner" style="margin-top: 0px;">
    <!-- Item 1 -->
    @foreach($main_banner as $key=>$banner)
    <div class="item @if($key == 0) active @endif item_height">
      <img src="{{ $banner->photo }}" width="100%" />
      <div class="container">
        <div class="carousel-caption">
          <p>{!! $banner->url !!}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<div class="content">
  <section class="main-container col2-left-layout bounceInUp animated">
    <div class="container-fluid">
    <div class="row">
        @foreach($cat_based as $cats)
        @if(count($cats->products) < 3 && count($cats->products) > 0)
        <div class="col-sm-3 equal">
          <div class="col-12 equal">
            <div class="panel panel-default panel-card">
              <h3 class="modtitle text-dark" style="color: #000; font-weight: bold"><span>{{ $cats->name }}</span></h3>
              <div class="panel-thumbnails">
                <div class="sv">
                  @foreach($cats->products->take(4) as $cat)
                  <div class="p_item">
                    <div class="thumbnail">
                      <a href="{{ route('products', ['id'=> $cat->id, 'data_from'=>'category', 'page'=>1]) }}" title="{{$cat->name}}" target="_self">
                        <img src="{{ asset($cat->icon) }}" style="height: 130px; width: 150px;">
                      </a>
                      <p style="margin-top: 15px;">
                        <a href="{{ route('products', ['id'=> $cat->id, 'data_from'=>'category', 'page'=>1]) }}" title="{{$cat->name}}" target="_self"> {{$cat->name}} </a>
                      </p>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      <div class="row">
   
        @foreach($cat_based as $cats)
        @if(count($cats->products) >= 3)
        <div class="col-sm-3 equal">
          <div class="col-12 equal">
            <div class="panel panel-default panel-card">
              <h3 class="modtitle text-dark" style="color: #000; font-weight: bold"><span>{{ $cats->name }}</span></h3>
              <div class="panel-thumbnails">
                <div class="sv">
                  @foreach($cats->products->take(4) as $cat)
                  <div class="p_item">
                    <div class="thumbnail">
                      <a href="{{ route('products', ['id'=> $cat->id, 'data_from'=>'category', 'page'=>1]) }}" title="{{$cat->name}}" target="_self">
                        <img src="{{ asset($cat->icon) }}" style="height: 130px; width: 150px;">
                      </a>
                      <p style="margin-top: 15px;">
                        <a href="{{ route('products', ['id'=> $cat->id, 'data_from'=>'category', 'page'=>1]) }}" title="{{$cat->name}}" target="_self"> {{$cat->name}} </a>
                      </p>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>

      <!-- ============================================== SCROLL TABS ============================================== -->
      @if (!empty($featured_products))
      <!-- <div class="panel panel-heading"></div> -->
      <div class="row" style="margin-bottom: 25px;">
        <div id="best-seller" class="product-flexslider hidden-buttons">
          <div class="slider-items slider-width-col4 products-grid">
            @foreach($featured_products as $key => $viewed)
            <!-- Item -->
            <div class="item">
              <div class="item-inner">
                <div class="item-img">
                  <div class="item-img-info">
                    <a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}" class="product-image">
                      <img src="{{ asset($viewed->thumbnail) }}" alt="{{ $viewed->name }}">
                    </a>
                  </div>
                </div>
                <div class="item-info" style="padding:10px">
                  <div class="info-inner">
                    <div class="item-title">
                      <a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}">
                        {{ Str::limit($viewed->name, 25) }}
                      </a>
                      <p>
                        <strong style="padding-bottom: 10px;">
                          {{ \App\CPU\Helpers::currency_converter( $viewed->unit_price-(\App\CPU\Helpers::get_product_discount($viewed, $viewed->unit_price)) )}}
                        </strong>
                      </p>
                    </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <p class="rating-links">
                          </p>
                        </div>
                      </div>
                      <div class="item-price">
                        <div class="price-box">
                          <span class="regular-price">
                            <span class="price">
                              sponsored
                            </span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Item -->
            @endforeach
          </div>
        </div>
      </div>
      @endif


      <div class="row">
        {{--flash deal--}}
        <?php
        $flash_deals = \App\Model\FlashDeal::with(['products.product.reviews'])->where(['status' => 1])->where(['deal_type' => 'flash_deal'])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first()
        ?>

        @if(!empty($flash_deals) > 0)
        <div class="col-md-3">
          @if (isset($flash_deals))
          <div class="box-additional">
            <!-- begin  flash deals -->
            <div class="related-pro">
              <div class="slider-items-products">
                <div id="related-slider" class="hidden-buttons">
                  <div style="opacity: 1; display: block;">
                    <div class="owl-wrapper-outer">
                      <!-- <div class="owl-wrapper" style="width: 3816px; left: 0px; display: block;"> -->
                      @foreach($flash_deals->products as $key=>$deal)
                      
                      <?php ($overallRating = \App\CPU\ProductManager::get_overall_rating(isset($deal)?$deal->product->reviews:null)); 
                      $countDown = date("M j, Y H:i:s", strtotime($flash_deals['end_date'])) ?>
                      <div class="owl-item" style="width: 309px;">
                        <div class="item" style="float: none;">
                          <div class="item-inner" style="padding: 10px;">
                            <div class="item-img">
                              <div class="item-img-info">
                                <a href="{{ route('product',$deal->product->slug) }}" title="{{ $deal->product['name'] }}" class="product-image">
                                  <img src="{{ $deal->product['thumbnail'] }}" alt="{{ $deal->product['name'] }}">
                                </a>
                              </div>
                            </div>
                            <div class="item-info">
                              <div class="info-inner">
                                <div class="item-title">
                                  <a href="{{ route('product',$deal->product->slug) }}" title="{{ $deal->product['name'] }}">{{ Str::limit($deal->product['name'], 25) }}</a>
                                </div>
                                <div class="item-content">
                                  <div class="ratings">
                                    <div class="rating-box">
                                      <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                                    </div>
                                    <p class="rating-links">
                                      {{\App\CPU\Helpers::currency_converter($deal->product->unit_price-\App\CPU\Helpers::get_product_discount($deal->product,$deal->product->unit_price))}}
                                    </p>
                                  </div>
                                  <div class="item-price">
                                    <div class="price-box" id="demo">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      <!-- </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end flash deals -->
          </div>
          @endif
        </div>
        <div class="col-md-9">
          @else
          <div class="col-md-12">
            @endif
            @if (!empty($recentlyViewed))
            <!-- Recently viewed Products -->
            @if (count($recentlyViewed) == -1)
            <div class="box-additional">
              <div class="related-pro">
                <div class="slider-items-products">
                  <div id="related-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col4 products-grid">
                      @foreach($recentlyViewed as $key => $viewed)
                      @php($overallRating = get_overall_rating($viewed->reviews))
                      <div class="item" style="width: 309px;">
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info">
                              <a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}" class="product-image">
                                <img src="{{ asset($viewed->thumbnail) }}" height="250px" width="200px" alt="{{ $viewed->name }}"></a>
                            </div>
                          </div>
                          <div class="item-info" style="padding:10px">
                            <div class="info-inner">
                              <div class="item-title"><a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}">{{ Str::limit($viewed->name, 25) }}</a> </div>
                              <div class="item-content">
                                <div class="rating">
                                  <div class="ratings">
                                    <div class="rating-box">
                                      <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                                    </div>
                                    <p class="rating-links">
                                      {{\App\CPU\Helpers::currency_converter( $viewed->unit_price-(\App\CPU\Helpers::get_product_discount($viewed, $viewed->unit_price)) )}}
                                    </p>
                                  </div>
                                </div>
                                <div class="item-price">
                                  <div class="price-box">
                                    Sponsored
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @endif
          </div>
        </div>
      </div>
  </section>
</div>


@endsection

@push('css')
<style>
  .item_height {
    max-height: 250px;
  }

  .p_item {
    width: 50%
  }

  .sv {
    display: flex;
    flex-wrap: wrap;
  }

  .sv>div {
    flex: 50%;
    margin-bottom: 10px;
  }

  .equal {
    display: flex;
    display: -webkit-flex;
    flex-wrap: wrap;
  }

  .thumbnail,
  .modtitle {
    padding: 10px;
    border: none;
    text-align: center;
  }

  .modtitle {
    text-align: left;
  }

  .thumbnail>img {
    max-height: 120px;
  }

  .main-container {
    padding-top: 20px;
  }

  .panel-default {
    border: none;
  }

  .thumbnail>img {
    height: 150px;
  }

  /* Global */


  img {
    max-width: 100%;
  }

  a {
    -webkit-transition: all 150ms ease;
    -moz-transition: all 150ms ease;
    -ms-transition: all 150ms ease;
    -o-transition: all 150ms ease;
    transition: all 150ms ease;
  }

  a:hover {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
    /* IE 8 */
    filter: alpha(opacity=50);
    /* IE7 */
    opacity: 0.6;
    text-decoration: none;
  }

  .thumbnails li>.fff .caption {
    background: #fff !important;
    padding: 10px
  }

  /* Page Header */
  .page-header {
    background: #f9f9f9;
    margin: -30px -40px 40px;
    padding: 20px 40px;
    border-top: 4px solid #ccc;
    color: #999;
    text-transform: uppercase;
  }

  .page-header h3 {
    line-height: 0.88rem;
    color: #000;
  }

  ul.thumbnails {
    margin-bottom: 0px;
  }



  /* Thumbnail Box */
  .caption h4 {
    color: #444;
  }

  .caption p {
    color: #999;
  }



  /* Carousel Control */
  .control-box {
    text-align: right;
    width: 100%;
  }

  /* Mobile Only */
  @media (max-width: 767px) {

    .page-header,
    .control-box {
      text-align: center;
    }
  }

  @media (max-width: 479px) {
    .caption {
      word-break: break-all;
    }
  }


  li {
    list-style-type: none;
  }

  ::selection {
    background: #ff5e99;
    color: #FFFFFF;
    text-shadow: 0;
  }

  ::-moz-selection {
    background: #ff5e99;
    color: #FFFFFF;
  }
</style>
@endpush

@push('js')
<script type="text/javascript" src="https://brm.io/js/libs/matchHeight/jquery.matchHeight.js"></script>
<script>
  $(function() {
    $('.equal').matchHeight();
  });
  $(function() {
    $('#myCarousel').carousel({
      interval: 5000,
      pause: "true"
    });
  });
  // Carousel Auto-Cycle
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 1000
    })
  });
  
var __date = "{{ $countDown ?? NULL }}";
// Set the date we're counting down to
var countDownDate = new Date(__date).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
  
</script>

@endpush
