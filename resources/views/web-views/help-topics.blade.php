@extends('layouts.home.app')

@section('title','FAQ')

@push('css')
<meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="og:title" content="FAQ of {{$web_config['name']->value}} " />
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="twitter:title" content="FAQ of {{$web_config['name']->value}}" />
<meta property="twitter:url" content="{{env('APP_URL')}}">
<meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<style>
    .headerTitle {
        font-size: 25px;
        font-weight: 700;
        margin-top: 2rem;
    }

    body {
        font-family: 'Titillium Web', sans-serif
    }

    .product-qty span {
        font-size: 14px;
        color: #6A6A6A;
    }

    .btn-link {
        color: #4c5056e3;
    }

    .btnF {
        display: inline-block;
        font-weight: normal;
        margin-top: 4%;
        color: #4b566b;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        font-size: .9375rem;
        transition: color 0.25s ease-in-out, background-color 0.25s ease-in-out, border-color 0.25s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    @media (max-width: 600px) {
        .sidebar_heading {
            background: {
                    {
                    $web_config['primary_color']
                }
            }
        }

        .sidebar_heading h1 {
            text-align: center;
            color: aliceblue;
            padding-bottom: 17px;
            font-size: 19px;
        }

        .headerTitle {

            font-weight: 700;
            margin-top: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title">
                    <h2>{{ __('frequently_asked_question')}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Content-->
<div class="main-container col1-layout wow bounceInUp animated animated" style="visibility: visible;">
    <div class="main container">
        <div class="std">
            <div class="wrapper_bl" style="margin-top: 1px;">
                <div class="form_background">
                    <div class="row pt-4">
                            <ul class="list-unstyled">
                                @php $length=count($helps); @endphp
                                @php if($length%2!=0){$first=($length+1)/2;}else{$first=$length/2;}@endphp
                                @for($i=0;$i<$first;$i++) <li id="accordion">
                                    <h5 class="mb-0" style="color: black;">
                                        <i class="czi-book text-muted "></i>
                                        <button class="btnF btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo{{ $helps[$i]['id'] }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <li class="d-flex align-items-center border-bottom pb-3 mb-3">{{ $helps[$i]['question'] }}</li>
                                        </button>
                                    </h5>
                                    <div id="collapseTwo{{ $helps[$i]['id'] }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            {{ $helps[$i]['answer'] }}
                                        </div>
                                    </div>
                                    </li>
                                    @endfor
                            </ul>
                        <div class="col-sm-6">

                            <ul class="list-unstyled">
                                @for($i=$first;$i<$length;$i++) <div id="accordion">
                                    <h5 class="mb-0" style="color: black;">
                                        <i class="czi-book text-muted mr-2"></i>
                                        <button class="btnF btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo{{ $helps[$i]['id'] }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <li class="d-flex align-items-center border-bottom pb-3 mb-3">{{ $helps[$i]['question'] }}</li>
                                        </button>
                                    </h5>
                                    <div id="collapseTwo{{ $helps[$i]['id'] }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <?= $helps[$i]['answer'] ?>
                                        </div>
                                    </div>
                                    @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        Swal.fire({
            title: 'Are you sure delete this banner?',
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
                    url: "{{route('admin.banner.delete')}}",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        toastr.success('Banner deleted successfully');
                        location.reload();
                    }
                });
            }
        })
    });
</script>
@endsection