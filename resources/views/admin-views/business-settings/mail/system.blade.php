@extends('layouts.backend')
@section('title','General System Mail')
@push('css_or_js')

@endpush

@section('content')
<div class="container-fluid">
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-2">
      <h4 class="mb-0 text-black-50">{{__('General System Mail')}}</h4>
   </div>

   <div class="row" style="padding-bottom: 20px">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body" style="padding: 20px">
               <form action="{{route('admin.send.mail')}}" method="post">
                  @csrf
                  <div class="form-group mb-2">
                     <label style="padding-left: 10px">{{ __('User') }} {{ __('Type') }}</label><br>
                     <input type="hidden" name="single_receiver" value="true">
                     <select name="receiver" id="receiver" class="form-control">
                        <option value="sellers">All Sellers</option>
                        <option value="users">All Users</option>
                     </select>
                  </div>

                  <div class="form-group mb-2">
                     <label style="padding-left: 10px">{{__('Subject')}}</label><br>
                     <input type="text" class="form-control" autocomplete="off" name="subject" placeholder="Email Subject">
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