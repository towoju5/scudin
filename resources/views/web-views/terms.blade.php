@extends('layouts.home.app')

@section('title', $title)

@section('content')
<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title">
                    <h2>{{ $title }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN Main Container -->

<div class="main-container col1-layout wow bounceInUp animated animated" style="visibility: visible;">
    <div class="main container">
        <div class="std">
            <div class="wrapper_bl" style="margin-top: 1px;">
                <div class="form_background">
                    {!! $terms_condition['value'] !!}
                </div>
            </div>
        </div>
    </div>
    <!--main-container-->
</div>
@endsection