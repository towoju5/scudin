@extends('layouts.backend')
@section('title','Bandk Info View')

@section('content')
    <div class="content-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{__('seller')}}</li>
                <li class="breadcrumb-item">{{__('my_bank_info')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-black-50">{{__('my_bank_info')}}</h1>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0  ">{{__('my_bank_info')}}  </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-4">
                            <h4>{{__('bank_name')}}
                                : {{$data->bank_name ? $data->bank_name : 'No Data found'}}</h4>
                            <h6>{{__('Branch')}} : {{$data->branch ? $data->branch : 'No Data found'}}</h6>
                            <h6>{{__('holder_name')}}
                                : {{$data->holder_name ? $data->holder_name : 'No Data found'}}</h6>
                            <h6>{{__('account_no')}}
                                : {{$data->account_no ? $data->account_no : 'No Data found'}}</h6>


                            <a class="btn btn-primary"
                               href="{{route('seller.profile.bankInfo',[$data->id])}}">{{__('Edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection