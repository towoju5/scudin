@extends('layouts.backend')
@section('title','Shop Edit')
@push('css_or_js')
<!-- Custom styles for this page -->
<link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this page -->
<link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
   @media(max-width:375px) {
      #shop-image-modal .modal-content {
         width: 367px !important;
         margin-left: 0 !important;
      }
   }
   @media(max-width:500px) {
      #shop-image-modal .modal-content {
         width: 400px !important;
         margin-left: 0 !important;
      }
   }
</style>
@endpush
@section('content')
<!-- Content Row -->
<div class="container-fluid">
@php 
$seller = auth('seller')->user();
$shop = App\Model\Shop::where('seller_id', $seller->id)->first();
@endphp
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h1 class="h3 mb-0 ">Edit Shop Info</h1>
            </div>
            <div class="card-body">
               <form action="{{route('seller.shop.update',[$shop->id])}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="name">Shop Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" value="{{$shop->name}}" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                           <label for="name">Contact <span class="text-danger">*</span></label>
                           <input type="text" name="contact" minlength="10" maxlength="15" value="{{ $shop->contact }}" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                           <label for="address">Address <span class="text-danger">*</span></label>
                           <input type="text" rows="4" name="address" class="form-control" id="address" required value="{{ $shop->address }}">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="customFileUpload">{{__('Upload')}} {{__('Shop Banner')}}</label>
                           <div class="custom-file">
                              <input type="file" name="image" id="customFileUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                              <label class="custom-file-label" for="customFileUpload">{{__('Upload')}} {{__('image')}}</label>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="LogoUpload">{{__('Upload')}} {{__('logo')}}</label>
                              <div class="custom-file">
                                 <input type="file" name="logo" id="LogoUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                 <label class="custom-file-label" for="LogoUpload">{{__('Upload')}} {{__('logo')}}</label>
                              </div>
                        </div>
                        <div class="form-group">
                           <label for="tax_id">Tax/EIN <span class="text-danger">*</span></label>
                           <input type="text" name="tax_id" class="form-control" id="tax_id" required value="{{ $shop->tax_id }}">
                         </div>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="pb-1">
                              <center>
                                 <img style="width: 100%;border: 1px solid; border-radius: 10px; max-height:150px;" id="viewerLogo" onerror="this.src='<?= asset('assets/front-end/img/image-place-holder.png') ?>'" src="{{ asset($shop->image) }}" alt="banner image" />
                              </center>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="pb-1">
                              <center>
                                 <img style="width: 100%;border: 1px solid; border-radius: 10px; max-height:150px;" id="viewer" onerror="this.src='<?= asset('assets/front-end/img/image-place-holder.png') ?>'" src="{{ asset($seller->image) }}" alt="banner image" />
                              </center>
                           </div>
                        </div>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary" id="btn_update">Update</button>
                  <a class="btn btn-danger" href="{{route('seller.shop.view')}}">Cancel</a>
               </form>
            </div>
         </div>
      </div>
   </div>

   <!--modal-->
   @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'shop-image-modal'])
   <!--modal-->
</div>
@endsection

@push('js')
<!-- Page level plugins -->
<script src="{{asset('assets/back-end/js/croppie.js')}}"></script>
<script>
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

   function readlogoURL(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function(e) {
            $('#viewerLogo').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
      }
   }

   $("#LogoUpload").change(function() {
      readlogoURL(this);
   });
</script>

@endpush
