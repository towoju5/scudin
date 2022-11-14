@extends('layouts.backend')
@section('title','Employee Add')

@section('content')
<div class="container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('employee_add')}}</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('Employee')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('employee_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.employee.add-new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{__('Name')}}</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Ex : Md. Al Imrun" value="{{old('name')}}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{__('Phone')}}</label>
                                    <input type="text" name="phone" value="{{old('phone')}}" class="form-control" id="phone"
                                           placeholder="Ex : +88017********">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{__('Email')}}</label>
                                    <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                                           placeholder="Ex : ex@gmail.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{__('Role')}}</label>
                                    <select class="form-control" name="role_id"
                                            style="width: 100%">
                                        <option value="0" selected disabled>---select---</option>
                                        @foreach($rls as $r)
                                            <option value="{{$r->id}}">{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{__('password')}}</label>
                                    <input type="text" name="password" class="form-control" id="password"
                                           placeholder="Password">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{__('employee_image')}}</label><br>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileUpload">{{__('choose')}} {{__('file')}}</label>
                                        </div>
                                    </div> 
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                            src="{{asset('assets\back-end\img\400x400\img2.jpg')}}" alt="Product thumbnail"/>
                                    </center>   
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'employee-image-modal'])
    <!--modal-->
</div>
@endsection

@push('js')
    <script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>
    <script>
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

    @include('shared-partials.image-process._script',[
   'id'=>'employee-image-modal',
   'height'=>200,
   'width'=>200,
   'multi_image'=>false,
   'route'=>route('image-upload')
   ])
@endpush
