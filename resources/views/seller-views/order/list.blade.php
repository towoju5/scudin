@extends('layouts.backend')
@section('title','Order List')

@push('css_or_js')
<!-- Custom styles for this page -->
<link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<!-- Page Heading -->
<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between">
                <div class="row align-items-center mb-3">
                    <div class="col-sm">
                        <h1 class="page-header-title">{{__('Orders')}} 
                            <span  class="badge badge-dark ml-2">{{\App\Model\OrderDetail::where('seller_id', auth('seller')->id())->groupBy('order_id')->count()}}</span>
                        </h1>
                    </div>
                </div>
                <form class="form-inline align-items-center mt-1" action="{{ url()->current() }}" autocomplete="off">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" value="{{ request('order') ?? NULL }}" class="form-control" name="order" autofocus placeholder="Order ID">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search Order</button>
                </form>
                <!-- End Nav Scroller -->
            </div>
        </div>
        <!-- End Page Header -->


    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('order_table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('SL#')}}</th>
                                    <th>{{__('Order')}}</th>
                                    <th>{{__('customer_name')}}</th>
                                    <th>{{__('Phone')}}</th>
                                    <th>{{__('Payment')}}</th>
                                    <th>{{__('Status')}} </th>
                                    <th style="width: 30px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $k=>$detail)
                                <tr>
                                    <td>
                                        {{$k+1}}
                                    </td>
                                    <td>
                                        <a href="{{route('seller.orders.details',$detail['order_id'])}}">{{$detail['order_id']}}</a>
                                    </td>
                                    <td>{{ $detail->order->customer->f_name }}</td>
                                    <td>{{ $detail->order->customer->phone }}</td>
                                    <td>
                                        @if($detail->order->payment_status=='paid')
                                        <span class="badge badge-success">
                                            <span class="legend-indicator bg-success"></span>Paid
                                        </span>
                                        @else
                                        <span class="badge badge-danger">
                                            <span class="legend-indicator bg-danger"></span>Unpaid
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-capitalize ">
                                        @if($detail->order->order_status=='pending')
                                        <label class="badge badge-primary">{{$detail->order['order_status']}}</label>
                                        @elseif($detail->order->order_status=='processing')
                                        <label class="badge badge-primary">{{$detail->order['order_status']}}</label>
                                        @elseif($detail->order->order_status=='delivered')
                                        <label class="badge badge-success">{{$detail->order['order_status']}}</label>
                                        @elseif($detail->order->order_status=='returned')
                                        <label class="badge badge-danger">{{$detail->order['order_status']}}</label>
                                        @else
                                        <label class="badge badge-danger">{{$detail->order['order_status']}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="{{route('seller.orders.details',[$order['order_id']])}}"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                        </a> --}}

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{route('seller.orders.details',[$detail['order_id']])}}"><i class="tio-visible"></i> View</a>
                                                <a class="dropdown-item" target="_blank" href="{{route('seller.orders.generate-invoice',[$detail['order_id']])}}"><i class="tio-download"></i> Invoice</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center justify-content-sm-end" style="padding-right: 15px">
                    {!! $orders->render('pagination') !!}
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>
</div>
</div>
@endsection

@push('script')
<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush