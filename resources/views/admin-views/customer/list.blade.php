@extends('layouts.backend')

@section('title','Customer List')

@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between">
            <div class="row align-items-center">
                <div class="col-sm">
                    <h1 class="page-header-title">Customer
                        <span class="badge badge-dark ml-2">{{\App\User::count()}}</span>
                    </h1>
                </div>
            </div>
            <form class="form-inline align-items-center mt-1" action="{{ url()->current() }}" autocomplete="off">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" value="{{ request('customer') ?? NULL }}" class="form-control" name="customer" autofocus placeholder="Email/Phone Number/Name">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search User</button>
            </form>
        </div>
        <!-- End Row -->

    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                <thead class="thead-light">
                    <tr>
                        <th class=""> # </th>
                        <th class="table-column-pl-0">{{__('Name')}}</th>
                        <th>{{__('Email')}}</th>
                        <th>{{__('Phone')}}</th>
                        <th>{{__('Total')}} {{__('Order')}} </th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($customers as $key=>$customer)
                    <tr class="">
                        <td class="">
                            {{$key+1}}
                        </td>
                        <td class="table-column-pl-0">
                            <a href="{{route('admin.customer.view',[$customer['id']])}}">
                                {{$customer['f_name']." ".$customer['l_name']}}
                            </a>
                        </td>
                        <td>
                            {{$customer['email']}}
                        </td>
                        <td>
                            {{$customer['phone']}}
                        </td>
                        <td>
                            <label class="badge badge-info">
                                {{$customer->orders->count()}}
                            </label>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="tio-settings"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('admin.customer.view',[$customer['id']])}}">
                                        <i class="tio-visible"></i> {{__('View')}}
                                    </a>
                                    <a class="dropdown-item" target="" href="{{route('admin.customer.delete', [$customer->id])}}">
                                        <i class="tio-download"></i> Suspend
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                {!! $customers->render('pagination') !!}
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Table -->

    </div>
    <!-- End Card -->
</div>
@endsection
@push('js')
<script>
    $('table').DataTable();
</script>
@endpush