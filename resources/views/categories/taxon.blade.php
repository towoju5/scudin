@extends('layouts.backend')

@section('title', 'Coupons')

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
            <th>{{ __('Parent Category') }}</th>
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
            <h4 class="modal-title" id="myModalLabel1">Add Coupon</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="add_form">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="coupon_code">Coupon Code</label>
                    <input type="text" id="coupon_code" class="form-control" placeholder="Coupon Code" name="coupon_code" required />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="coupon_type">Coupon Type</label>
                    <select name="coupon_type" id="coupon_type" class="form-control" data-placeholder="Select Subject" required>
                      <option value="fixed">Fixed Price</option>
                      <option value="percent">Percentage(%)</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="coupon_value" class="form-label">Coupon Value</label>
                    <input class="form-control" type="number" maxlength="10" name="coupon_value" id="coupon_value" placeholder="Ex: 30">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-outline-success">Reset</button>
              <button type="submit" class="btn btn-primary" id="save">Save</button>
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
            <h4 class="modal-title" id="myModalLabel1">Edit Coupon</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="edit_form">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="coupon_code">Coupon Code</label>
                    <input type="text" id="edit_coupon_code" class="form-control" placeholder="Coupon Code" name="coupon_code" required />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="coupon_type">Coupon Type</label>
                    <select name="coupon_type" id="edit_coupon_type" class="form-control" data-placeholder="Select Subject" required>
                      <option value="fixed">Fixed Price</option>
                      <option value="percent">Percentage(%)</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label for="coupon_value" class="form-label">Coupon Value</label>
                    <input class="form-control" type="number" maxlength="10" name="coupon_value" id="edit_coupon_value" placeholder="Ex: 30">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-outline-success">Reset</button>
              <button type="submit" class="btn btn-primary" id="save">Save</button>
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
      ajax: "{{ route('coupon.index') }}",
      columns: [{
          data: 'code'
        },
        {
          data: 'type'
        },
        {
          data: 'value'
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
    $('div.head-label').html('<h6 class="mb-0">Coupons</h6>');
  });

  $("#add_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{route('coupon.store')}}",
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
            title: 'An error has been occured! Please Contact Administrator.'
          })
        } else {
          $('#add_form')[0].reset();
          $("#add_modal").modal("hide");
          datatable.ajax.reload();
          swal.fire({
            icon: 'success',
            title: 'coupon has been Added Successfully!'
          })
        }

      }
    });
  });
  // Update record
  $("#edit_form").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{url('shop/coupon/edit')}}" + '/' + rowid,
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
            title: 'coupon has been Updated Successfully!'
          });
        }

      }
    });
  });

  function edit(id) {
    rowid = id;
    $.ajax({
      url: "{{url('shop/coupon')}}" + "/" + rowid + '/edit',
      type: "get",
      success: function(response) {
        $("#edit_coupon_code").val(response.code);
        $("#edit_coupon_type").val(response.type);
        $('#edit_coupon_value').val(response.value);
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
          url: "coupon/" + id + '/destroy',
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
              datatable.ajax.reload();
              toastr.success({
                icon: 'success',
                title: 'coupon has been Deleted Successfully!'
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