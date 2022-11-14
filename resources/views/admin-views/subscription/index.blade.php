@extends('layouts.backend')

@section('title','Subscription List')

@push('css_or_js')
@endpush

@section('content')
<section class="app-user-list">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">Subscription List</h1>
            </div>
        </div>
    </div>
    <!-- list section for user start -->
    <div class="card">
        <div class="card-datatable table-responsive p-1">
            <p class="card-header h2">
                Customers
            </p>
            <table class="table" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>S/N</th>
                        <th>{{ __('Customer Name') }}</th>
                        <th>{{ __('Plan Name') }}</th>
                        <th>{{ __('Plan Price') }}</th>
                        <th>{{ __('Plan Period') }}</th>
                        <th>{{ __('School ID/Tax ID') }}</th>
                        <th>{{ __('Allowed Products') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $k => $sub)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>{{ $sub->plan->plan_name }}</td>
                        <td>{{ format_price($sub->plan->plan_price) }}</td>
                        <td>{{ $sub->plan->plan_duration }} Days</td>
                        <td>{{ $sub->tax_student_id }}</td>
                        <td>{{ $sub->plan->allowed_products }} Products</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- list section end -->


    <!-- list section for sellers start -->
    <div class="card">
        <div class="card-datatable table-responsive p-1">
            <p class="card-header h2">
                Sellers
            </p>
            <table class="table" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>S/N</th>
                        <th>{{ __('Customer Name') }}</th>
                        <th>{{ __('Plan Name') }}</th>
                        <th>{{ __('Plan Price') }}</th>
                        <th>{{ __('Plan Period') }}</th>
                        <th>{{ __('School ID/Tax ID') }}</th>
                        <th>{{ __('Allowed Products') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellers as $k => $seller)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ "$seller->f_name $seller->l_name" }}</td>
                        <td>{{ $seller->plan->plan_name }}</td>
                        <td>{{ format_price($seller->plan->plan_price) }}</td>
                        <td>{{ $seller->plan->plan_duration }} Days</td>
                        <td>{{ $seller->tax_student_id }}</td>
                        <td>{{ $seller->plan->allowed_products }} Products</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- list section end -->
</section>
@endsection


@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script>
    var datatable;
    var rowid;
    $(document).ready(function() {
        datatable = $('-#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: false,
            ajax: "{{ route('admin.subscription.sub.list') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'plan_name'
                },
                {
                    data: 'plan_price'
                },
                {
                    data: 'plan_duration'
                },
                {
                    data: 'plan_user_type'
                },
                {
                    data: 'allowed_products'
                },
                {
                    data: '',
                    searchable: false
                },
            ],
            "columnDefs": [{
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    render: function(data, type, full, meta) {
                        return (
                            '<a href="javascript:;" onclick="delete_item(' + full.id + ')">' +
                            feather.icons['trash-2'].toSvg({
                                class: 'font-medium-4 text-danger'
                            }) +
                            '</a>' +
                            '<a href="javascript:;" class="ml-2" onclick="edit_item(' + full.id + ')">' +
                            feather.icons['edit'].toSvg({
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
            buttons: [{
                text: feather.icons['plus'].toSvg({
                    class: 'me-50 font-small-4'
                }) + 'Add New',
                className: 'create-new btn btn-primary',
                attr: {
                    'onclick': 'window.open("' + '{{ route("admin.subscription.add") }}' + '", "_self")',
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#add_modal'
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }],
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
        $('div.head-label').html('<h6 class="mb-0">My Products</h6>');
    });


    function delete_item(id) {
        if (id == 1) {
            Toast.fire({
                icon: 'error',
                title: "Plan can't be Deleted!"
            })
            return false;
        }
        if (confirm("Are You sure want to delete !")) {
            var $url = "{{ url('admin/plans/delete') }}/";
            $.ajax({
                url: $url + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.error_message) {
                        Toast.fire({
                            icon: 'error',
                            title: 'An error has been occured! Please Contact Administrator.'
                        })
                    } else {
                        datatable.ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Plan Deleted Successfully!'
                        })
                    }
                }
            });
        }
    }

    function edit_item(id) {
        window.location.href = "{{ url('admin/plans/edit') }}?id=" + id;
    }
</script>

@endsection