@extends('layouts.backend')
@section('title','Shop view')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  ">{{__('my_shop')}} {{__('Info')}} </h3>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        @if($shop->image=='def.png')
                        <div class="col-md-4">
                            <img height="200" width="200"  class="rounded-circle border"
                            src="{{asset('assets/back-end')}}/img/shop.png"
                            alt="User Pic">
                        </div>
                        
                        @else
                        
                            <div class="col-md-4">
                                <img src="{{asset($shop->image)}}" class="rounded-circle border"
                                height="200" width="200" alt="">
                            </div>

                        
                        @endif
                    
                    
                        <div class="col-md-8 mt-4">
                            <h4>{{__('Name')}} : {{$shop->name}}</h4>
                            <h6>{{__('Phone')}} : {{$shop->contact}}</h6>
                            <h6>{{__('address')}} : {{$shop->address}}</h6>
                            <a class="btn btn-primary" href="{{route('seller.shop.edit',[$shop->id])}}">EDIT</a>
                        </div>
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
@endpush
