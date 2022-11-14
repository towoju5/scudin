@extends('layouts.backend')
@section('title','Seller List')
@push('css')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="container-fluid">
    <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Sellers')}}</li>
        </ol>
    </nav> -->

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="text-black">{{__('Sellers')}}</h1>
    </div>

    <div class="row" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <!-- <th scope="col">{{__('SL#')}}</th> -->
                                <th scope="col">{{__('name')}}</th>
                                <th scope="col">{{__('Phone')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('status')}}</th>
                                <th scope="col">{{__('orders')}}</th>
                                <th scope="col">{{__('Products')}}</th>
                                <th scope="col" style="width: 50px">{{__('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                                @foreach($sellers as $key=>$seller)
                                    <tr>
                                        <!-- <td scope="col">{{$i++}}</td> -->
                                        <td scope="col">{{$seller->f_name}} {{$seller->l_name}}</td>
                                        <td scope="col">{{$seller->phone}}</td>
                                        <td scope="col">{{$seller->email}}</td>
                                        <td scope="col">{{$seller->status}}</td>
                                        <td scope="col">
                                            <a href="{{route('admin.sellers.order-list',[$seller['id']])}}" class="btn btn-outline-primary btn-block">
                                                <i class="tio-shopping-cart-outlined"></i>({{$seller->orders->count()}})
                                            </a>
                                        </td>
                                        <td scope="col">
                                            <a href="{{route('admin.sellers.product-list',[$seller['id']])}}" class="btn btn-outline-primary btn-block">
                                                <i class="tio-premium-outlined mr-1"></i>({{$seller->product->count()}})
                                            </a>
                                        </td>
                                        <td colspan="2">
                                            <a class="btn btn-outline-primary btn-block" title="View Seller" class="pr-1" href="{{route('admin.sellers.verification',$seller->id)}}">
                                                <i class="fas fa-eye"></i><!-- {{__('View')}} -->
                                            </a>
                                            <a class="btn btn-outline-primary btn-block" title="Suspend Seller" href="{{route('admin.sellers.delete',$seller->id)}}">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
