@extends('layouts.backend')
@section('title','Brand Add')

@push('css_or_js')
    <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('brand')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-50">{{ __('brand')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('brand_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.brand.add-new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('name')}}</label>
                                    <input type="text" name="name" required class="form-control" id="name" value="{{old('name')}}" placeholder="Ex : LUX">
                                </div> 
                                <div class="form-group">
                                    <label for="name">{{ __('brand_logo')}}</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                        <label class="custom-file-label" for="customFileUpload">{{__('choose')}} {{__('file')}}</label>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <center>
                                    <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                        src="{{asset('assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                </center>
                            </div>
                        </div>
                        

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('brand_table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('sl')}}</th>
                                <th scope="col">{{ __('name')}}</th>
                                <th scope="col">{{ __('image')}}</th>
                                <th scope="col" style="width: 50px">{{ __('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($br as $k=>$b)
                                <tr>
                                    <th scope="row">{{$k+1}}</th>
                                    <td>{{$b['name']}}</td>
                                    <td>
                                        <img width="80"
                                             onerror="this.src='<?= asset('assets/front-end/img/image-place-holder.png') ?>'"
                                             src="{{ asset($b['image']) }}">
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                href="{{route('admin.brand.update',[$b['id']])}}">{{ __('Edit')}} </a>
                                                <a class="dropdown-item delete"
                                                id="{{$b['id']}}"> {{ __('Delete')}}</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$br->render('pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    @include('shared-partials.image-process._script',[
     'id'=>'brand-image-modal',
     'height'=>400,
     'width'=>800,
     'multi_image'=>false,
     'route'=>route('image-upload')
     ])

    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
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


        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure to delete is brand?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.brand.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('Brand deleted successfully');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
