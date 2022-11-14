@extends('layouts.backend')
@section('title','Edit Role')
@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Role Update</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('custom_role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.custom-role.update',[$role['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('role_name')}}</label>
                            <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="Ex : Store">
                        </div>

                        <label for="module">{{__('module_permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="product" class="form-check-input"
                                           id="product" {{in_array('product',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="product">{{__('product')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order" {{in_array('order',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="order">{{__('Order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category" {{in_array('category',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="category">{{__('category')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="brand" class="form-check-input"
                                           id="brand" {{in_array('brand',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="brand">{{__('brand')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="deal" class="form-check-input"
                                           id="deal" {{in_array('deal',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="deal">{{__('deal')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="seller" class="form-check-input"
                                           id="seller" {{in_array('seller',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="seller">{{__('Seller')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee" {{in_array('employee',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="employee">{{__('Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon" {{in_array('coupon',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="coupon">{{__('Coupon')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="messages" class="form-check-input"
                                           id="messages" {{in_array('messages',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="messages">{{__('messages')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role" {{in_array('custom_role',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="custom_role">{{__('custom_role')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="business_settings" class="form-check-input"
                                           id="business_settings" {{in_array('business_settings',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="business_settings">{{__('business_settings')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification" {{in_array('notification',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="notification">{{__('Notification')}} </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner" {{in_array('banner',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="banner">{{__('Banner')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute" {{in_array('attribute',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="attribute">{{__('Attribute')}}</label>
                                </div>
                            </div>
                            

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="customerList" class="form-check-input"
                                           id="customerList" {{in_array('customerList',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="customerList">{{__('Customer')}} {{__('List')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="productReview" class="form-check-input"
                                           id="productReview" {{in_array('productReview',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="productReview">{{__('Product')}} {{__('Review')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                               id="report" {{in_array('report',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" for="report">{{__('Report')}}</label>
                                    </div>
                                </div>
                            
                        </div>
                            
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
