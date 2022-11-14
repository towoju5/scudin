@extends('layouts.backend')
@section('title','Product List')
<?php use App\CPU\BackEndHelper; ?>
@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Products')}}</li>

        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-md-flex_ align-items-center justify-content-between mb-2">
        <div class="row">
            <div class="col-md-8">
                <h3 class="h3 mb-0 text-gray-800">{{ trans('Product List')}}</h3>
            </div>


            <div class="col-md-4">
                <a href="{{route('seller.product.add-new')}}" class="btn btn-primary  float-right">
                    <i class="tio-add-circle"></i>
                    <span class="text">{{__('Add new product')}}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h5>{{__('product_table')}}</h5>
                    <form method="get">
                        <div class="form-group">
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="text" value="{{ $_REQUEST['q'] ?? NULL }}" class="form-control" name="q" placeholder="Search for product" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary waves-effect" id="button-addon2" type="submit">Go</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('SL#')}}</th>
                                    <th>{{__('Product Name')}}</th>
                                    <th>{{__('purchase_price')}}</th>
                                    <th>{{__('selling_price')}}</th>
                                    <th>{{__('Admin Fee')}}</th>
                                    <th>{{__('Earnings')}}</th>
                                    <th>{{__('status')}}</th>
                                    <th style="width: 5px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $k=>$p)
                                <tr>
                                    <th scope="row">{{$k+1}}</th>
                                    <td><a href="{{route('seller.product.view',[$p['id']])}}">
                                            {{$p['name']}}
                                        </a></td>
                                    <td>
                                        {{ BackEndHelper::currency_format($p->purchase_price) }}
                                    </td>
                                    <td>
                                        {{ BackEndHelper::currency_format($p['unit_price']) }}
                                    </td>
                                    <td><?php $commission = get_commission($p->id) ?>
                                        {{ BackEndHelper::currency_format($commission) }}
                                    </td>
                                    <td>
                                        {{ BackEndHelper::currency_format($p->purchase_price - $commission ) }}
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status" id="{{$p['id']}}" {{$p->status == 1?'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <form action="{{ route('seller.product.promote') }}" method="post" id="product-{{$p['id']}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $p['id'] }}">
                                                    <button class="dropdown-item" type="submit" style="width: 100%;">{{__('Promote')}}</button>
                                                </form>
                                                <a class="dropdown-item" href="{{route('seller.product.edit',[$p['id']])}}">{{__('Edit')}}</a>
                                                <a class="dropdown-item" href="{{ route('seller.product.delete', $p->id) }}"">{{__('Delete')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="page-area">
                            <table>
                                <tfoot class="border-top">
                                    {!! $products->render('pagination') !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).on('change', '.status', function() {
        var id = $(this).attr("id");
        if ($(this).prop("checked") == true) {
            var status = 1;
        } else if ($(this).prop("checked") == false) {
            var status = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('seller.product.status-update')}}",
            method: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function() {
                toastr.success('Status updated successfully');
            }
        });
    });
    
    function delete_alert(id) {
      swal({
            title: "Are you sure?",
            text: "But you will still be able to retrieve this file.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, archive it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
         },
         function(isConfirm) {
            if (isConfirm) {
               $('#product-'+id).submit(); // submitting the form when user press yes
            } else {
               swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
         });
   }
</script>
@endpush
