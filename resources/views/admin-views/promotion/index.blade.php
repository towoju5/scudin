@extends('layouts.backend')
@section('title','Promotion Plans')

@push('css')
   <link href="{{asset('assets/back-end')}}/css/select2.min.css" rel="stylesheet" />
   <!-- Custom styles for this page -->
   <link href="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

   <style>
      .switch {
         position: relative;
         display: inline-block;
         width: 48px;
         height: 23px;
      }

      .switch input {
         opacity: 0;
         width: 0;
         height: 0;
      }

      .slider {
         position: absolute;
         cursor: pointer;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #ccc;
         -webkit-transition: .4s;
         transition: .4s;
      }

      .slider:before {
         position: absolute;
         content: "";
         height: 15px;
         width: 15px;
         left: 4px;
         bottom: 4px;
         background-color: white;
         -webkit-transition: .4s;
         transition: .4s;
      }

      input:checked+.slider {
         background-color: #377dff;
      }

      input:focus+.slider {
         background-color: #377dff;
      }

      input:checked+.slider:before {
         -webkit-transform: translateX(26px);
         -ms-transform: translateX(26px);
         transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
         border-radius: 34px;
      }

      .slider.round:before {
         border-radius: 50%;
      }
   </style>
@endpush

@section('content')
<div class="container-fluid">
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-2">
      <h1 class="h3 mb-0 text-black-50">{{__('Promotion Plans')}}</h1>
      <a href="{{ route('admin.promotion.create') }}">
         <button class="btn btn-primary btn-sm">Add New Plan</button>
      </a>
   </div>


   <div class="row" style="margin-top: 20px">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body" style="padding: 0">
               <div class="table-responsive">
                  <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
                     <thead class="thead-light">
                        <tr>
                           <th>{{__('SL#')}}</th>
                           <th>{{__('Title')}}</th>
                           <th>{{__('Cost')}}</th>
                           <th>{{__('Plan Duration')}}</th>
                           <th>{{__('Action')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($promotions as $k => $plan)
                        <tr>
                           <th scope="row">{{ $k+1 }}</th>
                           <td>{{ $plan->name }}</td>
                           <td>{{ format_price($plan->cost) }}</td>
                           <td>{{ $plan->duration }} Days</td>
                           <td>
                              <a href="{{ route('admin.promotion.edit', $plan->id) }}" class="btn btn-primary btn-sm">
                                 {{__('Update')}}
                              </a>
                              <a href="{{ route('admin.promotion.delete', $plan->id) }}" class="btn btn-danger btn-sm">
                                 {{__('Delete')}}
                              </a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="card-footer">
               {{ $promotions->render('pagination') }}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('js')
<script>
   $(document).ready(function() {
      $('#dataTable').DataTable();
   });
</script>
<script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>
<script>
   $(".js-example-theme-single").select2({
      theme: "classic"
   });

   $(".js-example-responsive").select2({
      width: 'resolve'
   });
</script>

<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('assets/back-end')}}/js/demo/datatables-demo.js"></script>
@endpush