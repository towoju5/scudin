@extends('layouts.home.app')
@section('title', __('Support Tickets'))

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>{{ __('Support Tickets') }}</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<section class="main-container col2-right-layout">
  <div class="main container">
    <div class="row">
      <section class="col-main col-sm-9 col-xs-12 wow bounceInUp animated animated" style="visibility: visible;">
        <div class="my-account">

          <!--page-title-->
          <!-- BEGIN DASHBOARD-->
          <div class="dashboard">
            @php($allTickets =App\Model\SupportTicket::where('customer_id', auth('customer')->id())->get())
            <div class="card box-shadow-sm">
              <div style="overflow: auto">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr style="background: <?= $web_config['secondary_color'] ?>">
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO ">{{ __('Topic')}}</span></div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2 ml-2"><span class="d-block spandHeadO ">{{ __('submition_date')}}</span>
                        </div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO">{{ __('Type')}}</span>
                        </div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2">
                          <span class="d-block spandHeadO">
                            {{ __('Status')}}
                          </span>
                        </div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2">
                          <span class="d-block spandHeadO"><i class="lni lni-eye"></i> View</span>
                        </div>
                      </td>
                      <td class="tdBorder">
                        <div class="py-2"><span class="d-block spandHeadO">{{ __('Action')}} </span></div>
                      </td>
                    </tr>
                  </thead>

                  <tbody>

                    @foreach($allTickets as $ticket)
                    <tr>

                      <td class="bodytr font-weight-bold" style="color: <?= $web_config['primary_color'] ?>">
                        <span class="marl">{{$ticket['subject']}}</span>
                      </td>
                      <td class="bodytr">
                        <span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}</span>
                      </td>
                      <td class="bodytr"><span class="">{{ $ticket['type'] }}</span></td>
                      <td class="bodytr"><span class="">
                          @if($ticket['status'] == 0)
                          {{ __('open') }}
                          @else
                          {{ __('close') }}
                          @endif
                        </span>
                      </td>
                      <td class="bodytr">
                        <span class="">
                          <a class="btn btn-primary btn-sm" href="{{route('support-ticket.index',$ticket['id'])}}">View
                          </a>
                        </span>
                      </td>

                      <td class="bodytr">
                        <?php $_link = route('support-ticket.delete',['id'=>$ticket->id]) ?>
                        <a href="javascript:" onclick="Swal.fire({
                                               title: 'Do you want to delete this?',
                                               showDenyButton: true,
                                               showCancelButton: true,
                                               confirmButtonColor: '<?= $web_config['primary_color'] ?>',
                                               cancelButtonColor: '<?= $web_config['secondary_color'] ?>',
                                               confirmButtonText: `Yes`,
                                               denyButtonText: `Don't Delete`,
                                               }).then((result) => {
                                               if (result.value) {
                                               Swal.fire('Deleted!', '', 'success')
                                               location.href='{{ $_link }}';
                                               } else{
                                               Swal.fire('Cancelled', '', 'info')
                                               }
                                               })" id="delete" class=" marl">
                          <i class="lni lni-trash-can" style="font-size: 25px; color:#e81616;"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <hr class="mb-4">
            <div class="mt-3">
              <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#open-ticket">
                {{ __('add_new_ticket')}}
              </button>
            </div>
          </div>
        </div>
      </section>
      <!--col-main col-sm-9 wow bounceInUp animated-->
      <aside class="col-right sidebar col-sm-3 col-xs-12 wow bounceInUp animated animated" style="visibility: visible;">
        @include('web-views.users-profile.partials._sidebar')
      </aside>
      <!--col-right sidebar col-sm-3 wow bounceInUp animated-->
    </div>
    <!--row-->
  </div>
  <!--main container-->
</section>

<div class="modal fade" id="open-ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-12">
            <h5 class="modal-title font-nameA h3">{{ __('submit_new_ticket')}}</h5>
          </div>
          <div class="col-md-12 h5" style="color: #030303;  margin-top: 1rem;">
            <span>{{ __('you_will_get_response')}}.</span>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('ticket-submit')}}" id="open-ticket">
          @csrf
          <div class="form-group">
            <div class="col-md-12">
              <label for="ticket-subject">{{ __('Subject')}}</label>
              <input type="text" class="form-control" id="ticket-subject" name="ticket_subject" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group ">
                <label class="" for="ticket-type">{{ __('Type')}}</label>
                <select class="custom-select form-control" id="ticket-type" name="ticket_type" required>
                  <option value="Website problem">{{ __('Website')}} {{ __('problem')}}</option>
                  <option value="Partner request">{{ __('partner_request')}}</option>
                  <option value="Complaint">{{ __('Complaint')}}</option>
                  <option value="Info inquiry">{{ __('Info')}} {{ __('inquiry')}} </option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="ticket-priority">{{ __('Priority')}}</label>
                <select class="form-control custom-select" id="ticket-priority" name="ticket_priority" required>
                  <option value>{{ __('choose_priority')}}?</option>
                  <option value="Urgent">{{ __('Urgent')}}</option>
                  <option value="High">{{ __('High')}}</option>
                  <option value="Medium">{{ __('Medium')}}</option>
                  <option value="Low">{{ __('Low')}}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="ticket-description">{{ __('describe_your_issue')}}</label>
              <textarea class="form-control" rows="6" id="ticket-description" name="ticket_description" placeholder="Write Here"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="padding: 0px!important; border-top:none">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close')}}</button>
            <button type="submit" class="btn btn-primary">{{ __('submit_a_ticket')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop