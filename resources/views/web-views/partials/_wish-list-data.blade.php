<style>
  body {
    font-family: 'Titillium Web', sans-serif
  }

  .card {
    border: none
  }

  .totals tr td {
    font-size: 13px
  }

  .footer span {
    font-size: 12px
  }

  .product-qty span {
    font-size: 12px;
    color: #6A6A6A;
  }

  .font-name {
    font-weight: 600;
    font-size: 15px;
    color: #030303;
  }

  .sellerName {
    font-weight: 600;
    font-size: 14px;
    color: #030303;
  }

  .wishlist_product_img img {
    margin: 15px;
  }

  @media (max-width: 600px) {
    .font-name {
      font-size: 12px;
      font-weight: 400;
    }

    .amount {
      font-size: 12px;
    }
  }

  @media (max-width: 600px) {
    .wishlist_product_img {
      width: 20%;
    }

    .forPadding {
      padding: 6px;
    }

    .sellerName {

      font-weight: 400;
      font-size: 12px;
      color: #030303;
    }

    .wishlist_product_desc {
      width: 50%;
      margin-top: 0px !important;
    }

    .wishlist_product_icon {
      margin-left: 1px !important;
    }

    .wishlist_product_btn {
      width: 30%;
      margin-top: 10px !important;
    }

    .wishlist_product_img img {
      margin: 8px;
    }
  }
</style>
@if($wishlists->count()>0)

<div class="row">
  @foreach($wishlists as $wishlist)
  @php($product = $wishlist->product)
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        @php($tax = ($product->tax_type == 'percent' ? $product->unit_price + ($product->unit_price * $product->tax) / 100 : $product->unit_price + $product->tax))
        <a href="{{ route('product', $product->slug) }}" title="{{$product->title}}" class="product-image">
          <img src='{{ $product->thumbnail }}' style="width:100%; height: 250px" alt="{{ $product->name }}">
        </a>
      </div>
      <div class="panel-body" style="height: 10rem;">
        <div class="price-new h4">
          <a href="{{ route('product', $product->slug) }}" class="garage-title" title="{{$product->title}}">
            {{ $product->name }}
          </a>
          <p class="card-text">
            <a class="h4" href="{{route('product',$product['slug'])}}" style="float: right;">{{App\CPU\Helpers::currency_converter($tax)}}</a>
          </p>
        </div>
      </div>
      <div class="panel-footer">
        <div class="d-flex justify-content-between">
          <a href="{{route('product',$product['slug'])}}" class="btn btn-primary">Buy Now</a>
          <a href="javascript:" onclick="removeWishlist('{{ $product->id }}')" style="float: right;color: red" class="btn btn-danger"><i class="fa fa-trash"></i> Remove</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@else
<center>
  <h3 class="text-dark">
    No data found.
  </h3>
</center>
@endif
