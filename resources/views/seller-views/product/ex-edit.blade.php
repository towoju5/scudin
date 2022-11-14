@extends('layouts.backend')


@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/plugins/forms/form-quill-editor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/tagsinput.css') }}">
@endsection

@section('title', 'Edit Product')

@section('content')

<?php use \App\CPU\BackEndHelper; ?>
<div class="container-fluid">
   <!-- Page Heading -->
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">Dashboard</a></li>
         <li class="breadcrumb-item" aria-current="page"><a href="{{route('seller.product.list')}}">Product</a></li>
         <li class="breadcrumb-item" aria-current="page">Edit</li>
      </ol>
   </nav>

   <div class="d-sm-flex align-items-center justify-content-between mb-2">
      <h1 class="h3 mb-0 text-black-50">Product Edit</h1>
   </div>

   <!-- Content Row -->
   <div class="row">
      <div class="col-md-12">
         <form class="product-form" action="{{route('seller.product.update', $product->id)}}" method="post"
            enctype="multipart/form-data" id="product_form">
            @csrf
            <div class="card">
               <div class="card-header">
                  <h4>General Info</h4>
               </div>
               <div class="card-body">
                  <div class="form-group">
                     <label for="name">{{__('Product Name')}}</label>
                     <input type="text" name="name" class="form-control" id="name" placeholder="Ex : LUX"
                        value="{{$product->name}}">
                  </div>

                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-4">
                           <label for="name">{{__('Category')}}</label>
                           <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="category_id" id="category_id" onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
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
                           <select class="form-control js-select2-custom" name="brand_id">
                              <option value="{{null}}" selected disabled>---Select---</option>
                              @foreach($br as $b)
                              <option value="{{$b['id']}}" {{ $b->id==$product->brand_id ? 'selected' : ''}}>
                                 {{$b['name']}}</option>
                              @endforeach
                           </select>
                        </div>

                        <div class="col-md-4">
                           <label for="name">{{__('Unit')}}</label>
                           <select class="form-control js-select2-custom" name="unit">
                              @foreach(\App\CPU\Helpers::units() as $x)
                              <option value="{{$x->units}}" {{old('unit')==$x->units ? 'selected':''}}>{{$x->units}}
                              </option>
                              @endforeach
                           </select>
                        </div>

                        <div class="col-md-4">
                           <label for="weight">{{__('weight')}}</label>
                           <input type="number" name="weight" class="form-control" id="weight"
                              value="{{ $product->weight }}" placeholder="Ex : 2" required>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="card mt-2">
               <div class="card-header">
                  <h4>Variations</h4>
               </div>
               <div class="card-body">

                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-6">

                           <label for="colors">
                              {{__('Colors')}} :
                           </label>
                           <label class="switch">
                              <input type="checkbox" class="status" name="colors_active"
                                 {{count($product['colors'])>0?'checked':''}}>
                              <span class="slider round"></span>
                           </label>

                           <select
                              class="select2 js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                              name="colors[]" multiple="multiple" id="colors-selector"
                              {{count($product['colors'])>0?'':'disabled'}}>
                              @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                              <option value={{ $color->code }}
                                 {{in_array($color->code,$product['colors'])?'selected':''}}>
                                 {{$color['name']}}
                              </option>
                              @endforeach
                           </select>
                        </div>

                        <div class="col-md-6">
                           <label for="attributes" style="padding-bottom: 3px">
                              {{__('Attributes')}} :
                           </label>
                           <select
                              class="select2 js-example-basic-multiple js-states js-example-responsive form-control"
                              name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                              @foreach (\App\Model\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                              @if($product['attributes']!='null')
                              <option value="{{ $a['id']}}"
                                 {{in_array($a->id,json_decode($product['attributes'],true))?'selected':''}}>
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
                           <input type="number" min="0" step="any" placeholder="{{__('Unit price') }}" name="unit_price" class="form-control" value={{ $product->unit_price }} required>
                        </div>
                        <div class="col-md-6">
                           <label class="control-label">{{__('Purchase price')}}</label>
                           <input type="number" min="0" step="any" placeholder="{{__('Purchase price') }}" name="purchase_price" class="form-control" value={{ $product->purchase_price }} required>
                        </div>
                     </div>
                     <div class="row pt-2">
                        <div class="col-md-4">
                           <label class="control-label">{{__('height')}}</label>
                           <input type="number" min="0" step="0.01" value="{{ old('height') ?? $product->height }}" name="height" class="form-control">
                        </div>

                        <div class="col-md-4">
                           <label class="control-label">{{__('length')}}</label>
                           <input type="number" min="0" step="0.01" value="{{ old('length') ?? $product->length }}" name="length" class="form-control">
                        </div>
                        <div class="col-md-4">
                           <label for="">{{__('width')}}</label>
                           <input type="number" min="0" step="0.01" value="{{ old('width') ?? $product->width }}" name="width" class="form-control">
                        </div>
                     </div>

                     <div class="row pt-2">
                        <div class="col-md-4">
                           <label class="control-label">{{__('Tax')}}</label>
                           <label class="badge badge-info">{{__('Percent')}} ( % )</label>
                           <input type="number" readonly min="0" value={{ $product->tax }} step="0.01"
                              placeholder="{{__('Tax') }}" name="ddtax" class="form-control" required>
                           <input name="tax_type" value="percent" style="display: none">
                        </div>

                        <div class="col-md-4">
                           <label class="control-label">{{__('Discount')}}</label>
                           <input type="number" min="0"
                              value={{ $product->discount_type=='flat'?\App\CPU\BackEndHelper::usd_to_currency($product->discount): $product->discount}}
                              step="0.01" placeholder="{{__('Discount') }}" name="discount" class="form-control"
                              required>
                        </div>
                        <div class="col-md-4" style="padding-top: 30px;">
                           <select class="form-control js-select2-custom" name="discount_type">
                              <option value="percent">{{__('Percent')}}</option>
                              <option value="flat">{{__('Flat')}}</option>

                           </select>
                        </div>
                     </div>
                     <div class="sku_combination pt-4" id="sku_combination">
                        @include('seller-views.product.partials._edit_sku_combinations',['combinations'=>json_decode($product['variation'],true)])
                     </div>
                     <div class="row">
                        <div class="col-md-6" id="quantity">
                           <label class="control-label">{{__('total')}} {{__('Quantity')}} </label>
                           <input type="number" min="0" value={{ $product->current_stock }} step="1"
                              placeholder="{{__('Quantity') }}" name="current_stock" class="form-control" required>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div id="additional"></div>

            <div class="card mt-2">
               <div class="card-header">
                  <h4>Product Details</h4>
               </div>
               <div class="card-body">
                  <div class="form-group">
                     <div class="col-xl-12">
                        <textarea name="details" id="mytextarea" cols="30" rows="10">{{$product['details']}}</textarea>
                     </div>
                  </div>
               </div>
            </div>

            <div class="card mt-2">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="form-group">
                           <label>{{__('Upload product images')}}</label><small style="color: red">* ( {{__('ratio')}}
                              1:1 )</small>
                        </div>
                        <div class="p-2 border border-dashed" style="max-width:430px;">
                           <div class="row" id="coba">
                              @foreach (json_decode($product->images) as $key => $photo)
                              <div class="col-6">
                                 <div class="card">
                                    <div class="card-body">
                                       <img style="width: 100%" height="auto"
                                          onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                          src="{{asset("storage/app/public/product/$photo")}}" alt="Product image">
                                       <a href="{{route('seller.product.remove-image',['id'=>$product['id'],'name'=>$photo])}}"
                                          class="btn btn-danger btn-block">Remove</a>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>

                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="name">{{__('Upload thumbnail')}}</label><small style="color: red">* (
                              {{__('ratio')}} 1:1 )</small>
                        </div>
                        <div style="max-width:200px;">
                           <div class="row" id="thumbnail">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12" style="padding-top: 20px">
                           <button type="submit" class="btn btn-primary"> {{__('Update')}}</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
      </form>
   </div>
</div>
<script>
 $(document).ready(function () {  
   setTimeout(function() {
      let category = $("#category_id").val();
      let sub_category = $("#sub-category-select").attr("data-id");
      let sub_sub_category = $("#sub-sub-category-select").attr("data-id");
      getRequest('<?= url('/seller/product/get-categories') ?>?parent_id=' + category + '&sub_category=' + sub_category, 'sub-category-select', 'select');
      getRequest('<?= url('seller/product/get-categories') ?>/?parent_id=' + sub_category + '&sub_category=' + sub_sub_category, 'sub-sub-category-select', 'select');
   }, 100);
 });
 
function getRequest(route, id, type) {
   $.ajax({
      url: route,
      type: 'get',
      dataType: 'json',
      success: function(data) {
         if (type == 'select') {
            $('#' + id).empty().append(data.select_tag);
         }
      },
   });
}
</script>
@endsection


@push('js')
<script src="{{ asset('app-assets/js/tagsinput.js') }}"></script>
<script src="{{ url('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
<script src="{{ url('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ url('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
<script src="{{ asset('assets/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>

<script>
$('.repeater').repeater({
   repeatElement: 'structure',
   createElement: 'createElement',
   removeElement: 'removeElement',
   containerElement: 'containerElement',
});
var quill = new Quill('#editor', {
   theme: 'snow'
});
var imageCount = '<?= 4 - count(json_decode($product->images)) ?>';
var thumbnail = '{{ asset($product->thumbnail) ?? asset("img2.jpg") }}';

$(function() {

   $("#thumbnail").spartanMultiImagePicker({
      fieldName: 'image',
      maxCount: 1,
      rowHeight: 'auto',
      groupClassName: 'col-6',
      maxFileSize: '',
      placeholderImage: {
          image: thumbnail,
          width: '100%',
      },
      dropFileLabel: "Drop Here",
      onAddRow: function(index, file) {

      },
      onRenderedPreview: function(index) {

      },
      onRemoveRow: function(index) {

      },
      onExtensionErr: function(index, file) {
            toastr.error('Please only input png or jpg type file', {
               CloseButton: true,
               ProgressBar: true
            });
      },
      onSizeErr: function(index, file) {
            toastr.error('File size too big', {
               CloseButton: true,
               ProgressBar: true
            });
      }
   });
   
   $("#coba").spartanMultiImagePicker({
      fieldName: 'image[]',
      maxCount: 4,
      rowHeight: 'auto',
      groupClassName: 'col-6',
      maxFileSize: '',
      placeholderImage: {
            image: "{{asset('img2.jpg')}}",
            width: '100%',
      },
      dropFileLabel: "Drop Here",
      onAddRow: function(index, file) {
      },
      onRenderedPreview: function(index) {
      },
      onRemoveRow: function(index) {
      },
      onExtensionErr: function(index, file) {
            toastr.error('Please only input png or jpg type file', {
               CloseButton: true,
               ProgressBar: true
            });
      },
      onSizeErr: function(index, file) {
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

      reader.onload = function(e) {
            $('#viewer').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
   }
}

$("#customFileUpload").change(function() {
   readURL(this);
});


$(".js-example-theme-single").select2({
   theme: "classic"
});

$(".js-example-responsive").select2({
   width: 'resolve'
});

function subCat(cat) {
   $.ajax({
      url: "{{ route('product.add') }}",
      dataType: "json",
      data: {
         cat: cat
      },
      success: function(data) {
         $('#sub_cat').empty()
         let index = 0;
         jQuery.each(data, function(key, result) {
            $('#sub_cat').append($("<option></option>").attr("value", result.id).text(result.name));
         });
      }
   });
}

$("#product_type").on('change', function() {
   let value = $("#product_type").val();
   if ('variable' == value) {
      // show variable 
      $("#variable_form").show();
   } else {
      // hide variable form
      $("#variable_form").hide();
   }
});

function getRequest(route, id, type) {
   $.ajax({
      url: route,
      type: 'get',
      dataType: 'json',
      success: function(data) {
         if (type == 'select') {
            $('#' + id).empty().append(data.select_tag);
         }
      },
   });
}

$("#sub-category-select").change(function() {
   var $p_type = $(".ecat_id").val();
   if ($p_type !== '' && $p_type !== null) {
      $.ajax({
         url: "{{ route('get_p_type') }}?type=" + $p_type,
         // dataType: 'JSON',
         type: 'get',
         success: function(data) {
            console.log(data);
            $('#additional').empty().append(data);
         },
      });
   }
});

$('input[name="colors_active"]').on('change', function() {
   if (!$('input[name="colors_active"]').is(':checked')) {
      $('#colors-selector').prop('disabled', true);
   } else {
      $('#colors-selector').prop('disabled', false);
   }
});

$('#choice_attributes').on('change', function() {
   $('#customer_choice_options').html(null);
   $.each($("#choice_attributes option:selected"), function() {
      add_more_customer_choice_option($(this).val(), $(this).text());
   });
});

function add_more_customer_choice_option(i, name) {
   let n = name.split(' ').join('');
   $('#customer_choice_options').append(
      '<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i +
      '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{__(' +
      "Choice Title " +
      ') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' +
      i + '[]" placeholder="{{__(' + "Enter choice values " +
      ') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');

   $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
}


$('#colors-selector').on('change', function() {
   update_sku();
});

$('input[name="unit_price"]').on('keyup', function() {
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
      success: function(data) {
         $('#sku_combination').html(data.view);
         if (data.length > 1) {
            $('#quantity').hide();
         } else {
            $('#quantity').show();
         }
      }
   });
}

$(document).ready(function() {
   // color select select2
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

function _type(t) {
   if (t == 1) {
      $("#download_url").removeAttr('disabled', true)
   } else {
      $("#download_url").attr('disabled', true)
   }
}  
   
</script>
@endpush
