@extends('layouts.backend')

@section('title', 'Add New Products')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/plugins/forms/form-quill-editor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 20px;
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
    height: 12px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
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
</style>
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <!-- <div class="container-fluid"> -->
  <!-- Content Row -->
  <div class="row">
    @if (checkSellerLimit() === false)
    <div class="col-12">
      <div class="card card-congratulations">
        <div class="card-body text-center">
          <div class="avatar avatar-xl bg-primary shadow">
            <div class="avatar-content">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award font-large-1">
                <circle cx="12" cy="8" r="7"></circle>
                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
              </svg>
            </div>
          </div>
          <div class="text-center">
            <h1 class="mb-1 text-white">Oops. Sorry</h1>
            <p class="card-text m-auto w-75">
              <strong>Product Limit reached,</strong> Please upgrade your plan to add more products.
            </p>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="col-md-12">
      <form class="product-form" action="{{ route('seller.product.add-new') }}" method="POST" enctype="multipart/form-data" id="product_form">
        @csrf
        <div class="card">
          <div class="card-header">
            <h4>{{__('General Info')}}</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">{{__('Product Name')}}</label>
              <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" placeholder="Ex : LUX" required>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="name">{{__('Category')}}</label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control ecat_id" name="category_id" onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-category-select','select')" required>
                    <option value="{{old('category_id')}}" selected disabled>---Select---</option>
                    @foreach($cat as $c)
                    <option value="{{$c->id}}" {{ old('name') == $c->id ? 'selected': ''}}>{{ $c->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="name">{{__('Sub Category')}}</label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control" name="sub_category_id" id="sub-category-select" onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="name">{{__('Sub Sub Category')}}</label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control" name="sub_sub_category_id" id="sub-sub-category-select">

                  </select>
                </div>
              </div>

            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="name">{{__('Brand')}}</label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control" name="brand_id" required>
                    <option value="{{null}}" selected disabled>---Select---</option>
                    @foreach($br as $b)
                    <option value="{{$b['id']}}">{{$b['name']}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">

                  <label for="name">{{__('Unit')}}</label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control" name="unit">
                    @foreach(units() as $x)
                    <option value="{{$x->units}}" {{old('unit')==$x->units ? 'selected':''}}>{{$x->units}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">

                  <label for="weight">{{__('weight')}}</label>
                  <input type="number" name="weight" class="form-control" id="weight" value="{{old('weight')}}" placeholder="Ex : 2" required>
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
                    <input type="checkbox" class="status " value="{{old('colors_active')}}" name="colors_active">
                    <span class="slider round"></span>
                  </label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control color-var-select" name="colors[]" multiple="multiple" id="colors-selector" disabled>
                    @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                    <option value="{{ $color->code }}">
                      {{$color['name']}}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="attributes" style="padding-bottom: 3px">
                    {{__('Attributes')}} :
                  </label>
                  <select class="select2 js-example-basic-multiple js-states js-example-responsive form-control" name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                    @foreach (\App\Model\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                    <option value="{{ $a['id']}}">
                      {{$a['name']}}
                    </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-12 mt-2 mb-2">
                  <div class="customer_choice_options" id="customer_choice_options"></div>
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
                  <select class="form-control" onchange="_type(this.value)" id="product_type" name="product_type">
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
                  <input type="number" min="0" step="0.01" placeholder="{{__('Unit price')}}" name="unit_price" value="{{old('unit_price')}}" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="control-label">{{__('Purchase price')}}</label>
                  <input type="number" min="0" step="0.01" placeholder="{{__('Purchase price')}}" value="{{old('purchase_price')}}" name="purchase_price" class="form-control" required>
                </div>
              </div>
              <div class="row pt-4">
                <div class="col-md-4">
                  <label class="control-label">{{__('weight')}}</label>
                  <input type="number" min="0" value="{{old('weight')}}" step="0.01" placeholder="{{__('weight')}}" name="weight" class="form-control">
                </div>

                <div class="col-md-4">
                  <label class="control-label">{{__('length')}}</label>
                  <input type="number" min="0" value="{{old('length')}}" step="0.01" placeholder="{{__('length')}}" name="length" class="form-control">
                </div>
                <div class="col-md-4 parcent-margin">
                  <label for="">{{__('width')}}</label>
                  <input type="number" min="0" value="{{old('width')}}" step="0.01" placeholder="{{__('width')}}" name="width" class="form-control">
                </div>
              </div>
              <div class="row pt-4">
                <div class="col-md-4">
                  <label class="control-label">{{__('Tax')}}</label>
                  <label class="badge badge-info">{{__('Percent')}} ( % )</label>
                  <input type="number" readonly min="0" step="0.01" placeholder="{{__('8.25%')}}" value="8.25%" readonly class="form-control">
                  <input name="tax_type" value="percent" style="display: none">
                </div>

                <div class="col-md-4">
                  <label class="control-label">{{__('Discount')}}</label>
                  <input type="number" min="0" value="{{old('discount')}}" step="0.01" placeholder="{{__('Discount')}}" name="discount" class="form-control">
                </div>
                <div class="col-md-4 parcent-margin">
                  <label for="">Discount Type</label>
                  <select class="select2 js-example-basic-multiple js-states form-control js-example-responsive demo-select2" name="discount_type">
                    <option value="flat">{{__('Flat')}}</option>
                    <option value="percent">{{__('Percent')}}</option>
                  </select>
                </div>
                <div class="pt-4 col-12 sku_combination" id="sku_combination">

                </div>
                <div class="col-md-6" id="quantity">
                  <label class="control-label">{{__('total')}} {{__('Quantity')}}</label>
                  <input type="number" min="0" value="0" step="1" placeholder="{{__('Quantity')}}" name="current_stock" class="form-control" required>
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
                <textarea name="details" id="mytextarea" cols="30" rows="10">{{old('details')}}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-2">
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label>{{__('Upload product images')}}</label><small style="color: red">* ( {{__('ratio')}} 1:1 or 1000x1000 )</small>
                </div>
                <div class="p-2 border border-dashed" style="max-width:430px;">
                  <div class="row" id="coba"></div>
                </div>

              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">{{__('Upload thumbnail')}}</label><small style="color: red">* ( {{__('ratio')}} 1:1 )</small>
                </div>
                <div style="max-width:200px;">
                  <div class="row" id="thumbnail"></div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12" style="padding-top: 20px">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>
    @endif
  </div>
  <!-- </div> -->
</section>
@endsection

@push('js')
<script src="{{ url('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
<script src="{{ url('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ url('app-assets/js/scripts/forms/form-repeater.js') }}"></script>

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

  $(function() {
    $("#coba").spartanMultiImagePicker({
      fieldName: 'images[]',
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

    $("#thumbnail").spartanMultiImagePicker({
      fieldName: 'image',
      maxCount: 1,
      rowHeight: 'auto',
      groupClassName: 'col-12',
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
    $('#customer_choice_options').append('<div class="row"><div class="col-md-3 pb-1"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{__(' + "Choice Title " + ') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{__(' + "Enter choice values " + ') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');

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

  $('#product_form').submit(function(e) {
    e.preventDefault();
    $('#loading').show();
    var formData = new FormData(this);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.post({
      url: "{{ route('seller.product.store') }}",
      data: formData,
      contentType: false,
      processData: false,
      success: function(data) {
        if (data.errors) {
          for (var i = 0; i < data.errors.length; i++) {
            toastr.error(data.errors[i].message, {
              CloseButton: true,
              ProgressBar: true
            });
          }
        } else {
          console.log(data);
          toastr.success('product added successfully!', {
            CloseButton: true,
            ProgressBar: true
          });
          setInterval(function() {
            location.href = "{{route('seller.product.list')}}";
          }, 2000);
        }
      }
    });
  });

  function _type(t)
  {
    if(t == 1){
      $("#download_url").removeAttr('disabled', true)
    } else {
      $("#download_url").attr('disabled', true)
    }
  }
</script>
@endpush