@extends('layouts.backend')

@section('title','Add Menu Links')


@section('content')
<section class="app-user-list">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0 d-flex justify-content-between">
        <h1 class="page-header-title">Edit Menu ({{ $menu->menu_title }})</h1>
        <button class="btn btn-sm btn-primary" onclick="window.history.back()" type="button"> <i class="fa fa-arrow-left"></i> Back</button>
      </div>
    </div>
  </div>
  <!-- list section start -->
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.menu.edit', $menu->id) }}" method="post" enctype="multipart/form-data" id="admin-profile-form">
        @csrf
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
          <!-- Body -->
          <div class="card-body">
            <!-- Form -->
            <!-- Form Group -->

            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Menu Title') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="text" class="form-control" value="{{ $menu->menu_title }}" placeholder="Basic Plan" name="menu_title">
                  <input type="hidden" name="update_data" value="{{ $menu->id }}">
                </div>
              </div>
            </div>


            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Menu Link') }} </label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="text" min="1" class="form-control" value="{{ $menu->menu_link }}" placeholder="30" name="menu_link">
                </div>
              </div>
            </div>


            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Menu Type') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <select class="form-control" name="menu_type" onchange="checkColumn(this.value)" id="menu_type">
                  <?php $menu_type = $menu->menu_type ?>
                    <option @if($menu_type == 'header') selected @endif value="header">Header</option>
                    <option @if($menu_type == 'footer') selected @endif value="footer">Footer</option>
                    <option @if($menu_type == 'header_1') selected @endif value="header_1">After Logo</option>
                    <option @if($menu_type == 'header_2') selected @endif value="header_2">After Search</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row form-group" id="menu_column_div">
              <label class="col-sm-3 col-form-label input-label">{{ __('Menu Column') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <select class="form-control" name="menu_column" id="menu_column">
                     <?php $menu_column = $menu->menu_column ?>
                    <option @if($menu_column == 'column_1') selected @endif value="column_1">Column 1</option>
                    <option @if($menu_column == 'column_2') selected @endif value="column_2">Column 2</option>
                    <option @if($menu_column == 'column_3') selected @endif value="column_3">Column 3</option>
                    <option @if($menu_column == 'column_4') selected @endif value="column_4">Column 4</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="text-center mt-1">
              <button type="submit" class="btn btn-rounded btn-warning ">Add Menu</button>
            </div>
            <!-- End Form Group -->

          </div>
          <!-- End Body -->
        </div>
        <!-- End Card -->
      </form>
    </div>
  </div>
  <!-- list section end -->
</section>
<script>
  $("#menu_column_div").hide();

  function checkColumn(type) {
    if (type == 'footer') {
      $("#menu_column_div").show();
    } else {
      $("#menu_column_div").hide();
    }
  }
</script>
@endsection