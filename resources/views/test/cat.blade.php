@extends('layouts.home.app')

@section('title', 'Sucdin Homepage')

@section('content')
<section class="main-container col2-left-layout bounceInUp animated">
  <div class="container">
    <div class="row">
      @foreach ($categories as $category)
      <div class="col-sm-3">
        <div class="col-12">
          <div class="panel panel-default panel-card equal">
            <h3 class="modtitle"><span>{{ $category->name }}</span></h3>
            <div class="panel-thumbnails">
              <div class="row">
                @foreach($category->products->take(4) as $cat)
                <div class="col-md-6">
                  <div class="thumbnail">
                    <a href="{{ route('products', ['id'=> $cat->id, 'data_from'=>'category', 'page'=>1]) }}" title="{{$cat->name}}" target="_self">
                      <img src="{{ Storage::url($cat->icon) }}">
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
      @endforeach
    </div>
  </div>
</section>
@endsection

@push('css')
<style>
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
</style>
@endpush

@push('js')
<script type="text/javascript" src="https://brm.io/js/libs/matchHeight/jquery.matchHeight.js"></script>
<script>
  $(function() {
    $('.equal').matchHeight();
  });
</script>
@endpush