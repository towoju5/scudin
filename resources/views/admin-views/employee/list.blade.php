@extends('layouts.backend')
@section('title','Employee List')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Employee')}}</li>
            <li class="breadcrumb-item" aria-current="page">{{__('List')}}</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-md-flex_ align-items-center justify-content-between mb-2">
        <div class="row">
            <div class="col-md-8">
                <h3 class="h3 mb-0 text-black-50">{{__('employee_list')}}</h3>
            </div>

            <div class="col-md-4">
                <a href="{{route('admin.employee.add-new')}}" class="btn btn-primary  float-right">
                    <i class="tio-add-circle"></i>
                    <span class="text">{{__('Add')}} {{__('New')}}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('employee_table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('SL#')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Phone')}}</th>
                                <th>{{__('Role')}}</th>
                                <th style="width: 50px">{{__('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($em as $k=>$e)
                            @if($e->role)
                                <tr>
                                    <th scope="row">{{$k+1}}</th>
                                    <td class="text-capitalize">{{$e['name']}}</td>
                                    <td >
                                      {{$e['email']}}
                                    </td>
                                    <td>{{$e['phone']}}</td>
                                    <td>{{$e->role['name']}}</td>
                                    <td>
                                        <a href="{{route('admin.employee.update', $e->id)}}">
                                           <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{route('admin.employee.delete', $e->id)}}">
                                           <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$em->render('pagination')}}
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
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush

