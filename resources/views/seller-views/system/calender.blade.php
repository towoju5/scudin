@extends('layouts.backend')

@section('title', 'Deliveries')

@section('css')
<!-- BEGIN: Page CSS-->
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/calendars/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/pages/app-calendar.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
<!-- END: Vendor CSS-->
<!-- END: Page CSS-->
<style>
  .fc-h-event{
      color:#007bff !important;
      border-color:#007bff !important;
      background-color: transparent !important;
  }
</style>
@endsection

@section('content')
<!-- Full calendar start -->
<section>
  <div class="app-calendar overflow-hidden border">
    <div class="row no-gutters">
      <!-- Sidebar -->
      <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
        <div class="sidebar-wrapper">
          <div class="card-body d-flex justify-content-center">
            <button class="btn btn-primary btn-toggle-sidebar btn-block" data-toggle="modal" data-target="#add-new-sidebar">
              <span class="align-middle">Add Event</span>
            </button>
          </div>
          <div class="card-body pb-0">
            <h5 class="section-label mb-1">
              <span class="align-middle">Filter</span>
            </h5>
            <div class="custom-control custom-checkbox mb-1">
              <input type="checkbox" class="custom-control-input select-all" id="select-all" checked />
              <label class="custom-control-label" for="select-all">View All</label>
            </div>
            <div class="calendar-events-filter">
              <div class="custom-control custom-control-danger custom-checkbox mb-1">
                <input type="checkbox" class="custom-control-input input-filter" id="personal" data-value="personal" checked />
                <label class="custom-control-label" for="personal">Personal</label>
              </div>
              <div class="custom-control custom-control-primary custom-checkbox mb-1">
                <input type="checkbox" class="custom-control-input input-filter" id="business" data-value="business" checked />
                <label class="custom-control-label" for="business">Business</label>
              </div>
              <div class="custom-control custom-control-warning custom-checkbox mb-1">
                <input type="checkbox" class="custom-control-input input-filter" id="family" data-value="family" checked />
                <label class="custom-control-label" for="family">Family</label>
              </div>
              <div class="custom-control custom-control-success custom-checkbox mb-1">
                <input type="checkbox" class="custom-control-input input-filter" id="holiday" data-value="holiday" checked />
                <label class="custom-control-label" for="holiday">Holiday</label>
              </div>
              <div class="custom-control custom-control-info custom-checkbox">
                <input type="checkbox" class="custom-control-input input-filter" id="etc" data-value="etc" checked />
                <label class="custom-control-label" for="etc">ETC</label>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-auto">
          <img src="{{ url('/') }}/app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" />
        </div>
      </div>
      <!-- /Sidebar -->

      <!-- Calendar -->
      <div class="col position-relative">
        <div class="card shadow-none border-0 mb-0 rounded-0">
          <div class="card-body pb-0">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <!-- /Calendar -->
      <div class="body-content-overlay"></div>
    </div>
  </div>
  <!-- Calendar Add/Update/Delete event modal-->
  <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
    <div class="modal-dialog sidebar-lg">
      <div class="modal-content p-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        <div class="modal-header mb-1">
          <h5 class="modal-title">Add Event</h5>
          <div class="advantages-icon"><span class="ico adv-time-0"><i class="ico hl adv-time-1"></i></span></div>
        </div>
        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
          <form class="event-form needs-validation" id="newEvents" data-ajax="true" method="POST" novalidate>
            @csrf
            @honeypot
            <div class="form-group">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" required />
            </div>
            <div class="form-group">
              <label for="select-label" class="form-label">Label</label>
              <select class="select2 select-label form-control w-100" id="select-label" name="label">
                <option data-label="primary" value="Business" selected>Business</option>
                <option data-label="danger" value="Personal">Personal</option>
                <option data-label="warning" value="Family">Family</option>
                <option data-label="success" value="Holiday">Holiday</option>
                <option data-label="info" value="ETC">ETC</option>
              </select>
            </div>
            <div class="form-group position-relative">
              <label for="start-date" class="form-label">Start Date</label>
              <input type="text" class="form-control" id="start-date" name="start_date" placeholder="Start Date" />
            </div>
            <div class="form-group position-relative">
              <label for="end-date" class="form-label">End Date</label>
              <input type="text" class="form-control" id="end-date" name="end_date" placeholder="End Date" />
            </div>
            <div class="form-group">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input allDay-switch" id="customSwitch3" />
                <label class="custom-control-label" for="customSwitch3">All Day</label>
              </div>
            </div>
            <div class="form-group">
              <label for="event-url" class="form-label">Event URL</label>
              <input type="url" class="form-control" id="event-url" name="event_url" placeholder="https://www.google.com" />
            </div>
            <div class="form-group">
              <label for="event-location" class="form-label">Customer</label>
              <input type="text" class="form-control" id="event-location" name="customer" placeholder="Customer Name" />
            </div>
            <div class="form-group">
              <label class="form-label">Description</label>
              <input type="text" class="form-control" id="event-description" name="description" placeholder="Enter Description" />
            </div>
            <div id="del"></div>
            <div class="form-group d-flex">
              <input type="submit" value="create" name="type" id="create_event" class="btn btn-primary add-event-btn mr-1">
              <button type="button" class="btn btn-outline-secondary btn-cancel" data-dismiss="modal">Cancel</button>
              <button type="submit" id="update_event" class="btn btn-primary update-event-btn d-none mr-1">Update</button>
              <button id="delete_event" class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Calendar Add/Update/Delete event modal-->
</section>
<!-- Full calendar end -->

@endsection

@section('js')
<script src="{{ url('/') }}/app-assets/vendors/js/calendar/fullcalendar.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="{{ url('/') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<!-- <script src="{{ url('/') }}/app-assets/js/scripts/pages/app-calendar-events.js"></script> -->

<!-- END: Page JS-->
<script>
  "use strict";
  var date = new Date(),
  nextDay = new Date(new Date().getTime() + 864e5),
  nextMonth =
  11 === date.getMonth() ?
  new Date(date.getFullYear() + 1, 0, 1) :
  new Date(date.getFullYear(), date.getMonth() + 1, 1),
  prevMonth =
  11 === date.getMonth() ?
  new Date(date.getFullYear() - 1, 0, 1) :
  new Date(date.getFullYear(), date.getMonth() - 1, 1),
  events = <?= $events ?>;

  $("#create_event").click(function(e) {
    e.preventDefault();
    var postData = $("#newEvents").serialize();
    // console.log(postData);
    $.ajax({
      url: '{{ route("create_event") }}',
      data: postData,
      type: "post",
      success: function(data) {
        alert("Added Successfully");
      },
      error: function(error){
        alert(error)
        console.log(error)
      }
    });
  });

  $("#delete_event").click(function(e) {
    e.preventDefault();
    $.ajax({
      url: '{{ route("create_event") }}',
      data: {
        id: $("#event_id"),
        type: "delete",
      },
      type: "post",
      success: function(data) {
        alert("Added Successfully");
      },
      error: function(error){
        alert(error)
        console.log(error)
      }
    });
  });
</script>

<script src="{{ url('/') }}/app-assets/js/scripts/pages/app-calendar.js"></script>
@endsection