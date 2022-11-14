@extends('layouts.backend')
@section('title','Seller View')
@push('css_or_js')
<!-- Custom styles for this page -->
<link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('sellers_verification')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex row align-items-center justify-content-between mb-2">
        <div class="col-md-6">
            <h4 class=" mb-0 text-black-50">{{__('sellers_verification')}}</h4>
        </div>
        <div class="col-md-6 ">
            @if ($seller->status=="pending")
            <div class="mt-4 pr-2 float-right">
                <div class="text-center">
                    <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$seller->id}}">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-primary">{{__('accept')}}</button>
                    </form>
                    <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$seller->id}}">
                        <input type="hidden" name="status" value="suspended">
                        <button type="submit" class="btn btn-danger">{{__('reject')}}</button>
                    </form>
                </div>
            </div>

            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{__('Seller')}} {{__('info')}}
                </div>
                <div class="card-body">
                    <h5>{{__('name')}} : {{$seller->f_name}} {{$seller->l_name}}</h5>
                    <h5>{{__('Email')}} : {{$seller->email}}</h5>
                    <h5>{{__('Phone')}} : {{$seller->phone}}</h5>
                </div>
            </div>
        </div>
        @if($seller->shop)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{__('Shop')}} {{__('info')}}
                </div>
                <div class="card-body">
                    <h5>{{__('seller_b')}} : {{$seller->shop->name}}</h5>
                    <h5>{{__('Phone')}} : {{$seller->shop->contact}}</h5>
                    <h5>{{__('address')}} : {{$seller->shop->address}}</h5>
                </div>
            </div>
        </div>
        @endif



    </div>
    <div class="row mt-3">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  ">{{__('my_bank_info')}} </h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-4">
                        <?php
                        $len = strlen($seller->account_no);
                        if (!is_numeric($len) OR $len - 4 < 0) {
                            $len = 0;
                        }
                        if(auth('admin')->user()->admin_role_id != 1){
                            $acc = substr_replace($seller->account_no, str_repeat("*", $len), 0, -4);
                        } else {
                            $acc = $seller->account_no;
                        }
                        ?>
                        <h4>{{__('bank_name')}}: {{$seller->bank_name ? $seller->bank_name : 'No Data found'}}</h4>
                        <h6>{{__('Branch')}} : {{$seller->branch ? $seller->branch : 'No Data found'}}</h6>
                        <h6>{{__('holder_name')}} : {{$seller->holder_name ? $seller->holder_name : 'No Data found'}}</h6>
                        <h6>{{__('account_no')}} : {{$acc ?? 'No Data found'}}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection

@push('js')
<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush