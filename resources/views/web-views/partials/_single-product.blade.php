@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))

<li class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
  <div class="item-inner">
    <div class="item-img">
      <div class="item-img-info">
        <a href="{{route('product',$product->slug)}}" title="{{$product['name']}}" class="product-image">
          <img src='{{asset($product->thumbnail)}}' alt="{{$product['name']}}">
        </a>
      </div>
    </div>
    <div class="item-info equal" style="padding: 10px;">
      <div class="info-inner">
        <div class="price-new">
          <a href="{{route('product', $product->slug)}}" title="{{$product['name']}}">{{ $product['name'] }} </a>
        </div>
        <div class="item-content">
          <div class="rating">
            <div class="ratings">
              <div class="rating-box">
                <div class="rating" style="width:<?= $overallRating[0] * 20 ?>%"></div>
              </div>
            </div>
            <p class="links h4">
              <span class="price-new">
                {{ \App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))) }}
              </span>
              @if($product->discount > 0)
              <span class="price-old">{{\App\CPU\Helpers::currency_converter($product->unit_price)}}</span>
              @endif
            </p>
          </div>
          @if($product->discount > 0)
          <div class="item-price">
            <div class="price-box">
              <span class="regular-price">
                <span class="price">
                  @if ($product->discount_type == 'percent')
                  {{round($product->discount,2)}}%
                  @elseif($product->discount_type =='flat')
                  {{\App\CPU\Helpers::currency_converter($product->discount)}}
                  @endif
                </span>
              </span>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</li>


<script>
  $(function() {
    $('.equal').matchHeight();
  });
</script>