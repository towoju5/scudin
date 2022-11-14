@extends('layouts.backend')
@section('title','Blog Post')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2">
        <h1 class="h3 mb-0 text-black-50"></h1>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary float-right">
            <i class="tio-add-circle"></i> {{__('Add')}} {{__('Post')}}
        </a>
    </div>


    <!-- Accordion with margin start -->
    <section id="accordion-with-margin">
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{__('Blog ')}} {{__('List')}} </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <p class="card-text">
                            To create a collapse with margin use <code>.collapse-margin</code> class as a wrapper for your collapse
                            header.
                        </p> -->
                        <div class="collapse-margin" id="accordionExample">
                            @foreach($posts as $k => $post)
                            <div class="card">
                                <!-- <a class="dropdown-item delete" style="cursor: pointer;" id="{{$post['id']}}"> {{ __('Delete')}}</a> -->
                                <div class="d-sm-flex align-items-center justify-content-between card-header" id="headingOne{{$k}}" data-toggle="collapse" role="button" data-target="#collapseOne{{$k}}" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="lead collapse-title"> {{ $post->title }} </span>
                                    <div>
                                    <a href="{{ route('admin.blog.delete', $post->id) }}" class="btn btn-primary float-left mr-1">
                                        <i class="tio-trash-bin"></i> {{__('Delete')}} {{__('Post')}}
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-primary float-right">
                                        <i class="tio-trash-bin"></i> {{__('Edit')}} {{__('Post')}}
                                    </a>
                                    </div>
                                </div>

                                <div id="collapseOne{{$k}}" class="collapse" aria-labelledby="headingOne{{$k}}" data-parent="#accordionExample">
                                    @if(!empty($post->blog_image ))
                                    <div class="text-center">
                                        <img src="{{ $post->blog_image }}" alt="{{ $post->title }}" width="250px" height="250px">
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        {!! $post->body !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
