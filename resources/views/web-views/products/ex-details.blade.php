@extends('layouts.home.app')

@section('title', $product->name)
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/cloudzoom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('home/stylesheet/cloudzoom.css') }}">

<meta name="description" content="{{$product->slug}}">
<meta name="keywords" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.','}} @endforeach">
@if($product->added_by=='seller')
<meta name="author" content="{{ $product->seller->shop ? $product->seller->shop->name : $product->seller->f_name}}">
@elseif($product->added_by=='admin')
<meta name="author" content="{{$web_config['name']}}">
@endif
<!-- Viewport-->
<meta property="og:image" content='{{ asset($product->thumbnail) }}'>
<meta property="og:title" content="{{$product->name}}" />
<meta property="og:url" content="{{route('product',[$product->slug])}}">
<meta property="og:description" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.','}} @endforeach">

<meta property="twitter:card" content='{{ asset($product->thumbnail) }}'>
<meta property="twitter:title" content="{{$product->name}}" />
<meta property="twitter:url" content="{{route('product',[$product->slug])}}">
<meta property="twitter:description" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.','}} @endforeach">
<style>
  .owl-item {
    max-width: 200px !important;
    margin: 10px;
  }

  .modal {
    text-align: center;
  }

  @media screen and (min-width: 768px) {
    .modal:before {
      display: inline-block;
      vertical-align: middle;
      content: " ";
      height: 100%;
    }
  }

  .modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
  }

  .modal-backdrop.fade,
  .modal-backdrop.fade.in {
    opacity: 0.7 !important;
  }

  /* div that surrounds Cloud Zoom image and content slider. */
  /* #surround {
    width: 100%;
    min-width: 256px;
    max-width: 480px;
  } */

  /* Image expands to width of surround */
  img.cloudzoom {
    width: 100%;
    height: 400px;
  }


  input[type="radio"] {
    appearance: none;
    border: 1px solid #d3d3d3;
    width: 30px;
    height: 30px;
    content: none;
    outline: none;
    margin: 0;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  }

  input[type="radio"]:checked {
    appearance: none;
    outline: none;
    padding: 0;
    content: none;
    border: none;
  }

  input[type="radio"]:checked::before {
    position: absolute;
    color: green !important;
    content: "\00A0\2713\00A0" !important;
    border: 1px solid #d3d3d3;
    font-weight: bolder;
    font-size: 21px;
  }

  .pabel-body {
    padding: 15px;
  }

  .add-to-box {
    padding-top: 0px !important;
  }

  .short-description {
    padding-bottom: 0px !important;
  }
</style>
@endpush

@section('content')
<?php
if (!empty($product)) {
  $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
  $rating = \App\CPU\ProductManager::get_rating($product->reviews);
}
?>

<div class="main-container col1-layout wow bounceInUp animated">
  <div class="main">
    <div class="col-main">
      <!-- Endif Next Previous Product -->
      <div class="product-view wow bounceInUp animated" itemscope="" itemtype="http://schema.org/Product" itemid="#product_base">
        <div id="messages_product_view"></div>
        <!--product-next-prev-->
        <div class="product-essential container">
          <div class="row">
            <div class="product-next-prev"> <a class="product-next" title="Next" href="#"></a> <a class="product-prev" title="Previous" href="#"></a> </div>
            <!--End For version 1, 2, 6 -->
            <!-- For version 3 -->
            <div class="product-img-box col-sm-5 col-xs-12">
              <div class="new-label new-top-left"> New </div>
              <p class="availability in-stock">
                <link itemprop="availability">
                @if($product->current_stock > 0)
                <span>In stock</span>
                @else
                <span>Out of stock</span>
                @endif
              </p>
              @if($product->images!=null)
              @php $photos = json_decode($product->images) @endphp
              <div class="product-image" id="surround">
                <!-- <div class="large-image">
                  <a href="javascript:void;" class="cloud-zoom"> -->
                <img class="cloudzoom" width="100%" height="400px" alt="Cloud Zoom small image" id="zoom1" src='{{asset("storage/app/public/product/$photos[0]")}}'>
                <!-- </div> -->
                <div class="carousel-inner" role="listbox">
                  <div class="item active">
                    <div class="flexslider flexslider-thumb">
                      <ul class="previews-list slides" id="slider1">
                        @foreach ($photos as $key => $photo)
                        <li>
                          <!-- <a href="javascript:void" class='cloud-zoom-gallery'> -->
                          <?php $_img = "storage/app/public/product/$photo" ?>
                          <img class='cloudzoom-gallery' src='{{asset($_img)}}' data-cloudzoom="useZoom:'.cloudzoom', image:'<?= asset($_img) ?>' ">
                          <!-- </a> -->
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              <!-- end: more-images -->
            </div>
            <!-- For version 3 -->
            <div class="product-shop col-sm-7 col-xs-12">

              <div class="product-name">
                <h1 itemprop="name">{{ $product->name }} </h1>
              </div>
              <!--product-name-->
              <div itemprop="aggregateRating">
                <div class="rating" title="{{ $overallRating[0] * 20 }}% From {{$overallRating[1]}} Reviews">
                  <div class="ratings">
                    <div class="rating-box">
                      <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                    </div> <span>| Total of {{$overallRating[1]}} Reviews</span>
                  </div>
                </div>
              </div>
              <div class="price-block">

              </div>
              <!--price-block-->
              <div class="short-description">
                <h2>Quick Overview</h2>
                <div class="product-label form-group">
                  <div class="product_page_price price">
                    <span class="price-new" itemprop="price">{{\App\CPU\Helpers::get_price_range($product) }}</span>
                  </div>
                  @if($product->added_by=='seller')
                  <div class="stock"><span>Sold By:</span>
                    <a href="{{ route('shopView',[$product->seller->id]) }}">
                      <span class="status-stock">{{$product->seller->shop->name}}</span>
                    </a>
                  </div>
                  @endif
                </div>
                <div class="product-box-desc">
                  <div class="inner-box-desc">
                    <div class="price-tax">
                      <span>Tax:</span>
                      {{ \App\CPU\Helpers::currency_converter( \App\CPU\Helpers::tax_calculation($product->unit_price,$product->tax,$product->tax_type) )}} ( {{$product['tax']}}%)
                    </div>
                    @if($product->discount > 0)
                    <div class="reward">
                      Discount : {{\App\CPU\Helpers::currency_converter(\App\CPU\Helpers::get_product_discount($product,$product['unit_price']))}}
                    </div>
                    @endif
                    <div class="brand"><span>Brand: </span><a href="#">{{ @$product->brand->name }}</a> </div>
                    <div class="model"><span>Product Code:</span> Product-{{ $product->id }}</div>
                    @if($product->discount > 0)
                    <div class="reward"><span>Discount:</span> {{\App\CPU\Helpers::currency_converter(\App\CPU\Helpers::get_product_discount($product,$product['unit_price']))}}</div>
                    @endif
                  </div>
                </div>


              </div>
              <div class="add-to-box">
                <form id="add-to-cart-form">
                  @csrf
                  <div id="product">
                    
                    <div id="row" style="padding-bottom: 10;">
                      <div class="mt-2 mb-2">
                        <div class="card-header" id="headingTwo">
                          <h5 class="mb-0">
                            <a href="javascript:" style="font-size: 15px" class="active" data-toggle="modal" data-target="#myModal" aria-expanded="false" aria-controls="collapseTwo">
                              {{ __('Select')}} {{ __('shipping_method')}}
                            </a>
                          </h5>
                          <!-- Modal -->
                          <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-md">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <!-- modal header  -->
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title" style="padding-bottom: 15;">Select Shipping Method</h4>

                                </div>
                                <div class="modal-body">
                                  <ul class="list-group">
                                    @if($product->added_by == "admin" || check_ethos($product->seller->id) !== false)
                                    <li class="list-group-item" style="cursor: pointer;" onclick="$('#sh-1').prop( 'checked', true )">
                                      <input type="radio" name="shipping_method_id" class="_shipping" id="sh-1" value="1">
                                      <span class="checkmark" style="margin-right: 10px"></span> Ethos Free Shipping
                                    </li>
                                    @endif
                                    @foreach(\App\CPU\ProductManager::get_shipping_methods($product) as $key => $shipping)
                                      <?php //var_dump($shipping) ?>
                                      <li class="list-group-item" style="cursor: pointer;" onclick="$('#sh-{{$shipping->id}}').prop( 'checked', true )">
                                      <input type="radio" name="shipping_method_id" class="_shipping" id="sh-{{$shipping['id']}}" value="{{$shipping['id']}}">
                                      <span class="checkmark" style="margin-right: 10px"></span>
                                      {{$shipping['title']}}
                                    </li>
                                    @endforeach
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- //Modal -->
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="required">
                      @if (count(json_decode($product->colors)) > 0)
                      <h4 style="padding-bottom: 10px;">Available Options</h4>
                      <p style="color: #000;">Colors</p>
                      <span class="product-options" id="input-option231">
                        @foreach (json_decode($product->colors) as $key => $color)
                        <label>
                          <input class="image_radio" type="radio" name="color" value="{{ $color }}" checked id="" title="{{ $color }}" style="background-color: <?= $color ?>">
                        </label>
                        @endforeach
                        </select>
                      </span>
                      @endif
                      @php
                      $qty = 0;
                      if(!empty($product)){
                      foreach (json_decode($product->variation) as $key => $variation) {
                      $qty += $variation->qty;
                      }
                      }
                      @endphp
                    </div>
                    <div class="form-group box-info-product" style="padding-left: 15px;">
                      @foreach (json_decode($product->choice_options) as $key => $choice)
                      <div class="row no-gutters">
                        <div class="col-3">
                          <div class="product-description-label mt-2">{{ $choice->title }}:
                          </div>
                        </div>
                        <div class="col-12">
                          <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                            @foreach ($choice->options as $key => $option)
                            <li class="for-mobile-capacity">
                              <label class="h4" for="{{ $choice->name }}-{{ $option }}">
                                <input type="radio" id="{{ $choice->name }}-{{ $option }}" name="{{ $choice->name }}" value="{{ $option }}" @if($key==0) checked @endif>
                                {{ $option }}
                              </label>
                            </li>
                            @endforeach
                          </ul>
                          <div class="h4" id="chosen_price_div" hidden>
                            {{ __('Total Price') }}: <strong id="chosen_price"></strong>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    
                  </div>

                  <div class="add-to-cart">
                    <div class="pull-left">
                      <div class="custom pull-left">
                        <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus"></i></button>
                        <input type="text" name="quantity" id="qty" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                        <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) && qty != 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus"></i></button>
                      </div>
                      <!--custom pull-left-->
                    </div>
                    <!--pull-left-->
                    <button type="button" title="" onclick="addToCart();" data-original-title="Add to Cart" class="button btn-cart"><span>Add to Cart</span></button>
                  </div>
                </form>
                <!--add-to-cart-->
                <div class="email-addto-box">
                  <p class="email-friend"><a href="#" title="Email to a Friend"><span>Email to a Friend</span></a>
                  </p>
                  <ul class="add-to-links">
                    <li> <a class="link-wishlist" onclick="addWishlist('{{$product->id}}')" href="#!" onClick="" title="Add To Wishlist"><span>Add To Wishlist</span></a> </li>
                    <li> <span class="separator">|</span> <a class="link-compare" href="Compare.html" title="Add To Compare"><span>Add To Compare</span></a> </li>
                  </ul>
                  <!--add-to-links-->
                </div>
              </div>
              <!--email-addto-box-->
            </div>
            <!--add-to-box-->
            <!-- thm-mart Social Share-->
            <div class="social">
              <ul class="link">
                <li class="fb"> <a href="http://www.facebook.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a> </li>
                <li class="linkedin"> <a href="http://www.linkedin.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a> </li>
                <li class="tw"> <a href="http://twitter.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a> </li>
                <li class="pintrest"> <a href="http://pinterest.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a> </li>
                <li class="googleplus"> <a href="https://plus.google.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a> </li>
              </ul>
            </div>
            <!-- thm-mart Social Share Close-->
          </div>
          <!--product-shop-->
          <!--Detail page static block for version 3-->
        </div>
      </div>



      @if (count($recentlyViewed)>0 OR count($relatedProducts)>0)
      <div class="container my-account">
        <div class="dashboard">
          <!--product-collateral-->
          @if (count($relatedProducts)>0)
          <div class="box-additional">
            <div class="related-pro container">
              <div class="slider-items-products">
                <div class="new_title center">
                  <h2>Related Products</h2>
                </div>
                @php($overallRating = get_overall_rating($product->reviews))
                <div id="related-slider" class="product-flexslider hidden-buttons">
                  <div class="slider-items slider-width-col4 products-grid">
                    @foreach($relatedProducts as $key => $relatedProduct)
                    <div class="item" style="width: 200px;">
                      <div class="item-inner">
                        <div class="item-img">
                          <div class="item-img-info mini">
                            <a href="{{ route('product', $relatedProduct->slug) }}" title="{{ $relatedProduct->name }}" class="product-image">
                              <img src="{{ asset($relatedProduct->thumbnail) }}" alt="{{ $relatedProduct->name }}"></a>
                          </div>
                        </div>
                        <div class="item-info" style="padding: 0 10px">
                          <div class="info-inner">
                            <div class="item-title">
                              <a href="{{ route('product', $relatedProduct->slug) }}" title="{{ $relatedProduct->name }}">
                                {{ Str::limit($relatedProduct->name, 20) }}
                              </a>
                            </div>
                            <div class="item-content">
                              <div class="rating">
                                <div class="ratings">
                                  <div class="rating-box">
                                    <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                                  </div>
                                </div>
                              </div>
                              <p class="h4 rating-links">
                                {{\App\CPU\Helpers::currency_converter(
                                    $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                )}}
                              </p>
                              @if($relatedProduct->discount > 0)
                              <div class="item-price">
                                <div class="price-box">
                                  @if ($relatedProduct->discount_type == 'percent')
                                  {{ round($relatedProduct->discount,2)}}%
                                  @elseif($relatedProduct->discount_type =='flat')
                                  {{ \App\CPU\Helpers::currency_converter($relatedProduct->discount)}}
                                  @endif
                                </div>
                              </div>
                              @endif
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
          <!-- end related product -->

          <!-- Recently viewed Products -->
          @if (count($recentlyViewed)>0)
          <div class="box-additional">
            <div class="related-pro container">
              <div class="slider-items-products">
                <div class="new_title center">
                  <h2> Recently viewed </h2>
                </div>
                <div id="related-slider" class="product-flexslider hidden-buttons">
                  <div class="slider-items products-grid">
                    @foreach($recentlyViewed as $key => $viewed)
                    @php($overallRating = get_overall_rating($viewed->reviews))
                    <div class="item" style="width: 200px;">
                      <div class="item-inner">
                        <div class="item-img">
                          <div class="item-img-info">
                            <a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}" class="product-image">
                              <img src="{{ asset($viewed->thumbnail) }}" alt="{{ $viewed->name }}"></a>
                          </div>
                        </div>
                        <div class="item-info" style="padding: 0 10px">
                          <div class="info-inner">
                            <div class="item-title"><a href="{{ route('product', $viewed->slug) }}" title="{{ $viewed->name }}">{{ Str::limit($viewed->name, 20) }}</a> </div>
                            <div class="item-content">
                              <div class="rating">
                                <div class="ratings">
                                  <div class="rating-box">
                                    <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                                  </div>
                                </div>
                              </div>
                              <p class="h4 rating-links">
                                {{\App\CPU\Helpers::currency_converter(
                                  $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                )}}
                              </p>
                              @if($viewed->discount > 0)
                              <div class="item-price">
                                <div class="price-box">
                                  @if ($viewed->discount_type == 'percent')
                                  {{round($viewed->discount,2)}}%
                                  @elseif($viewed->discount_type =='flat')
                                  {{\App\CPU\Helpers::currency_converter($viewed->discount)}}
                                  @endif
                                </div>
                              </div>
                              @endif
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
          <!-- end Recently viewed Products -->
        </div>
      </div>
      @endif


      <!--product-essential-Tabs-->
      <div class="product-collateral panel" style="padding: 30px;">
        <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
          <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Product Description </a>
          </li>
          <!-- <li><a href="#product_tabs_tags" data-toggle="tab">Tags</a></li> -->
          <li> <a href="#reviews_tabs" data-toggle="tab">Reviews</a> </li>
          @if($product->added_by != "admin")
          <li> <a href="{{ route('shopView',[$product->seller->id]) }}">Vendor Store</a> </li>
          @endif
          <li> <a href="#product_tabs_custom1" data-toggle="tab">More Products</a> </li>
        </ul>
        <div id="productTabContent" class="tab-content">

          <!-- //Description -->
          <div class="tab-pane fade in active" id="product_tabs_description">
            @if(!empty($product->extra_data))
            <div class="col-sm-4" style="padding-bottom: 15px;">
              <?php $data = json_decode($product->extra_data) ?>
              <table>
                @foreach ($data as $key => $value)
                <tr>
                  <th>{{ ucwords(str_replace('_', ' ', $key)) }}:</th>
                  <td> {!! $value !!}</td>
                </tr>
                @endforeach
              </table>
            </div>
            @endif
            <div class="col">
              {!! $product->details !!}
            </div>
          </div>

          <!-- // Tags -->
          <div class="tab-pane fade" id="product_tabs_tags">
            <div class="box-collateral box-tags">
              <div class="tags">
                <form id="addTagForm" action="#" method="get">
                  <div class="form-add-tags">
                    <label for="productTagName">Add Tags:</label>
                    <div class="input-box">
                      <input class="input-text" name="productTagName" id="productTagName" type="text">
                      <button type="button" title="Add Tags" class=" button btn-add" onClick="submitTagForm()">
                        <span>Add Tags</span> </button>
                    </div>
                    <!--input-box-->
                  </div>
                </form>
              </div>
              <!--tags-->
              <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
              <p>
                @if(session()->has('cart') && count( session()->get('cart')) > 0)
                {{ var_dump(session()->get('cart')) }}
                @endif
              </p>
            </div>
          </div>

          <!-- // Reviews -->
          <div class="tab-pane fade" id="reviews_tabs">
            <div class="box-collateral box-reviews" id="customer-reviews">
              <div class="box-reviews2">
                <h3>Customer Reviews</h3>
                <div class="box visible">
                  <ul>
                    @foreach($product->reviews as $key => $review)
                    <li>
                      <table class="ratings-table">

                        <tbody>
                          <tr>
                            <th>Customer Name: </th>
                            <td style="width: 50%;"><strong>{{ ucfirst($review->user->f_name) }}</strong></td>
                          </tr>
                          <tr>
                            <th>Date Added: </th>
                            <td class="text-left">{{ show_datetime($review->created_at) }}</td>
                          </tr>
                          <tr>
                            <th>Rating</th>
                            <td>
                              <div class="rating-box">
                                <div class="rating" style="width: <?= $review->rating * 20 ?>%;"></div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="review">
                        <small>Review by <span>{{ ucfirst($review->user->f_name) }} </span> | {{ show_datetime($review->created_at) }} </small>
                        <div class="review-txt"> {{ $review->comment }}.</div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <div class="actions"> <a class="button view-all" id="revies-button" href="#"><span><span>View
                        all</span></span></a> </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>

          <?php /*
          <!-- // seller info -->
          <div class="tab-pane fade" id="product_tabs_custom">
            <div class="product-tabs-content-inner clearfix">
              <table>
                <tr></tr>
                <tr>
                  <th>Shop Name: </th>
                  <td>{{ ucwords($product->seller->shop->name) }}</td>
                </tr>
                <tr>
                  <th>Shop Address: </th>
                  <td>{{ ucwords($product->seller->shop->address) }}</td>
                </tr>
                <tr>
                  <th>Shop Contact: </th>
                  <td>{{ ucwords($product->seller->shop->contact) }}</td>
                </tr>
                <tr>
                  <th>Member Since: </th>
                  <td>{{ show_datetime($product->seller->shop->created_at) }}</td>
                </tr>
              </table>

            </div>
          </div>
          */ ?>

          <!-- // more procuts -->
          <div class="tab-pane fade" id="product_tabs_custom1">
            <div class="product-tabs-content-inner clearfix">
              @if (!empty($mproducts))
              <div class="box-additional">
                <div class="related-pro container">
                  <div class="slider-items-products">
                    <div id="related-slider" class="product-flexslider hidden-buttons">
                      <div class="slider-items slider-width-col4 products-grid">
                        @foreach($mproducts as $key => $mproduct)
                        @php($overallRating = get_overall_rating($mproduct->reviews))
                        <div class="item">
                          <div class="item-inner">
                            <div class="item-img">
                              <div class="item-img-info">
                                <a href="{{ route('product', $mproduct->slug) }}" title="{{ $mproduct->name }}" class="product-image">
                                  <img class="equal" style="padding: 15px;" src="{{ asset($mproduct->thumbnail) }}" alt="{{ $mproduct->name }}"></a>
                              </div>
                            </div>
                            <div class="item-info">
                              <div class="info-inner">
                                <div class="item-title">
                                  <a href="{{ route('product', $mproduct->slug) }}" title="{{ $mproduct->name }}">{{ Str::limit($mproduct->name, 25) }}</a>
                                </div>
                                <div class="item-content">
                                  <div class="rating">
                                    <div class="ratings">
                                      <div class="rating-box">
                                        <div class="rating" style="width: <?= $overallRating[0] * 20 ?>%"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <p class="h4 rating-links">
                                    {{\App\CPU\Helpers::currency_converter(
                                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                    )}}
                                  </p>
                                  @if($mproduct->discount > 0)
                                  <div class="item-price">
                                    <div class="price-box">
                                      @if ($mproduct->discount_type == 'percent')
                                      {{round($mproduct->discount,2)}}%
                                      @elseif($mproduct->discount_type =='flat')
                                      {{\App\CPU\Helpers::currency_converter($mproduct->discount) }}
                                      @endif
                                    </div>
                                  </div>
                                  @endif
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
<!-- <script type="text/javascript" src="{{ asset('home/js/cloudzoom.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('home/js/cloud-zoom.js') }}"></script>
<script type="text/javascript">
  CloudZoom.quickStart();

  // Initialize the slider.
  $(function() {
    $('#slider1').Thumbelina({
      $bwdBut: $('#slider1 .left'),
      $fwdBut: $('#slider1 .right')
    });
  });

  cartQuantityInitialize();
  getVariantPrice();
  $('#add-to-cart-form input').on('change', function() {
    getVariantPrice();
  });

  function showInstaImage(link) {
    $("#attachment-view").attr("src", link);
    $('#show-modal-view').modal('toggle')
  }
</script>

{{-- Messaging with shop seller --}}
<script>
  $('#contact-seller').on('click', function(e) {
    // $('#seller_details').css('height', '200px');
    $('#seller_details').animate({
      'height': '276px'
    });
    $('#msg-option').css('display', 'block');
  });
  $('#sendBtn').on('click', function(e) {
    e.preventDefault();
    let msgValue = $('#msg-option').find('textarea').val();
    let data = {
      message: msgValue,
      shop_id: $('#msg-option').find('textarea').attr('shop-id'),
      seller_id: $('.msg-option').find('.seller_id').attr('seller-id'),
    }
    if (msgValue != '') {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        type: "post",
        url: '{{route("messages_store")}}',
        data: data,
        success: function(respons) {
          console.log('send successfully');
        }
      });
      $('#chatInputBox').val('');
      $('#msg-option').css('display', 'none');
      $('#contact-seller').find('.contact').attr('disabled', '');
      $('#seller_details').animate({
        'height': '125px'
      });
      $('#go_to_chatbox').css('display', 'block');
    } else {
      console.log('say something');
    }
  });
  $('#cancelBtn').on('click', function(e) {
    e.preventDefault();
    $('#seller_details').animate({
      'height': '114px'
    });
    $('#msg-option').css('display', 'none');
  });
</script>

@endpush