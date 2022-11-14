@extends('layouts.backend')

@section('title', 'Add New Products')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/plugins/forms/form-quill-editor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/tagsinput.css') }}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="row match-height">
    <div class="col-12">
      <div class="card card-transaction">
        <div class="card-header">
          <h4 class="card-title">Add New Product</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('product.store') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="name">Product Name</label>
              <input type="text" name="name" class="form-control" id="name" autofocus>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">Product Type</label>
                  <select name="product_type" class="form-control" id="product_type">
                    <option value="simple">Simple Product</option>
                    <option value="variable">Variable Product</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">Product Category</label>
                  <select name="product_type" onchange="subCat(this.value)" class="form-control" id="product_type">
                    <option selected disabled>Select Product Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sub_cat">Product Sub Category</label>
                  <select name="sub_cat" class="form-control" id="sub_cat">
                    <option selected disabled>Select Product Sub Category</option>
                  </select>
                </div>
              </div>
            </div>

            <div style="display: none;" class="row pb-3 border" id="variable_form">
              <div class="col-md-12">
                <!-- Attributes repeater -->
                <label class="card-title">Attributes</label>
                <div class="repeater">
                  <div data-repeater-list="data">
                    <div data-repeater-item>
                      <div class="row d-flex align-items-end">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="itemname">Attribute Name</label>
                            <input type="text" class="form-control" id="attr_name" name="attr_name" placeholder="Ex: color">
                          </div>
                        </div>

                        <div class="col-md-7 col-12">
                          <div class="form-group">
                            <label for="itemcost">Attribute Values <small>seperate by comma</small></label>
                            <input type="text" name="attr_values[]" id="attr_values[]" data-role="tagsinput" class="form-control" rows="3" placeholder="Ex: Blue, Green, Red, Yellow">
                          </div>
                        </div>

                        <div class="col-md-2 col-12 mb-50 pt-2">
                          <div class="form-group">
                            <button class="btn btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mr-25">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                              </svg>
                              <span>Delete</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <hr>
                    </div>
                  </div>
                  <br>
                  <button type="button" class="btn btn-primary" data-repeater-create>Add New</button>
                </div>
                <!-- /Attributes repeater -->
              </div>
            </div>

            <div class="form-group">
              <label>Short Description <small>(Max of 500words)</small></label>
              <div class="form-label-group mb-0">
                <textarea data-length="500" name="short_desc" class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="Product Short Description"></textarea>
                <label for="textarea-counter">Counter</label>
              </div>
              <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 500 </small>
            </div>
            <div class="form-group">
              <label for="name">Full Description</label>
              <textarea name="description" id="editor" cols="30" rows="3" class="form-control char-textarea active"></textarea>
            </div>

            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-primary btn-rounded" type="submit">Continue</button>
              <button class="btn btn-outline-danger btn-rounded" type="reset">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="{{ asset('app-assets/js/tagsinput.js') }}"></script>
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
</script>
@endsection