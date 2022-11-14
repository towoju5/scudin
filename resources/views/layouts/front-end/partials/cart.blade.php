<a href="{{ route('shop-cart') }}" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
  <div class="items-cart-inner">
    <div class="basket"> <i class="glyphicon glyphicon-shopping-cart"></i> </div>
    <div class="basket-item-count" style="background: #E1A006 !important;">
      <span class="count">{{session()->has('cart') ? count(session()->get('cart')) : 0}}</span>
    </div>
    <div class="total-price-basket">
      <!-- <span class="lbl">cart -</span> -->
      <span class="total-price">
        <span class="sign"></span>
        <span class="value text-white">{{\App\CPU\Helpers::currency_converter(\App\CPU\CartManager::cart_total_applied_discount(session()->get('cart')))}}</span>
      </span>
    </div>
  </div>
</a>
@if(session()->has('cart') && count( session()->get('cart')) > 0)
<ul class="dropdown-menu">
  @php($sub_total=0)
  @php($total_tax=0)
  @foreach(session('cart') as $key => $cartItem)
  <li>
    <div class="cart-item product-summary">
      <div class="row">
        <div class="col-xs-3">
          <div class="image">
            <a title="{{ $cartItem['name'] }}" href="{{ route('product', $cartItem['slug']) }}">
              <img alt="{{ $cartItem['name'] }}" src='{{asset("$cartItem[thumbnail]")}}'>
            </a>
          </div>
        </div>
        <div class="col-xs-7">
          <h3 class="name"><a href="index.php?page-detail">{{ $cartItem['name'] }}</a></h3>
          <div class="price">
            <strong>{{$cartItem['quantity']}}</strong> x {{\App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount']))}}
          </div>
        </div>
        <div class="col-xs-1">
          <a href="#" onclick="removeFromCart(<?= $key ?>)">
            <i class="fas fa-trash"></i>
          </a>
        </div>
      </div>
    </div>
  </li>
  @endforeach
  <!-- /.cart-item -->
  <div class="clearfix"></div>
  <hr>
  <div class="clearfix cart-total">
    <div class="pull-right"> <span class="text">{{ __('Sub Total')}} :</span><span class="price">{{\App\CPU\Helpers::currency_converter(\App\CPU\CartManager::cart_total_applied_discount(session()->get('cart')))}}</span> </div>
    <div class="clearfix"></div>
    <a href="{{ route('shop-cart') }}" class="btn btn-upper btn-primary btn-block m-t-20"><i class="glyphicon glyphicon-shopping-cart"></i> {{ __('Cart')}}</a>
    <a href="{{ route('checkout-details') }}" class="btn btn-upper btn-primary btn-block m-t-20">{{ __('Checkout')}}</a>
  </div>
  <!-- /.cart-total-->
</ul>
@endif