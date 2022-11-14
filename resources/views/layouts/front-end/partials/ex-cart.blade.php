<div class="mini-cart">
  <div class="basket"> <a href="{{ route('shop-cart') }}" style="color: #fff;"> {{session()->has('cart')?count(session()->get('cart')):0}} </a> </div>
  <div class="fl-mini-cart-content">
    <div class="block-subtitle">
      <div class="top-subtotal">{{session()->has('cart') ? count(session()->get('cart')) : 0}} items, 
        <span class="price">{{\App\CPU\Helpers::currency_converter(\App\CPU\CartManager::cart_total_applied_discount(session()->get('cart')))}}</span>
      </div>
      <!--top-subtotal-->
      <!--pull-right-->
    </div>
    <!--block-subtitle-->
    @if(session()->has('cart') && count( session()->get('cart')) > 0)
    <ul class="mini-products-list" id="cart-sidebar">
    @php($sub_total=0)
    @php($total_tax=0)
    @foreach(session('cart') as $key => $cartItem)
      <li class="item first">
        <div class="item-inner">
          <a class="product-image" title="{{ $cartItem['name'] }}" href="{{ route('product', $cartItem['slug']) }}">
            <img alt="{{ $cartItem['name'] }}" src='{{asset("$cartItem[thumbnail]")}}'>
          </a>
          <div class="product-details">
            <div class="access"><a class="btn-remove1" title="Remove This Item" href="#!" onclick="removeFromCart(<?= $key ?>)">Remove</a> 
            <a class="btn-edit" title="Edit item" href="{{ route('product', $cartItem['slug']) }}">
              <i class="icon-pencil"></i><span class="hidden">Edit item</span>
            </a>
          </div>
            <!--access-->
            <strong>{{$cartItem['quantity']}}</strong> x <span class="price">{{\App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount']))}}</span>
            <p class="product-name"><a href="{{ route('product', $cartItem['slug']) }}">{{ $cartItem['name'] }}</a></p>
          </div>
        </div>
      </li>
      @endforeach
      
    </ul>
    <div class="actions">
      <button class="btn-checkout" title="Checkout" type="button" onClick="window.location='<?= route('checkout-details') ?>'"><span>{{ __('checkout') }}</span></button>
      <button class="view-cart" title="Checkout" type="button" onClick="window.location='<?= route('shop-cart') ?>'"><span>View Cart</span></button>
    </div>
    @endif
    <!--actions-->
  </div>
  <!--fl-mini-cart-content-->
</div>
