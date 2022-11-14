@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))

@if($product->p_type == 'car')
<?php $car_data = json_decode($product->extra_data, true) ?>
<li class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
  <div class="item-inner">
    <div class="item-img">
      <div class="item-img-info">
        <a href="{{route('product',$product->slug)}}" title="{{$product['name']}}" class="product-image">
          <img src='{{asset($product->thumbnail)}}' alt="{{$product['name']}}">
        </a>
      </div>
    </div>
    <div class="item-info equal">
      <div class="info-inner">
        <div class="price-new">
          <tr style="padding: 10px">
            <td>
              <span class="price-new h5" style="float: left;">
                <a href="{{route('product', $product->slug)}}" title="{{$product['name']}}">{{ $product['name'] }}</a>
              </span>
            </td>
            <td>
              <span class="price-new h5" style="float: right; padding-right: 10px">
                {{\App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price)))}}
              </span>
            </td>
          </tr>
        </div>
        <div class="item-content">
          <div class="rating">
            @if(!empty($product->extra_data))
            <div class="panel-body">
              <table class="table">
                <tr style="background: #ebecf1">
                  <td class="price"><img src="{{ asset('logo/engine.jpg') }}" style="width:30px" alt="">Engine</td>
                  <td class="note">{{ _limiter($car_data["'engine'"]) }}</td>
                </tr>
                <tr>
                  <td class="price">Fuel Tank Capacity: </td>
                  <td class="note">{{ _limiter($car_data["'fuel_tank_capacity'"]) }}</td>
                </tr>
                <tr style="background: #ebecf1">
                  <td class="price"><img src="{{ asset('logo/odometer.jpg') }}" style="width:30px" alt="">Transmission</td>
                  <td class="note">{{_limiter($car_data["'transmission'"]) }}</td>
                </tr>
                <tr>
                  <td class="price">Horsepower</td>
                  <td class="note">{{ _limiter($car_data["'power_and_torque'"]) }}</td>
                </tr>
                <tr style="background: #ebecf1">
                  <td class="price"><img src="https://www.ltourists.com/wp-content/uploads/2021/10/car-rental.png" style="width:30px" alt="">: Trim</td>
                  <td class="note">{{ _limiter($car_data["'trim'"]) }}</td>
                </tr>
              </table>
              <a href="{{route('product', $product->slug)}}" class="btn btn-primary btn-lg btn-block buy-now">
                Buy now <span class="glyphicon glyphicon-triangle-right"></span>
              </a>
            </div>
            @endif
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

@elseif($product->p_type == 'tech')
<?php $car_data = json_decode($product->extra_data, true) ?>
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
          <!-- <a href="{{route('product', $product->slug)}}" title="{{$product['name']}}">{{ Str::limit($product['name'], 25) }}</a> -->
          <p class="links h4">
            <span class="price-new">
              {{ \App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))) }}
            </span>
            @if($product->discount > 0)
            <span class="price-old">{{\App\CPU\Helpers::currency_converter($product->unit_price)}}</span>
            @endif
          </p>
        </div>
        <div class="item-content">
          <div class="rating">
            <div class="ratings">
              <div class="rating-box">
                <div class="rating" style="width:<?= $overallRating[0] * 20 ?>%"></div>
              </div>
            </div>
            @if(!empty($car_data))
            <div class="panel-body">
              <table class="table">
                <tr style="background: #ebecf1">
                  <td class="price"><img src="{{ asset('logo/engine.jpg') }}" style="width:30px" alt="">Memory</td>
                  <td class="note">{{ _limiter($car_data["memory"]) }}</td>
                </tr>
                <tr>
                  <td class="price">Processor: </td>
                  <td class="note">{{ _limiter($car_data["processor"]) }}</td>
                </tr>
                <tr style="background: #ebecf1">
                  <td class="price"><img src="{{ asset('logo/odometer.jpg') }}" style="width:30px" alt="">Storage Capacity</td>
                  <td class="note">{{ _limiter($car_data["storage"]) }}</td>
                </tr>
                <tr>
                  <td class="price">Processor Speed</td>
                  <td class="note">{{ _limiter($car_data["processor_peed"]) }}</td>
                </tr>
                <tr style="background: #ebecf1">
                  <td class="price"><img src="https://www.ltourists.com/wp-content/uploads/2021/10/car-rental.png" style="width:30px" alt="">Operating System</td>
                  <td class="note">{{ _limiter($car_data["operating_system"]) }}</td>
                </tr>
              </table>
              <a href="{{route('product', $product->slug)}}" class="btn btn-primary btn-lg btn-block buy-now">
                Buy now <span class="glyphicon glyphicon-triangle-right"></span>
              </a>
            </div>
            @endif
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
@else
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
@endif


<script>
  $(function() {
    $('.equal').matchHeight();
  });
</script>