@extends('layouts.backend')
@section('title', $title)
@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-2">
      <h4 class="mb-0 text-black-50">{{__($title)}}</h4>
   </div>

   <div class="row" style="padding-bottom: 20px">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body" style="padding: 20px">

               <form action="{{route($route)}}" method="post">
                  @csrf
                  <div class="form-group mb-2">
                     <label style="padding-left: 10px">{{ __('Select') }} {{ __('User') }} </label><br>
                     <input type="hidden" name="single_receiver" value="true">
                     <select name="receiver" id="receiver" class="form-control">
                        @foreach($users as $r)
                        <option value="{{ $r->email }}"> {{ $r->f_name.' '.$r->l_name }} => ({{ $r->email }})</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="form-group mb-2">
                     <label style="padding-left: 10px">{{__('Subject')}}</label><br>
                     <input type="text" class="form-control" autocomplete="off" name="subject"
                        placeholder="Email Subject">
                  </div>
                  <div class="form-group mb-2">
                     <label style="padding-left: 10px">{{__('Message Body')}}</label><br>
                     <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary mb-2 btn-block">
                     <i class="fa fa-paper-plane"></i> {{__('Send Now')}}
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('js')

@endpush