@extends('layouts.backend')

@section('title','Add Subscription')


@section('content')
<section class="app-user-list">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Add Subscription</h1>
      </div>
    </div>
  </div>
  <!-- list section start -->
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.subscription.add') }}" method="post" enctype="multipart/form-data" id="admin-profile-form">
        @csrf
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
          <!-- Body -->
          <div class="card-body">
            <!-- Form -->
            <!-- Form Group -->
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Plan Name') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="text" class="form-control" placeholder="Basic Plan" name="plan_name">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Plan Price') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="text" class="form-control" placeholder="500" name="plan_price">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Plan Period') }} <br> <small>Use 0 for unexpiring subscription</small> </label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="number" min="1" class="form-control" placeholder="30" name="plan_duration">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Allowed Products') }} <br><small>Use -1 for unlimited products</small> </label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <input type="number" class="form-control" placeholder="50" name="allowed_products">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Plan Descripton') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <textarea name="description" id="description" class="form-control" cols="5" rows="5" placeholder="Plan description: Can span multiple line and can accept html codes"></textarea>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-sm-3 col-form-label input-label">{{ __('Plan Users') }}</label>
              <div class="col-sm-6">
                <div class="input-group input-group-sm-down-break">
                  <select class="form-control" name="plan_user_type" id="plan_user_type">
                    <option value="seller">Sellers</option>
                    <option value="users">Students</option>
                    <option value="customers">Customers</option>
                    <option value="all">All Users</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="text-center mt-1">
              <button type="submit" class="btn btn-rounded btn-warning ">Add Plan</button>
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
@endsection