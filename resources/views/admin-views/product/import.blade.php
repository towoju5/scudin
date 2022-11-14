@extends('layouts.backend')

@section('title','Product Import')

@section('content')
<div class="container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row">
      <div class="col-6">
        <h1 class="page-header-title">Import Product</h1>
      </div>
      <div class="col-6">
        <a href="{{url()->previous()}}" class="btn btn-primary float-right">
          <i class="tio-back-ui"></i> Back
        </a>
      </div>
    </div>
    <!-- Nav -->
    <div class="card mt-3">
      <div class="card-body">
        <p>Please note: Based on the website structure we do not accept external page link.</p>
        <p>For this reason please provide the image name with the file name as show in the sample csv (thumbnail.jpg)</p>
        <p>Kindly upload all product images after a successful product import.</p>
        <a href="{{ url('sample-product.csv') }}"><button class="btn btn-primary btn-sm mb-3">Download Sample File</button></a>
        <div class="row">
          <div class="col-md-6">
            <div class="card bg-info">
              <div class="card-body">
                <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="file" accept=".csv" class="form-control">
                  <br>
                  <button class="btn btn-success">Import User Data</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card bg-primary">
              <div class="card-body">
                <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="productImages[]" multiple accept="image/*" class="form-control">
                  <br>
                  <button class="btn btn-danger float-right">Import Product Images</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(isset($result) && !empty($result))
      <table class="table table-striped">
        <thead>
          <tr>
            <!-- <th scope="col">#</th> -->
            @foreach($result[0] as $k => $v)
            <th scope="col">{{ $k }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($result as $k => $v)
          <tr>
            <!-- <th scope="row">1</th> -->
            @foreach($v as $k => $v)
            <td>{{ $v }}</td>
            @endforeach
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
    <!-- End Nav -->
  </div>
  <!-- End Page Header -->

</div>
@endsection