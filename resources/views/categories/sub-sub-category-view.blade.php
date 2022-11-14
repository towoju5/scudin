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
            <h4 class="modal-title" id="myModalLabel1">{{ __('Create New Sub Category') }}</h4>
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
                    <label class="form-label" for="name">{{ __('Category Name') }}</label>
                    <input type="text" class="form-control" placeholder="Enter Category Name" name="name" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_id">{{ __('select_category_name') }}</label>
                    <select name="cat_id" id="cat_id" class="form-control">
                      <option value="0" selected disabled>{{ __('select_category_name')}}</option>
                      @foreach (App\Model\Category::where('position',0)->get() as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="parent_id">{{ __('select_sub_category_name') }}</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                      <!-- <option value=""></option> -->
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_image">{{ __('Category Image') }}</label>
                    <input type="file" id="cat_image" class="form-control" placeholder="Coupon Code" name="cat_image">
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
            <h4 class="modal-title" id="myModalLabel1">{{ __('Edit Sub Category') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" id="edit_form">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="name">{{ __('Category Name') }}</label>
                    <input type="hidden" id="cat__id" name="id" value="" required />
                    <input type="text" id="name" class="form-control" placeholder="Category Name" name="name" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="parent_id">{{ __('Parent Category Name') }}</label>
                    <select name="parent_id" id="edit_parent_id" class="form-control">
                      <option value="0" selected disabled>Select Category</option>
                      @foreach (App\Model\Category::where('position',0)->get() as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="cat_image">{{ __('Category Image') }}</label>
                    <input type="file" id="cat_image" class="form-control" placeholder="Coupon Code" name="cat_image" />
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
      ajax: "{{ route('admin.sub-sub-category.view') }}",
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
        }) + 'Add New',
        className: 'create-new btn btn-primary m-1',
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
    $('div.head-label').html('<h3 class="mb-0">Sub Categories</h3>');
  });

  $("#add_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{route('admin.sub-sub-category.store')}}",
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
      url: "{{ route('admin.sub-sub-category.update')}}",
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
      url: "{{url('admin/sub-sub-category/fetch')}}/" + rowid,
      type: "get",
      success: function(response) {
        //alert(response.parent_id)
        $("#name").val(response.name);
        $("#edit_parent_id").val(response.parent_id);
        $("#edit_modal").modal("show");
      },
    });
  }

  $("#edit_coupon_value").on('change', function() {
    if ($("#edit_coupon_type").val() == 'percent') {
      $("#edit_coupon_value").attr('max', '100');
    }
    if ($("#edit_coupon_type").val() == 'fixed') {
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
          url: "{{ route('admin.sub-sub-category.delete') }}",
          type: "post",
          data: {
            id: id,
            _token: "{{ csrf_token() }}"
          },
          'dataType': "JSON",
          success: function(response) {
            if (response.error_message) {
              toastr.error("An error has been occured! Please Contact Administrator.")
            } else {
              datatable.ajax.reload();
              toastr.success("Deleted successfully");
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

  $('#cat_id').on('change', function() {
    var id = $(this).val();
    if (id) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        type: 'POST',
        url: '{{route("admin.sub-sub-category.getSubCategory")}}',
        data: {
          id: id,
          '_token': "{{ csrf_token() }}"
        },
        success: function(result) {
          $("#parent_id").html(result);
        }
      });
    }
  });
</script>

@endsection