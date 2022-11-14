@extends('layouts.backend')

@section('title','Product Preview')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-6">
                <h1 class="page-header-title">{{$product['name']}}</h1>
            </div>
            <div class="col-6">
                <a href="{{url()->previous()}}" class="btn btn-primary float-right">
                    <i class="tio-back-ui"></i> Back
                </a>
            </div>
        </div>
        <!-- Nav -->
        <!-- <ul class="nav nav-tabs page-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:">
                    Product reviews
                </a>
            </li>
        </ul>-->
        <!-- End Nav -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card mb-3 mb-lg-5">
        <!-- Body -->
        <div class="card-body">
            <div class="row align-items-md-center gx-md-5">
                <div class="col-md-auto mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <img class="avatar avatar-xxl avatar-4by3 mr-4" width="50px" src="{{ asset($product->thumbnail) }}" alt="Image Description">

                        <div class="d-block">
                            <h4 class="display-2 text-dark mb-0">{{count($product->rating)>0?number_format($product->rating[0]->average, 2, '.', ' '):0}}</h4>
                            <p> of {{$product->reviews->count()}} reviews
                                <span class="badge badge-dark badge-pill ml-1"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <ul class="list-unstyled list-unstyled-py-2 mb-0">

                        @php($total=$product->reviews->count())
                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            @php($five=\App\CPU\Helpers::rating_count($product['id'],5))
                            <span class="mr-3">5 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$total==0?0:($five/$total)*100}}%;" aria-valuenow="{{$total==0?0:($five/$total)*100}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$five}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            @php($four=\App\CPU\Helpers::rating_count($product['id'],4))
                            <span class="mr-3">4 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$total==0?0:($four/$total)*100}}%;" aria-valuenow="{{$total==0?0:($four/$total)*100}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$four}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            @php($three=\App\CPU\Helpers::rating_count($product['id'],3))
                            <span class="mr-3">3 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$total==0?0:($three/$total)*100}}%;" aria-valuenow="{{$total==0?0:($three/$total)*100}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$three}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            @php($two=\App\CPU\Helpers::rating_count($product['id'],2))
                            <span class="mr-3">2 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$total==0?0:($two/$total)*100}}%;" aria-valuenow="{{$total==0?0:($two/$total)*100}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$two}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            @php($one=\App\CPU\Helpers::rating_count($product['id'],1))
                            <span class="mr-3">1 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar" style="width: {{$total==0?0:($one/$total)*100}}%;" aria-valuenow="{{$total==0?0:($one/$total)*100}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$one}}</span>
                        </li>
                        <!-- End Review Ratings -->
                    </ul>
                </div>

                <div class="col-12">
                    <hr>
                </div>
                <div class="col-4 pt-2">
                    <h4 class="border-bottom">{{$product['name']}}</h4>
                    <span>Price :
                        <span> {{\currency_symbol()}} {{\App\CPU\Convert::default($product['unit_price'])}}
                        </span>
                    </span><br>
                    <span>TAX :
                        <span>{{($product['tax'])}} % </span>
                    </span><br>
                    <span>Discount :
                        <span> {{ $product->discount_type=='flat'?(\App\CPU\Convert::default($product->discount).''.\currency_symbol()): $product->discount.''.'%'}} </span>
                    </span><br>
                    <span>Current Stock :
                        <span>{{ $product->current_stock }}</span>
                    </span>
                </div>

                <div class="col-8 pt-2 border-left">

                    <span> @if (count(json_decode($product->colors)) > 0)
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="product-description-label mt-2">Available color:
                                </div>
                            </div>
                            <div class="col-10">
                                <ul class="list-inline checkbox-color mb-1">
                                    @foreach (json_decode($product->colors) as $key => $color)
                                    <li>
                                        <label style="background: {{ $color }};" for="{{ $product->id }}-color-{{ $key }}" data-toggle="tooltip"></label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </span><br>
                    <span>
                        Product Image

                        <div class="row">
                            @foreach (json_decode($product->images) as $key => $photo)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img style="width: 100%" onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'" src="{{asset("storage/app/public/product/$photo")}}" alt="Product image">

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </span>
                </div>
            </div>
        </div>
        <!-- End Body -->
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="card">
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table">
                <thead class="thead-light">
                    <tr>
                        <th>Reviewer</th>
                        <th>Review</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($product->reviews as $review)
                    <tr>
                        <td>
                            <a class="d-flex align-items-center" href="{{route('admin.customer.view',[$review['customer_id']])}}">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img" onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'" src="{{asset('storage/profile/'.$review->customer->image)}}" width="50px" alt="Image Description">
                                </div>
                                <div class="ml-3">
                                    <span class="d-block h5 text-hover-primary mb-0">{{$review->customer['f_name']." ".$review->customer['l_name']}} <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="Verified Customer"></i></span>
                                    <span class="d-block font-size-sm text-body">{{$review->customer->email}}</span>
                                </div>
                            </a>
                        </td>
                        <td>
                            <div class="text-wrap" style="width: 18rem;">
                                <div class="d-flex mb-2">
                                    <label class="badge badge-info">
                                        {{$review->rating}} <i class="tio-star"></i>
                                    </label>
                                </div>

                                <p>
                                    {{$review['comment']}}
                                </p>
                            </div>
                        </td>
                        <td>
                            {{date('d M Y H:i:s',strtotime($review['created_at']))}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
            <!-- Pagination -->
            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">

                <div class="col-sm-auto">
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <!-- Pagination -->
                        <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                    </div>
                </div>
            </div>
            <!-- End Pagination -->
        </div>
        <!-- End Footer -->
    </div>
    <!-- End Card -->
</div>
@endsection

@push('js')
<script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
<script src="{{ asset('assets/select2/js/select2.min.js')}}"></script>
<script>
    $('input[name="colors_active"]').on('change', function() {
        if (!$('input[name="colors_active"]').is(':checked')) {
            $('#colors-selector').prop('disabled', true);
        } else {
            $('#colors-selector').prop('disabled', false);
        }
    });
    $(document).ready(function() {
        $('.color-var-select').select2({
            templateResult: colorCodeSelect,
            templateSelection: colorCodeSelect,
            escapeMarkup: function(m) {
                return m;
            }
        });

        function colorCodeSelect(state) {
            var colorCode = $(state.element).val();
            if (!colorCode) return state.text;
            return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
        }
    });
</script>
@endpush