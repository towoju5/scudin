@extends('layouts.backend')

@section('title', 'All Products')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/app-ecommerce-details.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-number-input.css">
<!-- END: Page CSS-->
@endsection

@section('content')
<section class="app-ecommerce-details">
  <div class="card">
    <!-- Product Details starts -->
    <div class="card-body">
      <div class="row my-2">
        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
          <div class="d-flex align-items-center justify-content-center">
            <img src="{{ url('/') }}/app-assets/images/pages/eCommerce/1.png" class="img-fluid product-img" alt="product image" />
          </div>
        </div>
        <div class="col-12 col-md-7">
          <h4>{{ $product->name }}</h4>
          <span class="card-text item-company">By <a href="javascript:void(0)" class="company-name">{{ $product->shop->shop_name }}</a></span>
          <div class="ecommerce-details-price d-flex flex-wrap mt-1">
            <h4 class="item-price mr-1">{{ get_price($product->price) }}</h4>
            <ul class="unstyled-list list-inline pl-1 border-left">
              <li class="ratings-list-item">{{ str_repeat('⭐', 1) }}</li>
            </ul>
          </div>
          <p class="card-text">Available - <span class="text-success">In stock</span></p>
          <p class="card-text">
            GPS, Always-On Retina display, 30% larger screen, Swimproof, ECG app, Electrical and optical heart sensors,
            Built-in compass, Elevation, Emergency SOS, Fall Detection, S5 SiP with up to 2x faster 64-bit dual-core
            processor, watchOS 6 with Activity trends, cycle tracking, hearing health innovations, and the App Store on
            your wrist
          </p>
          <ul class="product-features list-unstyled">
            <li><i data-feather="shopping-cart"></i> <span>Free Shipping</span></li>
            <li>
              <i data-feather="dollar-sign"></i>
              <span>EMI options available</span>
            </li>
          </ul>
          <hr />
          <div class="product-color-options">
            <h6>Colors</h6>
            <ul class="list-unstyled mb-0">
              <li class="d-inline-block selected">
                <div class="color-option b-primary">
                  <div class="filloption bg-primary"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-success">
                  <div class="filloption bg-success"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-danger">
                  <div class="filloption bg-danger"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-warning">
                  <div class="filloption bg-warning"></div>
                </div>
              </li>
              <li class="d-inline-block">
                <div class="color-option b-info">
                  <div class="filloption bg-info"></div>
                </div>
              </li>
            </ul>
          </div>
          <hr />
          <div class="d-flex flex-column flex-sm-row pt-1">
            <a href="javascript:void(0)" class="btn btn-primary btn-cart mr-0 mr-sm-1 mb-1 mb-sm-0">
              <i data-feather="shopping-cart" class="mr-50"></i>
              <span class="add-to-cart">Add to cart</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-outline-secondary btn-wishlist mr-0 mr-sm-1 mb-1 mb-sm-0">
              <i data-feather="heart" class="mr-50"></i>
              <span>Wishlist</span>
            </a>
            <div class="btn-group dropdown-icon-wrapper btn-share">
              <button type="button" class="btn btn-icon hide-arrow btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="share-2"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="javascript:void(0)" class="dropdown-item">
                  <i data-feather="facebook"></i>
                </a>
                <a href="javascript:void(0)" class="dropdown-item">
                  <i data-feather="twitter"></i>
                </a>
                <a href="javascript:void(0)" class="dropdown-item">
                  <i data-feather="youtube"></i>
                </a>
                <a href="javascript:void(0)" class="dropdown-item">
                  <i data-feather="instagram"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Product Details ends -->
  </div>
</section>
@livewire('product-ratings', ['product' => $product], key($product->id))
@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/extensions/swiper.min.js"></script>

@endsection