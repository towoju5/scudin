@extends('layouts.backend')

@section('title', 'Staff')

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
            <th>{{ __('Staff Name') }}</th>
            <th>{{ __('Staff Email') }}</th>
            <th>{{ __('Date Added') }}</th>
            <th>{{ __('Action') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list section end -->
  <div class="modal-size-lg d-inline-block">
    <!--Add Modal -->
    <div class="modal fade text-left" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel1">Add Staff</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="add_form" autocomplete="off">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <input type="hidden" name="shop" value="{{ auth('seller')->id() }}">
                    <label class="form-label" for="staff_name">Staff Name</label>
                    <input type="text" id="staff_name" autofocus class="form-control" placeholder="John Doe" name="staff_name" required />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="staff_email" class="form-label">Staff Email</label>
                    <input class="form-control" type="email" name="staff_email" id="staff_email" placeholder="mystaff@example.com">
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="staff_password" id="password" class="form-control" data-placeholder="Staff Login Password" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-outline-success">Reset</button>
              <button type="submit" class="btn btn-primary" id="save">Create staff</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--End Add Modal -->

    <!--start edit Modal -->
    <div class="modal fade text-left" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel1">Edit Staff</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="edit_form" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="edit_name">Staff Name </label>
                    <input type="text" id="edit_name" autofocus class="form-control" placeholder="Staff Name" name="staff_name" required />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="edit_email" class="form-label">Staff Email</label>
                    <input type="email" name="staff_email" id="edit_email" class="form-control" data-placeholder="Staff Email" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="staff_password" class="form-label">Password</label>
                    <input type="password" autocomplete="off" name="staff_password" id="staff_password" class="form-control" data-placeholder="Staff Login Password" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-outline-success">Reset</button>
              <button type="submit" class="btn btn-primary" id="save_update">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--End edit Modal -->
  </div>
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
<script>
  var datatable;
  var rowid;
  $(document).ready(function() {
    datatable = $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: "{{ route('staff.index') }}",
      columns: [{
          data: 'name'
        },
        {
          data: 'email'
        },
        {
          data: 'created_at'
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
          'onclick': '$("#add_modal").modal("show")',
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
    $('div.head-label').html('<h1 class="mb-0">Staffs</h1>');
  });

  $("#add_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{route('staff.store')}}",
      type: "post",
      data: new FormData(this),
      processData: false,
      contentType: false,
      responsive: true,
      success: function(response) {
        if (response.errors) {
          $.each(response.errors, function(index, value) {
            swal.fire({
              icon: 'error',
              title: value
            })
          });
        } else if (response.error_message) {
          swal.fire({
            icon: 'error',
            title: response.error_message
          })
        } else {
          $('#add_form')[0].reset();
          $("#add_modal").modal("hide");
          datatable.ajax.reload();
          swal.fire({
            icon: 'success',
            title: 'Staff has been Added Successfully!'
          })
        }

      }
    });
  });
  // Update record
  $("#edit_form").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{url('seller/shop/staff')}}/"+rowid,
      type: "post",
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.errors) {
          $.each(response.errors, function(index, value) {
            swal.fire({
              icon: 'error',
              title: value
            })
          });
        } else if (response.error_message) {
          swal.fire({
            icon: 'error',
            title: 'An error has been occured! Please Contact Administrator.'
          })
        } else {
          $("#edit_modal").modal("hide");
          datatable.ajax.reload();
          swal.fire({
            icon: 'success',
            title: 'Staff has been Updated Successfully!'
          });
        }

      }
    });
  });

  function edit(id) {
    rowid = id;
    $.ajax({
      url: "{{url('seller/shop/staff')}}/"+rowid+"/edit",
      type: "get",
      success: function(response) {
        $("#edit_name").val(response.name);
        $("#edit_email").val(response.email);
        $("#edit_modal").modal("show");
      },
    });
  }

  $("#edit_coupon_value").on('change', function() {
    if ($("#edit_coupon_type").val() == 'percent') {
      $("#edit_coupon_value").attr('max', '100');
    }
    if ($("#edit_coupon_type").val() == 'fixed'){
      $("#edit_coupon_value").removeAttr('max');
    }
  });

  $("#addNew").click(function() {
    $("#add_modal").modal("show");
  });

  function delete_item(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes, delete it!",
      customClass: {
        confirmButton: "btn btn-primary mr-1",
        cancelButton: "btn btn-outline-danger mr-1",
      },
      buttonsStyling: !1,
    }).then(function(t) {
      t.value ?
        ($.ajax({
          url: "{{url('seller/shop/staff')}}/" + id + '/destroy',
          type: "DELETE",
          data: {
            _token: "{{ csrf_token() }}"
          },
          'dataType': "JSON",
          success: function(response) {
            if (response.error_message) {
              toastr.error({
                icon: 'error',
                title: 'An error has been occured! Please Contact Administrator.'
              })
            } else {
              console.log(response)
              swal.fire({
                icon: 'success',
                title: 'Staff has been Deleted Successfully!'
              })
              datatable.ajax.reload();
              toastr.success({
                icon: 'success',
                title: 'Staff has been Deleted Successfully!'
              })
            }
          }
        })) :
        t.dismiss === Swal.DismissReason.cancel &&
        Swal.fire({
          title: "Cancelled",
          text: "Delete action cancelled successfully",
          icon: "error",
          customClass: {
            confirmButton: "btn btn-success"
          },
        });
    });
  }
</script>

@endsection