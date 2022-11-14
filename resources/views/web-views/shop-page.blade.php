@extends('layouts.home.app')
@section('title', $shop->name)


@push('css')
<meta property="og:image" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}" />
<meta property="og:title" content="{{ $shop->name}} " />
<meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
<meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<meta property="twitter:card" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}" />
<meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}" />
<meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
<meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<link href="{{asset('assets/front-end')}}/css/home.css" rel="stylesheet">
<style>
  .headerTitle {
    font-size: 34px;
    font-weight: bolder;
    margin-top: 3rem;
  }

  .page-item.active .page-link {
    background-color: <?= $web_config['primary_color'] ?> !important;
  }

  .page-item.active>.page-link {
    box-shadow: 0 0 black !important;
  }

  .price-new {
    padding-left: 10px;
  }

  .desktop {
    margin-top: -10px;
    margin-left: 10px
  }

  .headerTitle {
    padding: 5px;
  }
</style>
@endpush

@section('content')
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4" style="width: 100%;">
  <div class="row">
    <!-- Content  -->
    <section class="col-lg-12">
      <div class="seller-header-image" style="background: url('{{asset($seller->image)}}');">
        <div class="col-md-10 desktop" style="display: inline-flex;">
          <h3 class="text-white mb-0 headerTitle text-uppercase" style="font-size: 24px;">
            <img src="{{ asset($shop->image) }}" width="50px" height="50px" alt="seller Logo">
            {{ $shop->name }}
         </h3>
        </div>
      </div>

      <div class="mt-4 mb-2">
        <div class="seller_footer">
          <div class="col-md-12 text-right" style="margin-top: 15px">
            @if (auth('customer')->id() == '')
            <div class="col-md-4">
              <a href="{{route('customer.auth.login')}}" class="btn btn-primary btn-block">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                {{ __('Contact')}} {{ __('Seller')}}
              </a>
            </div>
            @else
            <div class="col-md-4">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                {{ __('Contact')}} {{ __('Seller')}}
              </button>
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="padding: 20px;">
            <div class="card-header">
              Write Something
            </div>
            <div class="modal-body">
              <form action="{{route('messages_store')}}" method="post" id="chat-form">
                @csrf
                <input value="{{$shop->id}}" name="shop_id" hidden>
                <input value="{{$shop->seller_id}}}" name="seller_id" hidden>

                <textarea name="message" class="form-control"></textarea>
                <br>
                <button class="btn btn-primary">
                  Send
                </button>
              </form>
            </div>
            <div class="card-footer">
              <a href="{{route('chat-with-seller')}}" class="btn btn-primary">
                {{ __('go_to')}} {{ __('chatbox')}}
              </a>
              <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <section class="main-container col2-left-layout bounceInUp animated">
    <div class="container">
      <div class="row">
        <div class="col-main product-grid">
          <div class="pro-coloumn">
            <article class="col-main">
              <div class="category-products">
                <ul class="products-grid">
                  @if(count($products) > 0)
                  @include('web-views.products._ajax-products',['products'=>$products])
                  @else
                  <div class="text-center pt-5">
                    <h2>No Product Found</h2>
                  </div>
                  @endif
                </ul>
              </div>
              <div class="toolbar">
                <div class="pager">
                  <div class="pages" id="ajax-products">
                    {!! $products->render('pagination') !!}
                  </div>
                </div>

              </div>
            </article>
          </div>
        </div>

      </div>
    </div>
  </section>
  <hr class="my-3">
  <!-- Pagination-->
  <div class="row">
    <div class="col-md-12">
      <div class="justify-content-center center-block align-content-center">

      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $('#chat-form').on('submit', function(e) {
    e.preventDefault();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $.ajax({
      type: "post",
      url: '{{route("messages_store")}}',
      data: $('#chat-form').serialize(),
      success: function(respons) {

        toastr.success('send successfully', {
          CloseButton: true,
          ProgressBar: true
        });
        $('#chat-form').trigger('reset');
      }
    });

  });
</script>
@endpush