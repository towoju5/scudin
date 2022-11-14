@extends('layouts.backend')

@section('title','Withdraw Request')

@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between">
                <div class="row align-items-center mb-3">
                    <div class="col-sm">
                        <h1 class="page-header-title">{{__('Withdraw')}} {{__('Table')}}</h1>
                    </div>
                </div>
                <form class="form-inline align-items-center mt-1" action="{{ url()->current() }}" autocomplete="off">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" value="{{ request('q') ?? NULL }}" class="form-control" name="q" autofocus placeholder="Withdrawals Seller Name">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search Withdrawals</button>
                </form>
                <!-- End Nav Scroller -->
            </div>
        </div>
        <!-- End Page Header -->
 <div class="row" style="margin-top: 20px">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Withdraw Request Table')}}</h5>
            </div>
            <div class="card-body" style="padding: 0">
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                           style="width: 100%">
                        <thead class="thead-light">
                        <tr>
                            <th>{{__('SL#')}}</th>
                            <th>{{__('amount')}}</th>
                            {{-- <th>{{__('note')}}</th> --}}
                            <th>{{ __('Name') }}</th>
                            <th>{{__('request_time')}}</th>
                            <th>{{__('status')}}</th>
                            <th style="width: 5px">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($withdraw_req as $k=>$wr)
                            <tr>
                                <td scope="row">{{$k+1}}</td>
                                <td>{{\App\CPU\BackEndHelper::usd_to_currency($wr['amount'])}}</td>
                                {{-- <td>{{$wr->transaction_note}}</td> --}}
                                <td><a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}">{{ $wr->seller->f_name . ' ' . $wr->seller->l_name }}</a></td>
                                <td>{{$wr->created_at}}</td>
                                <td>
                                    @if($wr->approved==0)
                                        <label class="badge badge-primary">Pending</label>
                                    @elseif($wr->approved==1)
                                        <label class="badge badge-success">Approved</label>
                                    @else
                                        <label class="badge badge-danger">Denied</label>
                                    @endif
                                </td>
                                <td>
                                    @if($wr->approved==0)
                                        <a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}"
                                           class="btn btn-primary btn-sm">
                                           {{__('View')}}
                                        </a>
                                    @else
                                        <label>complete</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{$withdraw_req->render('pagination')}}
            </div>
        </div>
    </div>
   
     </div>
</div>
<script>
$('table').DataTable();
</script>
@endsection