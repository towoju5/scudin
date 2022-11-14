@extends('layouts.backend')

@section('title','Dashboard')


@section('content')
<style>
    ._box {
        display: flex;
        align-items: center;
    }
</style>
@php  $wallet = \App\Model\SellerWallet::where('seller_id',auth('seller')->id())->first(); @endphp
<section id="dashboard-ecommerce">
    <div class="row match-height">

        <div class="col-xl-12">
            <div class="card card-congratulation-medal">
                <div class="card-header" style="background-color: var(--scudin);">
                    <h3 class="text-white">Balance</h3>
                </div>
                <div class="card-body pt-2">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <p class=" text-dark">Your Balance: <span class="h4">{{ currency_symbol(). number_format(\App\CPU\BackEndHelper::usd_to_currency($wallet->balance),2) }}</span></h5>
                            <p class=" text-dark">Minimum Withdraw Amount: <span class="h4">{{currency_symbol()}}50.00</span></h5>
                            <!-- <p class=" text-dark">Withdraw Threshold: <span class="h4">0 days</span></h5> -->
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" data-toggle="modal" data-target="#balance-modal" class="btn btn-warning btn-rounded btn-xs">Request Withdraw</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card card-congratulation-medal">
                <div class="card-header bg-grey" style="background-color: var(--scudin);">
                    <h3 class="text-white">Payment Details</h3>
                </div>
                <div class="card-body pt-2">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <p><span class="h4 text-dark">Last Payment</span></h5>
                            <p>You do not have any approved withdraw yet.</h5>
                        </div>
                        <div class="col-md-4 text-right">
                            <a type="button" href="#_withdrawal" class="btn btn-info btn-rounded btn-xs">View Payments</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <p><span class="h4 text-dark">Schedule</span></h5>
                            <p>Please update your withdraw schedule selection to get payment automatically.</h5>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" data-toggle="modal" data-target="#schedule" class="btn btn-success btn-rounded btn-xs">Edit Schedule</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card card-congratulation-medal">
                <div class="card-header" style="background-color: var(--scudin);">
                    <h3 class="text-white">Payment Methods</h3>
                </div>
                <div class="card-body pt-2">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <div class="_box">
                                <img src="{{ asset('logo/paypal.png') }}" width="50px" alt="PayPal">
                                <span class="h4 ml-1 text-dark">PayPal</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" data-toggle="modal" data-target="#paypal" class="btn btn-info btn-rounded btn-xs">Update <span class="pr-1 badge badge-primary">Default</span></button>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <div class="_box">
                                <img src="{{ asset('logo/bank.png') }}" width="50px" alt="PayPal">
                                <span class="h4 ml-1 text-dark">Bank</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" data-toggle="modal" data-target="#bank" class="btn btn-info btn-rounded btn-xs">Update Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid" id="_withdrawal">
    <!-- Page Heading -->
    <div class="page-header pb-2">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">{{__('Withdraw Request Table')}}</h1>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('SL#')}}</th>
                                    <th>{{__('amount')}}</th>
                                    <th>{{__('note')}}</th>
                                    <th>{{__('request_time')}}</th>
                                    <th>{{__('status')}}</th>
                                    <th style="width: 5px">Close</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraw_req as $k=>$wr)
                                <tr>
                                    <td scope="row">{{$k+1}}</td>
                                    <td>{{\App\CPU\Convert::default($wr['amount'])}}</td>
                                    <td>{{$wr->transaction_note}}</td>
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
                                        {{-- <a href="{{route('seller.withdraw.close',[$wr['id']])}}"
                                        class="btn btn-danger btn-sm">
                                        {{__('Delete')}}
                                        </a> --}}
                                        <a class="btn btn-danger btn-sm" href="javascript:" onclick="form_alert('withdraw-{{$wr->id}}','Want to delete this  ?')">{{__('Delete')}}</a>
                                        <form action="{{route('seller.withdraw.close',[$wr['id']])}}" method="post" id="withdraw-{{$wr['id']}}">
                                            @csrf @method('delete')
                                        </form>
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

<div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Withdraw Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('seller.withdraw.schedule', [$data->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="method">{{ __("Preferred Payment Method") }} <span class="text-danger">*</span></label>
                        <select name="method" id="method" class="form-control">
                            <option <?php if($wallet->method == 'paypal'){ echo 'selected'; } ?> value="paypal">PayPal</option>
                            <option <?php if($wallet->method == 'bank'){ echo 'selected'; } ?> value="bank">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="schedule">{{ __("Preferred Payment Schedule") }} <span class="text-danger">*</span></label>
                        <p>Earning will be released upon your request.</p>
                        <div class="form-check">
                            <input class="form-check-input"  <?php if($wallet->schedule == 1){ echo 'checked'; } ?> type="radio" name="schedule" id="monthly" value="1" checked="">
                            <label class="form-check-label" for="monthly">Monthly ( on first Monday of every month. )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"  <?php if($wallet->schedule == 2){ echo 'checked'; } ?> type="radio" name="schedule" id="twice_per_month" value="2">
                            <label class="form-check-label" for="twice_per_month">Twice Per Month ( on Monday of First week, Third week of each month )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"  <?php if($wallet->schedule == 3){ echo 'checked'; } ?> type="radio" name="schedule" id="quarterly" value="3">
                            <label class="form-check-label" for="quarterly">Quarterly ( on first Monday of March, June, September, December )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"  <?php if($wallet->schedule == 4){ echo 'checked'; } ?> type="radio" name="schedule" id="weekly" value="4">
                            <label class="form-check-label" for="weekly">Weekly ( on Monday of every week. )</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="balance">{{ __("Only When Balance Is") }} <span class="text-danger">*</span></label>
                        <select name="balance" id="balance" class="form-control">
                            @for ($i = 50; $i <= 100; $i=$i+10) <option <?php if($wallet->min_balance == $i){ echo 'selected'; } ?> value="{{$i}}"> {{ currency_symbol().number_format($i,2) }} or more </option>
                                @endfor
                        </select>
                    </div>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="btn_update">Change Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bank" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Bank Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('seller.profile.bank_update',[$data->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" value="{{$data->bank_name}}" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Branch Name/Routing Number <span class="text-danger">*</span></label>
                                <input type="text" name="branch" value="{{$data->branch}}" class="form-control" id="name" required>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="account_no">Holder Name <span class="text-danger">*</span></label>
                                <input type="text" name="holder_name" value="{{$data->holder_name}}" class="form-control" id="account_no" required>
                            </div>
                            <div class="col-md-6">
                                <label for="account_no">Account No <span class="text-danger">*</span></label>
                                <input type="number" name="account_no" value="{{$data->account_no}}" class="form-control" id="account_no" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn_update">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paypal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update PayPal Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('seller.profile.paypal_update',[$data->id]) }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="paypal" class="col-form-label">Email Address:</label>
                        <input type="email" name="paypal_email" required autocomplete="off" placeholder="paypal@scudin.com" value="{{ $data->paypal_email }}" class="form-control" id="paypal_email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Withdraw Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('seller.withdraw.request')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount:</label>
                        <input type="number" name="amount" value="{{\App\CPU\BackEndHelper::usd_to_currency($wallet->balance)}}" class="form-control" id="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Withdrawal Note:</label>
                        <input type="text" name="note" id="note" class="form-control" cols="30" rows="10">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if( (auth('seller')->user()->account_no=='null' || auth('seller')->user()->bank_name==null))
                    <button type="button" class="btn btn-primary" onclick="call_duty()">Incomplete bank info</button>
                    @else
                    <button type="submit" class="btn btn-primary">Request</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

@endsection