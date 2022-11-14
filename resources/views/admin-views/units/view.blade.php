@extends('layouts.backend')
@section('title','Units')
@section('content')
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="id">
                            <label for="name">{{ __('units')}} {{ __('Name')}} </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter units Name">
                        </div>
                        <a id="add" class="btn btn-primary btn-sm" style="color: white">{{ __('Add')}} <i class="fa fa-plus"></i></a>
                        <a id="update" class="btn btn-primary btn-sm" style="display: none; color: #fff;">{{ __('Update')}} <i class="fa fa-edit"></i></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('SL#')}}</th>
                                    <th>{{ __('Name')}} </th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
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
<!-- <script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script> -->
<!-- <script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script> -->
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script>
    var datatable;
    var rowid;
    $(document).ready(function() {
        datatable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: "{{ route('admin.units.view') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'units'
                },
                {
                    data: '',
                    searchable: true
                },
            ],
            "columnDefs": [{
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    render: function(data, type, full, meta) {
                        return (
                            '<a href="javascript:;" class="item-edit edit" onclick=_edit(' + full.id + ')>' +
                            feather.icons['edit'].toSvg({
                                class: 'font-medium-4 mr-1'
                            }) +
                            '</a>' +
                            '<a href="javascript:;" onclick="_delete(' + full.id + ')">' +
                            feather.icons['trash-2'].toSvg({
                                class: 'font-medium-4 text-danger'
                            }) +
                            '</a>'
                        );
                    }
                },
                {
                    "defaultContent": "-",
                    "targets": "_all"
                }
            ],
            "order": [
                [0, 'asc']
            ],
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
        // Filter form control to default size for all tables
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
        // $('div.head-label').html('<h3 class="mb-0">Units</h3>');
    });
</script>
<script>
    $('#add').on('click', function() {
        $('#add').attr("disabled", true);
        var name = $('#name').val();
        if (name == "") {
            Swal.fire({
                icon: 'Error',
                title: 'units',
                text: 'All input field is required'
            });
            return false;
        }
        $.ajax({
            url: "{{route('admin.units.store')}}",
            method: 'POST',
            data: {
                name: name,
                '_token': "{{ csrf_token() }}"
            },
            success: function() {
                toastr.success('units inserted Successfully.');
                $('#name').val('');
                datatable.ajax.reload();
            }
        });
    });
    $('#update').on('click', function() {
        $('#update').attr("disabled", true);
        var id = $('#id').val();
        var name = $('#name').val();
        $.ajax({
            url: "{{route('admin.units.update')}}",
            method: 'POST',
            data: {
                id: id,
                name: name,
                '_token': "{{ csrf_token() }}"
            },
            success: function() {
                $('#name').val('');
                toastr.success('units updated successfully');
                $('#update').hide();
                $('#add').show();
                datatable.ajax.reload();
            }
        });
        $('#save').hide();
    });

    // $('.delete').on('click', function() {
    function _delete(id) {
        // alert("You clicked me!");
        // var id = $(this).attr("id");
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
                    url: "{{route('admin.units.delete')}}",
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
    // });

    // $('.edit').on('click', function() {
    function _edit(id) {
        $('#update').show();
        $('#add').hide();
        // var id = $(this).attr("id");
        $.ajax({
            url: "{{route('admin.units.edit')}}",
            method: 'POST',
            data: {
                id: id,
                '_token': "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#id').val(data.id);
                $('#name').val(data.units);
                fetch_units()
            }
        });
    }
    // });
</script>
@endpush