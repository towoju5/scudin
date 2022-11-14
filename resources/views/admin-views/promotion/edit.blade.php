@extends('layouts.backend')
@section('title','Update Promotion Plan')
@push('css')
@endpush

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-2">
   <h1 class="h3 mb-0 text-black-50">{{__('Promotion')}}</h1>
</div>

<!-- Content Row -->
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            {{__('Create')}}
         </div>
         <div class="card-body">
            <form action="{{route('admin.promotion.update.save', $promotion->id)}}" method="post">
               @csrf

               <div class="form-group">
                  <div class="row">
                     <div class="col-md-12">
                        <label for="name">{{__('Plan Name')}}</label>
                        <input type="text" name="name" class="form-control" value="{{ $promotion->name ?? NULL }}" id="plan_name" placeholder="Plan Name" required>
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <div class="row">
                     <div class="col-md-12">
                        <label for="name">{{__('Duration')}}</label>
                        <select class="js-example-responsive form-control" value="{{ $promotion->duration ?? NULL }}" name="duration" id="plan_duration" style="width: 100%">
                           <?php $i = 1;
                           while ($i <= 31) : ?>
                              <option value="{{ $i }}">{{ $i }} Days</option>
                           <?php $i++;
                           endwhile; ?>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <div class="row">
                     <div class="col-md-6">
                        <label for="name">{{__('Plan Cost')}}</label>
                        <input type="number" min="1" step="any" max="1000000" value="{{ $promotion->cost ?? NULL }}" name="cost" class="form-control" id="plan_cost" placeholder="Plan Cost" required>
                     </div>
                  </div>
               </div>

               <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

</div>
@endsection

@push('js')
@endpush