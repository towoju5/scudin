@extends('layouts.backend')
@section('title','Terms & Condition')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{__('general_business_settings')}}</h4>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between pl-4 pr-4">
                        <div>
                            <h2>{{__('return_policy')}}</h2>
                            <p>URL: {{ route('return') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{route('admin.business-settings.return-policy')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="editor">{{__('return_policy')}}</label>
                                <textarea class="form-control" id="editor" name="value">{{$return_policy}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input class="form-control btn-primary" type="submit" name="btn">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

