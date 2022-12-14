@extends('layouts.backend')
@section('title','Product Edit')
@push('css_or_js')
<link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">
<link href="{{asset('assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/back-end/css/custom.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 23px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #377dff;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #377dff;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    #product-images-modal .modal-content {
        width: 1116px !important;
        margin-left: -264px !important;
    }

    #thumbnail-image-modal .modal-content {
        width: 1116px !important;
        margin-left: -264px !important;
    }

    @media(max-width:768px) {
        #product-images-modal .modal-content {
            width: 698px !important;
            margin-left: -75px !important;
        }

        #thumbnail-image-modal .modal-content {
            width: 698px !important;
            margin-left: -75px !important;
        }
    }

    @media(max-width:375px) {
        #product-images-modal .modal-content {
            width: 367px !important;
            margin-left: 0 !important;
        }

        #thumbnail-image-modal .modal-content {
            width: 367px !important;
            margin-left: 0 !important;
        }
    }

    @media(max-width:500px) {
        #product-images-modal .modal-content {
            width: 400px !important;
            margin-left: 0 !important;
        }

        #thumbnail-image-modal .modal-content {
            width: 400px !important;
            margin-left: 0 !important;
        }

        .btn-for-m {
            margin-bottom: 10px;
        }

        .parcent-margin {
            margin-left: 0px !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Heading -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('seller.product.list', 'in_house')}}">{{__('Product')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Edit')}}</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('Product')}} {{__('Edit')}} </h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form class="product-form" action="{{route('seller.product.update',$product->id)}}" method="post" enctype="multipart/form-data" id="product_form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('General Info')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{__('Product Name')}}</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Ex : LUX" value="{{$product->name}}">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">{{__('Category')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control ecat_id" name="category_id" id="category_id" onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                        <option value="0" selected disabled>---Select---</option>
                                        @foreach($categorys as $category)
                                        <option value="{{$category['id']}}" {{ $category->id==$product_category[0]->id ? 'selected' : ''}}>{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">{{__('Sub Category')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="sub_category_id" id="sub-category-select" data-id="{{count($product_category)>=2?$product_category[1]->id:''}}" onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">{{__('Sub Sub Category')}}</label>

                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" data-id="{{count($product_category)>=3?$product_category[2]->id:''}}" name="sub_sub_category_id" id="sub-sub-category-select">

                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">{{__('Brand')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="brand_id">
                                        <option value="{{null}}" selected disabled>---Select---</option>
                                        @foreach($br as $b)
                                        <option value="{{$b['id']}}" {{ $b->id==$product->brand_id ? 'selected' : ''}}>{{$b['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="name">{{__('Unit')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="unit">
                                        @foreach(\App\CPU\Helpers::units() as $x)
                                        <option value="{{$x->units}}" {{ $product->unit == $x->units ? 'selected':''}}>{{$x->units}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="weight">{{__('weight')}}</label>
                                    <input type="number" name="weight" class="form-control" step="any" id="weight"  value="{{ $product->weight }}" placeholder="Ex : 2" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <h4>{{__('Variation')}}</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="colors">
                                        {{__('Colors')}} :
                                    </label>
                                    <label class="switch">
                                        <input type="checkbox" class="status" name="colors_active" {{count($product['colors'])>0?'checked':''}}>
                                        <span class="slider round"></span>
                                    </label>

                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select" name="colors[]" multiple="multiple" id="colors-selector" {{count($product['colors'])>0?'':'disabled'}}>
                                        @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                        <option value={{ $color->code }} {{in_array($color->code,$product['colors'])?'selected':''}}>
                                            {{$color['name']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="attributes" style="padding-bottom: 3px">
                                        {{__('Attributes')}} :
                                    </label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                        @foreach (\App\Model\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                                        @if($product['attributes']!='null')
                                        <option value="{{ $a['id']}}" {{in_array($a->id,json_decode($product['attributes'],true))?'selected':''}}>
                                            {{$a['name']}}
                                        </option>
                                        @else
                                        <option value="{{ $a['id']}}">{{$a['name']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-2 mb-2">
                                    <div class="customer_choice_options" id="customer_choice_options">
                                        @include('seller-views.product.partials._choices',['choice_no'=>json_decode($product['attributes']),'choice_options'=>json_decode($product['choice_options'],true)])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h4>Product Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-4">
                                <label for="product_type">
                                    Downloadable Product? :
                                </label>
                                <select class="form-control" onchange="_type(this.value)" id="product_type"
                                    name="product_type">
                                    <option value="0"> No </option>
                                    <option value="1"> Yes </option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label for="download_url">
                                    {{__('Download URL')}} :
                                </label>
                                <input type="url" class="form-control" name="download_url" id="download_url" disabled>
                            </div>
                            </div>
                        </div>
                        <script>
                        function _type(t) {
                            if (t == 1) {
                            $("#download_url").removeAttr('disabled', true)
                            } else {
                            $("#download_url").attr('disabled', true)
                            }
                        }
                        </script>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <h4>{{__('Product price & stock')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">{{__('Unit price')}}</label>
                                    <input type="number" min="0" step="any" placeholder="{{__('Unit price') }}" name="unit_price" class="form-control" value={{\App\CPU\Convert::default($product->unit_price)}} required>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">{{__('Purchase price')}}</label>
                                    <input type="number" min="0" step="any" placeholder="{{__('Purchase price') }}" name="purchase_price" class="form-control" value={{ \App\CPU\Convert::default($product->purchase_price) }} required>
                                </div>

                                <div class="col-md-4 pt-2">
                                    <label class="control-label">{{__('height')}}</label>
                                    <input type="number" min="0" step="0.01" value="{{ $product->height }}" name="height" class="form-control">
                                </div>

                                <div class="col-md-4 pt-2">
                                    <label class="control-label">{{__('length')}}</label>
                                    <input type="number" min="0" step="0.01" value="{{ $product->length }}" name="length" class="form-control">
                                </div>
                                <div class="col-md-4 pt-2">
                                    <label for="">{{__('width')}}</label>
                                    <input type="number" min="0" step="0.01" value="{{ $product->width }}" name="width" class="form-control">
                                </div>

                                <div class="col-md-4 pt-2">
                                    <label class="control-label">{{__('Tax')}}</label>
                                    <label class="badge badge-info">{{__('Percent')}} ( % )</label>
                                    <input type="number" min="0" value="8.6" disabled step="0.01" placeholder="{{__('Tax') }}" name="tax" class="form-control" required>
                                    <input name="tax_type" value="percent" style="display: none">
                                </div>

                                <div class="col-md-4 pt-2">
                                    <label class="control-label">{{__('Discount')}}</label>
                                    <input type="number" min="0" value={{ $product->discount_type=='flat'?\App\CPU\Convert::default($product->discount): $product->discount}} step="0.01" placeholder="{{__('Discount') }}" name="discount" class="form-control" required>
                                </div>
                                <div class="col-md-4 pt-2">
                                    <label class="control-label">{{__('Discount')}} {{__('Type')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive demo-select2" name="discount_type">
                                        <option value="percent" {{$product['discount_type']=='percent'?'selected':''}}>{{__('Percent')}}</option>
                                        <option value="flat" {{$product['discount_type']=='flat'?'selected':''}}>{{__('Flat')}}</option>
                                    </select>
                                </div>

                                <div class="col-12 pt-4 sku_combination" id="sku_combination">
                                    @include('seller-views.product.partials._edit_sku_combinations',['combinations'=>json_decode($product['variation'],true)])
                                </div>
                                <div class="col-md-6" id="quantity">
                                    <label class="control-label">{{__('total')}} {{__('Quantity')}}</label>
                                    <input type="number" min="0" value={{ $product->current_stock }} step="1" placeholder="{{__('Quantity') }}" name="current_stock" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <br>
                    </div>
                </div>
                @if(!empty($product->extra_data))   
                <div id="additional"></div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Product Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-xl-12">
                                <textarea name="details" id="editor" cols="30" rows="10">{{$product['details']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{__('Upload product images')}}</label><small style="color: red">* ( {{__('ratio')}} 1:1 )</small>
                                </div>
                                <div class="p-2 border border-dashed" style="max-width:430px;">
                                    <div class="row" id="coba">
                                        @foreach (json_decode($product->images) as $key => $photo)
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <img style="width: 100%" height="auto" onerror="this.src='<?= asset('assets/front-end/img/image-place-holder.png') ?>'" src="{{asset("storage/app/public/product/$photo")}}" alt="Product image">
                                                    <a href="{{route('seller.product.remove-image',['id'=>$product['id'],'name'=>$photo])}}" class="btn btn-danger btn-block">Remove</a>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{__('Upload thumbnail')}}</label><small style="color: red">* ( {{__('ratio')}} 1:1 )</small>
                                </div>
                                <div style="max-width:200px;">
                                    <div class="row" id="thumbnail">
                                        <img src='asset("$product->thumbnail")' alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px">
                                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'product-images-modal'])

    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'thumbnail-image-modal'])

    {{--@include('shared-partials.image-process._image-crop-modal',['modal_id'=>'hot-deal-image-modal'])

    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'featured-image-modal'])--}}
    <!--modal-->
</div>
@endsection


@push('js')
    <script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('assets/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
    var imageCount = '<?= 4 - count(json_decode($product->images)) ?>';
    var thumbnail = '{{asset("$product->thumbnail") ?? asset("img2.jpg") }}';
        $(function () {
            if(imageCount > 0)
            {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-md-6',
                    maxFileSize: '',
                    placeholderImage: {
                        image: "{{asset('assets/back-end/img/400x400/img2.jpg')}}",
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    onAddRow: function (index, file) {

                    },
                    onRenderedPreview: function (index) {

                    },
                    onRemoveRow: function (index) {

                    },
                    onExtensionErr: function (index, file) {
                        toastr.error('Please only input png or jpg type file', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function (index, file) {
                        toastr.error('File size too big', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: thumbnail,
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }
        

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{__('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{__('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        setTimeout(function () {
            $('.call-update-sku').on('change', function () {
                update_sku();
            });
        }, 2000)

        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            update_sku();
        });

        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('seller.product.sku-combination')}}",
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    update_qty();
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        $(document).ready(function () {
            setTimeout(function () {
                let category = $("#category_id").val();
                let sub_category = $("#sub-category-select").attr("data-id");
                let sub_sub_category = $("#sub-sub-category-select").attr("data-id");
                getRequest('{{url('/')}}/seller/product/get-categories?parent_id=' + category + '&sub_category=' + sub_category, 'sub-category-select', 'select');
                getRequest('{{url('/')}}/seller/product/get-categories?parent_id=' + sub_category + '&sub_category=' + sub_sub_category, 'sub-sub-category-select', 'select');
            }, 100)
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            update_sub_addtional_data();
            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>
    <script>
        $('#_product_form').submit(function (e) {
            e.preventDefault();
            $('#loading').show();
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            var formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: "{{route('seller.product.update',$product->id)}}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('product updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.reload()
                        }, 2000);
                    }
                }
            });
        });
    </script>
    <script>
        update_qty();
        function update_qty()
        {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for(var i=0; i<qty_elements.length; i++)
            {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if(qty_elements.length > 0)
            {
                
                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val(total_qty);
            }
            else{
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }
        $('input[name^="qty_"]').on('keyup', function () {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for(var i=0; i<qty_elements.length; i++)
            {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });

        
        $("#sub-category-select").change(function() {
            update_sub_addtional_data();
        });

        function update_sub_addtional_data(){            
            var $p_type = $(".ecat_id").val(); console.log($p_type);
            if ($p_type !== '' && $p_type !== null) {
            $.ajax({
                url: "{{ route('get_p_type') }}?type=" + $p_type + "&productId={{ $product->id }}",
                // dataType: 'JSON',
                type: 'get',
                success: function(data) {
                console.log(data);
                $('#additional').empty().append(data);
                },
            });
            }
        }
    </script>
@endpush
