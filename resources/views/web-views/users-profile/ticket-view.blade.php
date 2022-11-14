@extends('layouts.home.app')
@section('title', 'Ticket Details')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Ticket Detail</h2>
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
            <div class="row">
              <div class="col-md-3">
                <div class="text-left">
                  <div class="font-size-ms px-3">
                    <div class="font-weight-medium">{{ __('Date Submitted')}}</div>
                    <div class="opacity-60">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d')}}</div>
                  </div>
                  <hr>
                  <div class="font-size-ms px-3">
                    <div class="font-weight-medium">{{ __('Last Updated')}}</div>
                    <div class="opacity-60">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['updated_at'])->format('Y-m-d')}}</div>
                  </div>
                  <hr>
                  <div class="font-size-ms px-3">
                    <div class="font-weight-medium">{{ __('Type')}}:
                      <span class="opacity-60">{{$ticket['type']}}</span>
                    </div>
                  </div>
                  <hr>
                  <div class="font-size-ms px-3">
                    <div class="font-weight-medium" style="color:black">{{ __('Priority')}}:
                      <span class="badge badge-secondary">{{$ticket['priority']}}</span>
                    </div>
                  </div>
                  <hr>
                  <div class="font-size-ms px-3">
                    <div class="font-weight-medium" style="color: black">{{ __('Status')}}:
                      @if($ticket['status'] == 0)
                      <span class="badge badge-primary">{{ __('open') }}</span>
                      @else
                      <span class="badge badge-secondary">{{$ticket['status']}}</span>
                      @endif
                    </div>
                  </div><hr>
                </div>
              </div>

              <div class="col-md-9">

                <div class="panel panel-body for-margin-sms">
                  <img class="rounded-circle" style="text-align: right; height:40px; width:40px;" src="{{ asset(auth('customer')->user()->image) }}" alt="{{auth('customer')->user()->f_name}}" />
                  <div class="media-body pl-3">
                    <h6 class="font-size-md mb-2">{{auth('customer')->user()->f_name}}</h6>
                    <p class="font-size-md mb-1">{!! $ticket['description'] !!}</p>
                    <span class="font-size-ms text-muted">
                      <i class="czi-time align-middle mr-2"></i>
                      {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}
                    </span>
                  </div>
                </div>
                @foreach($ticket->conversations as $conversation)
                {{-- {{dd($conversation)}}--}}
                @if($conversation['customer_message'] == null )
                <div class="media pb-4 ">
                  <div class="media-body pl-3 ">
                    @php($admin=\App\Model\Admin::where('id',$conversation['admin_id'])->first())
                    <h6 class="font-size-md mb-2">{{$admin['name']}}</h6>
                    <p class="font-size-md mb-1"><?= $conversation['admin_message'] ?></p>
                    <span class="font-size-ms text-muted"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['updated_at'])->format('Y-m-d h:i A')}}</span>
                  </div>
                </div>
                @endif
                @if($conversation['admin_message'] == null)
                <div class="modal-header">
                  <img class="rounded-circle" height="40" width="40" src="{{ asset(auth('customer')->user()->image) }}" alt="{{auth('customer')->user()->f_name}}" />
                  <div class="media-body pl-3">
                    <p class="p font-size-md mb-2">
                      <span style="float: left;">{{auth('customer')->user()->f_name}}</span>
                      <span style="float: right;">
                        <i class="czi-time"></i>
                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['created_at'])->format('Y-m-d h:i A')}}
                      </span>
                    </p>
                    <br>
                    <p class="font-size-md mb-1"><?= $conversation['customer_message'] ?></p>

                  </div>
                </div>
                @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-body" style="padding: 10px;">
          <!-- Leave message-->
          <div class="col-sm-12">
            <h3 class="h5 mt-2 pt-4 pb-2">{{ __('Leave a Message')}}</h3>
            <form class="needs-validation" href="{{route('support-ticket.comment',[$ticket['id']])}}" method="post" novalidate>
              @csrf
              <div class="form-group">
                <textarea class="form-control" name="comment" rows="8" placeholder="Write your message here..." required></textarea>
                <div class="invalid-tooltip">{{ __('Please write the message')}}!</div>
              </div>
              <div class="row">
                <div style="float: left; padding-left: 10px">
                  <a href="{{route('support-ticket.close', [$ticket['id']])}}" class="btn btn-secondary" style="color: white">{{ __('close')}}</a>
                </div>
                <div style="float: right; padding-right: 10px">
                  <button class="btn btn-primary my-2" type="submit">{{ __('Submit message')}}</button>
                </div>
              </div>
            </form>
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
@stop