@extends('layouts.backend')

@section('title', ('Product Bulk Import'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('seller.product.list')}}">{{__('Product')}}</a>
        </li>
        <li class="breadcrumb-item">{{__('bulk_import')}} </li>
    </ol>
</nav>

<!-- Content Row -->
<div class="row" style="text-align: <?= session()->get('direction') === "rtl" ? 'right' : 'left' ?>">
    <div class="col-12">
        <div class="jumbotron mt-2" style="background: white">
            <h1 class="display-4">{{__('Instructions')}} : </h1>
            <p> 1. {{__('Download the format file and fill it with proper data')}}.</p>

            <p>2. {{__('You can download the example file to understand how the data must be filled')}}.</p>

            <p>3. {{__('Once you have downloaded and filled the format file, upload it in the form below and submit')}}.</p>

            <p> 4. {{__('After uploading products you need to edit them and set products images and choices')}}.</p>

            <p> 5. {{__('You can get brand and category id from their list, please input the right ids')}}.</p>
        </div>
    </div>

    <div class="col-md-12">
        <form class="product-form" action="{{route('seller.product.bulk-import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mt-2 rest-part">
                <div class="card-header">
                    <h4>{{__('Import Products File')}}</h4>
                    <a href="{{asset('product_bulk_format.xlsx')}}" download="" class="btn btn-secondary">{{__('Download Format')}}</a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="file" name="products_file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-footer">
                <div class="row">
                    <div class="col-md-12" style="padding-top: 20px">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')

@endpush