@extends('layouts.backend')

@section('title','Sponsor Product')

@section('content')
<style>
   .custom-options-checkable .custom-option-item {
      width: 100%;
      cursor: pointer;
      border-radius: 0.42rem;
      color: #82868B;
      background-color: rgba(130, 134, 139, .06);
      border: 1px solid #EBE9F1;
   }

   .custom-option-item-check {
      position: absolute;
      clip: rect(0, 0, 0, 0);
   }

   .custom-option-item-check:checked+.custom-option-item {
      color: #7367F0;
      background-color: rgba(115, 103, 240, .12);
      border-color: #7367F0;
   }

   .custom-options-checkable .custom-option-item {
      width: 100%;
      cursor: pointer;
      border-radius: 0.42rem;
      color: #82868B;
      background-color: rgba(130, 134, 139, .06);
      border: 1px solid #EBE9F1;
   }
</style>
<div class="container-fluid">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-6">
            <h1 class="page-header-title">Sponsor Product</h1>
         </div>
         <div class="col-6">
            <a href="{{url()->previous()}}" class="btn btn-primary float-right">
               <i class="tio-back-ui"></i> Back
            </a>
         </div>
      </div>
      <!-- Nav -->
      @if(!empty($promotion) && count($promotion) < 1) <div class="row">
         <div class="col-12 mt-3">
            <h1 class="page-header-title">No Promotion Plan is available at the moment, kindly reach us via the support to get started!</h1>
         </div>
   </div>
   @else
   <div class="card mt-3">
      @if(request()->post())
      <div class="card-body">
         <p>We would be promoting <b>{{ $products['name'] }}</b>, Please select promotion type below</p>
         <form id="creditCardForm" method="post" action="{{ route('promote.checkout') }}" novalidate="novalidate">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="row custom-options-checkable g-1">
                           @foreach($promotion as $k => $v)
                           <div class="col-md-4">
                              <input class="custom-option-item-check" checked type="radio" name="plan_id" value="{{ $v->id }}" id="customOptionsCheckableRadiosWithIcon{{ $v->id }}">
                              <label class="custom-option-item text-center p-1" for="customOptionsCheckableRadiosWithIcon{{ $v->id }}">
                                 <span class="custom-option-item-title h4 d-block">{{ $v['name']}}</span>
                                 <small>{{ $v['duration']}} Days</small>
                                 <span class="custom-option-item-title h4 d-block pt-1">${{ $v['cost']}}</span>
                              </label>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12 gx-2 gy-1 validate-form">
                  <div class="card">
                     <div class="card-body">
                        <div class="row gx-4">
                           <div class="col-lg-8 middle">
                              @csrf
                              <div class="row col-md-12">
                                 <label for="credit-card">Credit Card</label>
                                 <input type="text" name="cc_num" class="form-control credit-card-mask" placeholder="0000 0000 0000 0000" id="credit-card" required />
                              </div>
                              <?php $user = auth('seller')->user();
                              $userFullname = "$user->f_name $user->l_name" ?>
                              <div class="row">
                                 <div class="col-md-6">
                                    <label class="form-label" for="addCardName">Name On Card</label>
                                    <input type="text" id="addCardName" value="{{ $userFullname }}" readonly class="form-control" placeholder="John Doe" required />
                                 </div>

                                 <div class="col-6 col-md-3">
                                    <label class="form-label" for="addCardExpiryDate">Exp. Date</label>
                                    <input type="text" name="cc_date" id="addCardExpiryDate" class="form-control add-expiry-date-mask" placeholder="MM/YY" required />
                                 </div>

                                 <div class="col-6 col-md-3">
                                    <label class="form-label" for="addCardCvv">CVV</label>
                                    <input type="text" name="cc_cvv" id="addCardCvv" class="form-control add-cvv-code-mask" maxlength="3" placeholder="cvv" required />
                                 </div>
                              </div>

                              <div class="col-12 mt-2 pt-1">
                                 <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Start Promotion</button>
                                 <button type="reset" class="btn btn-outline-secondary waves-effect">Discard</button>
                              </div>
                              <div></div>
                              <input type="hidden" name="id" value="{{ $products->id }}">

                           </div>

                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </form>
      </div>
      @else
      @if(isset($products) && !empty($products))
      <div class="table-responsive">
      <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%">
         <thead class="thead-light">
            <tr>
               <th>{{__('SL#')}}</th>
               <th>{{__('Product Name')}}</th>
               <th>{{__('purchase_price')}}</th>
               <th>{{__('selling_price')}}</th>
               {{--<th>{{__('featured')}}</th>
               <th>{{__('status')}}</th>--}}
               <th style="width: 5px">{{__('Action')}}</th>
            </tr>
         </thead>
         <tbody>
            @foreach($products as $k=>$p)
            <tr>
               <th scope="row">{{$k+1}}</th>
               <td><a href="{{route('seller.product.view',[$p['id']])}}">
                     {{$p['name']}}
                  </a></td>
               <td>
                  {{ \App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\BackEndHelper::usd_to_currency($p['purchase_price']),2)}}
               </td>
               <td>
                  {{ \App\CPU\BackEndHelper::currency_symbol().number_format(\App\CPU\BackEndHelper::usd_to_currency($p['unit_price']),2)}}
               </td>

               <td>
                  <a href="{{ route('seller.product.end-promotion', ['id' => $p->id]) }}"><button class="btn btn-sm btn-danger">Terminate</button></a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      </div>
      <hr>
      <div class="page-area pr-2">
         <table>
            <tfoot class="border-top">
               {!! $products->render('pagination') !!}
            </tfoot>
         </table>
      </div>
      @endif
      @endif
   </div>
   @endif
   <!-- End Nav -->
</div>
<!-- End Page Header -->

</div>
@endsection

@push('js')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ url('/') }}/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
<script src="{{ url('/') }}/app-assets/js/scripts/forms/form-input-mask.js"></script>
<!-- END: Page JS-->
<script>
</script>
@endpush
