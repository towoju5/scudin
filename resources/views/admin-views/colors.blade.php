@extends('layouts.backend')
@section('title','Colors')
@section('content')
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.colors') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Color')}} {{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Color Name">
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('Color')}} {{ __('Code')}} </label>
                            <input type="color" name="code" class="form-control" id="code">
                        </div>
                        <button id="add" type="submit" class="btn btn-primary btn-sm" style="color: white">
                            {{ __('Add')}} <i class="fa fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Code')}} </th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colors as $color)
                                <tr>
                                    <td> {{ $color->name }}</td>
                                    <td> {{ $color->code }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="_delete({{$color->id}})">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

    function _delete(id) {
        Swal.fire({
            title: 'Are you sure to delete this?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('admin.colors')}}",
                    method: 'POST',
                    data: {
                        id: id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function() {
                        datatable.ajax.reload();
                        toastr.success('units deleted successfully');
                    }
                });
            }
        })
    }
</script>
@endpush