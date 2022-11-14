@extends('layouts.backend')

@section('title', 'All Products')

@section('css')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/dashboard-ecommerce.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/app-user.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/style.css">
<!-- END: Page CSS-->
@endsection

@section('content')
<section class="app-user-list">
  <!-- list section start -->
  <div class="card">
    <div class="card-datatable table-responsive p-1">
      <table class="table" id="dataTable">
        <thead class="thead-light">
          <tr>
            <th></th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Seller') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Current Stock') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Action') }}</th>
          </tr>
        </thead>
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
    datatable = $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: "{{ route('product.index') }}",
      columns: [{
          data: 'id'
        },
        {
          data: 'name'
        },
        {
          data: 'added_by'
        },
        {
          data: 'price'
        },
        {
          data: 'current_stock'
        },
        {
          data: 'status',
          render: function(data) {
            return '<span class="badge rounded-pill badge-light-success">' + (data) + '</span>'
          },
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
              '<a href="javascript:;" onclick="show(' + full.id + ')">' +
              feather.icons['eye'].toSvg({
                class: 'font-medium-4 text-info mr-1'
              }) +
              '</a>' +
              '<a href="javascript:;" class="item-edit" onclick=edit(' + full.id + ')>' +
              feather.icons['edit'].toSvg({
                class: 'font-medium-4 mr-1'
              }) +
              '</a>' +
              '<a href="javascript:;" onclick="delete_item(' + full.id + ')">' +
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
      buttons: [{
        text: feather.icons['plus'].toSvg({
          class: 'me-50 font-small-4'
        }) + 'Add New',
        className: 'create-new btn btn-primary',
        attr: {
          'onclick': 'window.open("'+'{{ route("product.add") }}'+'", "_self")',
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

  function edit(id) {
    rowid = id;
    $.ajax({
      url: "{{url('product.index')}}" + "/" + id + "/edit",
      type: "get",
      success: function(response) {
        $("#edit_name").val(response.name);
        $("#edit_exam_level_type_id").val(response.exam_level_type_id).select2();
        $("#edit_modal").modal("show");
      },
    });
  }

  function show(id) {
    window.location.href = "{{ url('shop/product/p/') }}" + '/' + id
  }

  function delete_item(id) {
    if (confirm("Are You sure want to delete !")) {
      $.ajax({
        url: "product/" + id,
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
              title: 'Product has been Deleted Successfully!'
            })
          }
        }
      });
    }
  }
</script>

@endsection