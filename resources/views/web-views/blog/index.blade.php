@extends('layouts.home.app')

@section('title', 'Sucdin Homepage')

@section('content')
<section class="main-container col2-left-layout bounceInUp animated">
  <div class="container">
    <div class="row">
      <div class="col-main product-grid">
        <div class="pro-coloumn">
          <article class="col-main">
            <div class="category-products" id="ajax-products">
              @if(count($posts) > 0)
              <div class="row">
                @foreach($posts as $post)
                <div class="col-md-3">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <a href="{{route('blog.show', $post->slug)}}" title="{{$post->title}}" class="product-image">
                        <img src='{{ $post->blog_image }}' style="width:100%; height: 250px" alt="{{$post->title}}">
                      </a>
                    </div>
                    <div class="panel-body" style="height: 10rem;">
                      <div class="price-new h4">
                        <a href="{{route('blog.show', $post->slug)}}" class="garage-title" title="{{$post->title}}">
                          {{ $post->title }}
                        </a>
                        <p class="card-text">
                          {{ $post->created_at }}
                        </p>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <p class="card-text">
                        By: {!! ucwords($post->name) !!}
                      </p>
                      <p class="card-text">
                        {!! ucwords(reading_time($post->body)) !!}
                      </p>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              @else
              <div class="text-center pt-5">
                <h2>No Post Found</h2>
              </div>
              @endif
            </div>
            <div class="toolbar">
              <div class="pager">
                <div class="pages">
                  {!! $posts->render('paginatio') !!}
                </div>
              </div>
            </div>
          </article>
        </div>
      </div>

    </div>
  </div>
</section>
<style>
  .equal-height-cards>.cell {
    display: flex;
    align-items: stretch;
  }

  .panel-default>.panel-heading , .panel-footer, .panel-body {
    color: #333;
    background-color: #fff;
    border-color: #ddd;
    text-align: center;
  }

  .card {
    height: 100%;
    display: flex;
  }

  .card-block {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
  }

  .card-footer {
    align-self: flex-end;
    flex: 1 1 auto;
    bottom: 0px;
    background-color: #e7dada;
  }

  .woju {
    padding: 10px;
    align-content: center;
  }
</style>
@endsection