@extends('layouts.backend')
@section('title','Edit Blog Post')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2">
        <h1 class="h3 mb-0 text-black-50"></h1>
        <a href="{{url()->previous()}}" class="btn btn-primary float-right">
            <i class="tio-back-ui"></i> Back
        </a>
    </div>


    <!-- Accordion with margin start -->
    <section id="accordion-with-margin">
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{__('Edit Blog Post')}} </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.blog.update', $blog->id) }}" method="post" id="addPost" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Blog Title</label>
                                    <input type="text" class="form-control" required name="title" value="{{ $blog->title }}" placeholder="Welcome to scudin">
                                </div>

                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*" id="imgInp">
                                    <img id="blah" src="{{ $blog->blog_image }}" style="width: 150px; height:150; margin-top:10px">
                                </div>

                                <div class="form-group">
                                    <label>Blog Content</label>
                                    <textarea class="form-control" name="body" placeholder="Lorem Ipsum dollar sit amet">{{ $blog->body }}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script>
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
@endsection