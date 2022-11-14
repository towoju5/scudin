@extends('layouts.backend')

@section('title', 'Categories')

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
            <th>{{ __('Name') }}</th>
            <th>{{ __('Slug') }}</th>
            <th>{{ __('Created at') }}</th>
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
            <h4 class="modal-title" id="myModalLabel1">{{ __('Create New Category') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="add_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">

              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_name">{{ __('Category Name') }}</label>
                    <input type="text" class="form-control" placeholder="Category Name" name="cat_name" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_image">{{ __('Category Image') }}</label>
                    <input type="file" class="form-control" name="cat_image" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <!-- Flat fee -->
                <div class="col-md-6">
                  <div class="mb-1">
                    <label class="form-label" for="p_type">{{ __('Product') }} {{ __('Type') }}</label>
                    <select required class="form-control" name="p_type">
                      <option selected disabled>Select Product Type</option>
                      <option value="car">Automobile</option>
                      <option value="tech">Electronics</option>
                      <option value="others">Others</option>
                    </select>
                  </div>
                </div>
                <!-- combined fee -->
                <div class="col-md-6">
                  <div class="mb-1">
                    <label class="form-label" for="commision_type">{{ __('comission') }} {{ __('Type') }}</label>
                    <select required class="form-control" name="commision_type" id="_commision_type">
                      <option selected disabled>Select Comission Type</option>
                      <option value="flat_fee">Flat</option>
                      <option value="percentage">Percentage</option>
                      <option value="combined_fee">Combined (Flat & Percentage)</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <!-- Flat fee -->
                <div class="col-md-6" id="_flat_fees">
                  <div class="mb-1">
                    <label class="form-label" for="flat">{{ __('Flat') }}</label>
                    <input type="number" step="any" class="form-control" placeholder="Ex: 300" name="flat" />
                  </div>
                </div>

                <!-- combined fee -->

                <div class="col-md-6" id="_percentage_fees">
                  <div class="mb-1">
                    <label class="form-label" for="percentage">{{ __('percentage') }}</label>
                    <input type="number" max="100" step="any" class="form-control" placeholder="Ex: 10" name="percentage" />
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
            <h4 class="modal-title" id="myModalLabel1">{{ __('Edit Category') }}</h4>
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
                    <label class="form-label" for="name">{{ __('Category Name') }}</label>
                    <input type="text" id="name" class="form-control" placeholder="Coupon Code" name="name" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_image">{{ __('Category Image') }}</label>
                    <input type="file" id="cat_image" class="form-control" placeholder="Coupon Code" name="image" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Flat fee -->
                <div class="col-md-6">
                  <div class="mb-1">
                    <label class="form-label" for="p_type">{{ __('Product') }} {{ __('Type') }}</label>
                    <select class="form-control" name="p_type" id="edit_p_type">
                      <option selected disabled>Select Product Type</option>
                      <option value="car">Automobile</option>
                      <option value="tech">Electronics</option>
                      <option value="others">Others</option>
                    </select>
                  </div>
                </div>
                <!-- combined fee -->
                <div class="col-md-6">
                  <div class="mb-1">
                    <label class="form-label" for="commision_type">{{ __('comission') }} {{ __('Type') }}</label>
                    <select class="form-control commision_type" name="commision_type" id="edit_commision_type">
                      <option selected disabled>Select Comission Type</option>
                      <option value="flat_fee">Flat</option>
                      <option value="percentage">Percentage</option>
                      <option value="combined_fee">Combined (Flat & Percentage)</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <!-- Flat fee -->
                <div class="col-md-6" id="edit_flat_fees">
                  <div class="mb-1">
                    <label class="form-label" for="flat">{{ __('Flat') }}</label>
                    <input type="number" step="any" id="edit_flat" class="form-control flat" placeholder="Ex: 300" name="flat" />
                  </div>
                </div>
                <!-- combined fee -->
                <div class="col-md-6" id="edit_percentage_fees">
                  <div class="mb-1">
                    <label class="form-label" for="percentage">{{ __('percentage') }}</label>
                    <input type="number" max="100" step="any" id="edit_percentage" class="form-control percentage" placeholder="Ex: 10" name="percentage" />
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
  $("#_flat_fees").hide();
  $("#_percentage_fees").hide();
  $("#_commision_type").change(function() {
    var type = $("#_commision_type").val()
    if (type == 'combined_fee') {
      $("#_flat_fees").show();
      $("#_percentage_fees").show();
    } else if (type == 'flat_fee') {
      $("#_flat_fees").show();
      $("#_percentage_fees").hide();
    } else if (type == 'percentage') {
      $("#_flat_fees").hide();
      $("#_percentage_fees").show();
    }
  });

  //------------ Edit Modal ------------
  $("#edit_flat_fees").hide();
  $("#edit_percentage_fees").hide();
  $("#edit_commision_type").change(function() {
    var _type = $("#edit_commision_type").val()
    if (_type == 'combined_fee') {
      $("#edit_flat_fees").show();
      $("#edit_percentage_fees").show();
    } else if (_type == 'flat_fee') {
      $("#edit_flat_fees").show();
      $("#edit_percentage_fees").hide();
    } else if (_type == 'percentage') {
      $("#edit_flat_fees").hide();
      $("#edit_percentage_fees").show();
    }
  });


  var datatable;
  var rowid;
  $(document).ready(function() {
    datatable = $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ordering: false,
      ajax: "{{ route('admin.category.view') }}",
      columns: [{
          data: 'name'
        },
        {
          data: 'slug'
        },
        {
          data: 'created_at'
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
        }) + 'New Category',
        className: 'create-new btn btn-primary m-1',
        attr: {
          'onclick': '$("#add_modal").modal("show")',
          'data-bs-toggle': 'modal',
          'data-bs-target': '#add_modal'
        },
        init: function(api, node, config) {
          $(node).removeClass('btn-secondary');
        }
      }, {
        text: feather.icons['plus'].toSvg({
          class: 'me-50 font-small-4'
        }) + 'Add Sub Category',
        className: 'create-new btn btn-primary m-1',
        attr: {
          'onclick': "location.href='\{{route('admin.sub-category.view')}}\'",
        },
        init: function(api, node, config) {
          $(node).removeClass('btn-secondary');
        }
      }, {
        text: feather.icons['plus'].toSvg({
          class: 'me-50 font-small-4'
        }) + 'Add Sub-sub Category',
        className: 'create-new btn btn-primary m-1',
        attr: {
          'onclick': "location.href='\{{route('admin.sub-sub-category.view')}}\'",
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
    $('div.head-label').html('<h3 class="mb-0">Categories</h3>');
  });

  $("#add_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{route('admin.category.store')}}",
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
            title: '{{ __("Category has been added successfully!") }}'
          })
        }

      }
    });
  });
  // Update record
  $("#edit_form").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{url('shop/cat/update')}}" + '/' + rowid,
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
            title: '{{ __("Category has been Updated Successfully!") }}'
          });
        }

      }
    });
  });

  function edit(id) {
    rowid = id;
    $.ajax({
      url: "{{url('shop/cat/edit')}}" + "/" + rowid,
      type: "get",
      success: function(response) {
        $("#name").val(response.name);
        $("#edit_p_type").val(response.p_type);
        // $("#cat_image").val(response.icon);
        $("#edit_commision_type").val(response.commision_type);
        $("#edit_flat").val(response.flat);
        $("#edit_percentage").val(response.percentage);
        $("#edit_modal").modal("show");
        if (response.percentage != 0) {
          $("#edit_percentage_fees").show();
        }
        if (response.flat != 0) {
          $("#edit_flat_fees").show();
        }
      },
    });
  }

  $("#edit_coupon_value").on('change', function() {
    if ($(".edit_coupon_type").val() == 'percent') {
      $(".edit_coupon_value").attr('max', '100');
    }
    if ($(".edit_coupon_type").val() == 'fixed') {
      $(".edit_coupon_value").removeAttr('max');
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
          url: "{{route('admin.category.delete')}}",
          type: "DELETE",
          data: {
            id: id,
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