@extends('layouts.home.app')
@section('title', 'My Addresses')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>My Addresses</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
<style>
  .headerTitle {
    font-size: 24px;
    font-weight: 600;
    margin-top: 1rem;
  }

  body {
    font-family: 'Titillium Web', sans-serif
  }

  .product-qty span {
    font-size: 14px;
    color: #6A6A6A;
  }

  .font-nameA {

    display: inline-block;
    margin-top: 5px !important;
    font-size: 13px !important;
    color: #030303;
  }

  .font-name {
    font-weight: 600;
    font-size: 15px;
    padding-bottom: 6px;
    color: #030303;
  }

  .modal-footer {
    border-top: none;
  }

  .cz-sidebar-body h3:hover+.divider-role {
    border-bottom: 3px solid <?= $web_config['primary_color'] ?> !important;
    transition: .2s ease-in-out;
  }

  label {
    font-size: 15px;
    margin-bottom: 8px;
    color: #030303;

  }

  .nav-pills .nav-link.active {
    box-shadow: none;
    color: #ffffff !important;
  }

  .modal-header {
    border-bottom: none;
  }

  .nav-pills .nav-link {
    padding-top: .575rem;
    padding-bottom: .575rem;
    background-color: #ffffff;
    color: #050b16 !important;
    font-size: .9375rem;
    border: 1px solid #e4dfdf;
  }

  .nav-pills .nav-link :hover {
    padding-top: .575rem;
    padding-bottom: .575rem;
    background-color: #ffffff;
    color: #050b16 !important;
    font-size: .9375rem;
    border: 1px solid #e4dfdf;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    color: #fff;
    background-color: <?= $web_config['primary_color'] ?>;
  }

  .iconHad {
    color: <?= $web_config['primary_color'] ?>;
    padding: 4px;
  }

  .iconSp {
    margin-top: 0.70rem;
  }

  .fa-lg {
    padding: 4px;
  }

  .fa-trash {
    color: #FF4D4D;
  }

  .namHad {
    color: #030303;
    position: absolute;
    padding-left: 13px;
    padding-top: 8px;
  }

  .donate-now {
    list-style-type: none;
    margin: 10px 0 20px 0;
    padding: 0;
  }

  .donate-now li {
    float: left;
    margin: 0 5px 0 0;
    width: 100px;
    height: 40px;
    position: relative;
    padding: 22px;
    text-align: center;
  }

  .donate-now label,
  .donate-now input {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .donate-now input[type="radio"] {
    opacity: 0.01;
    z-index: 100;
  }

  .donate-now input[type="radio"]:checked+label,
  .Checked+label {
    background: <?= $web_config['primary_color'] ?>;
    color: white !important;
    border-radius: 7px;
  }

  .active_address_type {
    background: <?= $web_config['primary_color'] ?>;
    color: white !important;
    border-radius: 7px;
  }

  .active_address_type:hover {
    background: <?= $web_config['primary_color'] ?> !important;
    color: white !important;
  }

  .donate-now label {
    padding: 5px;
    border: 1px solid #CCC;
    cursor: pointer;
    z-index: 90;
  }

  .donate-now label:hover {
    background: #DDD;
  }

  .price_sidebar {
    padding: 20px;
  }

  #edit {
    cursor: pointer;
  }

  @media (max-width: 600px) {
    .sidebar_heading {
      background: <?= $web_config['primary_color'] ?>;
    }

    .sidebar_heading h1 {
      text-align: center;
      color: aliceblue;
      padding-bottom: 17px;
      font-size: 19px;
    }

    .sidebarR {
      padding: 24px;
    }

    .price_sidebar {
      padding: 20px;
    }

    .btn-b {
      width: 350px;
      margin-right: 30px;
      margin-bottom: 10px;

    }

    .div-secon {
      margin-top: 2rem;
    }
  }

  .btn-danger {
    color: #fff;
    background-color: #E1A006 !important;
    border-color: #ccc;
  }
</style>
@endpush

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
              <div class="row" style="margin-bottom: 4rem;">
                <div class="col-sm-6">
                  <h1 class="h3 headerTitle" style="float: left;">{{ __('ADDRESSES')}}</h1>
                </div>
                <div class="col-sm-6">
                  <button type="submit" style="float: right;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('add_new_address')}}
                  </button>
                </div>
              </div>
              <section class="col-lg-6 col-md-6 mb-4 mt-5">
                @foreach($shippingAddresses as $shippingAddress)
                <div class="card" style="text-transform: capitalize;">
                  {{-- <div class="card cardColor"> --}}
                  <div class="card-header" style=" border: 1px solid <?= $web_config['primary_color'] ?>; padding: 5px;">
                    <i class="fa fa-thumb-tack fa-2x iconHad" aria-hidden="true"></i>
                    <span class="namHad"> {{$shippingAddress['address_type']}} {{ __('address')}} </span>
                    {{-- <div> --}}
                    <span class="float-right iconSp" style="float: right; margin-bottom: 5px">
                      <a class="btn btn-primary btn-xs" id="edit" data-toggle="modal" data-target="#editAddress_{{$shippingAddress->id}}">
                        <i class="lni lni-pencil"></i>
                      </a>
                      <a class="btn btn-danger btn-xs" href="{{ route('address-delete', ['id'=>$shippingAddress->id])}}" onclick="return confirm('Are you sure you want to Delete?');" id="delete">
                        <i class="lni lni-trash-can"></i>
                      </a>

                    </span>
                  </div>
                  {{-- </div> --}}

                  {{-- Modal Address Edit --}}
                  <div class="modal fade" id="editAddress_{{$shippingAddress->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class="modal-title font-name ">{{ __('update')}} {{ __('address')}} </h5>
                            </div>
                          </div>
                        </div>
                        <div class="modal-body">
                          <form id="updateForm">
                            @csrf
                            <div class="pb-3" style="display: flex">
                              <!-- Nav pills -->
                              <input type="hidden" id="defaultValue" class="add_type" value="{{$shippingAddress->address_type}}">
                              <ul class="donate-now">
                                <li class="address_type_li">
                                  <input type="radio" class="address_type" id="a25" name="addressAs" value="permanent" {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}} />
                                  <label for="a25" class="component">{{ __('permanent')}}</label>
                                </li>
                                <li class="address_type_li">
                                  <input type="radio" class="address_type" id="a50" name="addressAs" value="home" {{ $shippingAddress->address_type == 'home' ? 'checked' : ''}} />
                                  <label for="a50" class="component">{{ __('Home')}}</label>
                                </li>
                                <li class="address_type_li">
                                  <input type="radio" class="address_type" id="a75" name="addressAs" value="office" {{ $shippingAddress->address_type == 'office' ? 'checked' : ''}} />
                                  <label for="a75" class="component">{{ __('Office')}}</label>
                                </li>
                              </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="person_name">{{ __('contact_person_name')}}</label>
                                <input class="form-control" type="text" id="person_name" name="name" value="{{$shippingAddress->contact_person_name}}" required>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="own_address">{{ __('address')}}</label>
                                <input class="form-control" type="text" onfocus="initialize(this.id)" id="own_address" name="address" value="{{$shippingAddress->address}}" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="city">{{ __('City')}}</label>

                                <input class="form-control" type="text" id="city" name="city" value="{{$shippingAddress->city}}" required>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="zip_code">{{ __('zip_code')}}</label>
                                <input class="form-control" type="number" id="zip_code" name="zip" value="{{$shippingAddress->zip}}" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="own_state">{{ __('State')}}</label>
                                <input type="text" class="form-control" name="state" value="{{ $shippingAddress->state }}" id="own_state" placeholder="" required>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="own_country">{{ __('Country')}}</label>
                                <input type="text" class="form-control" id="own_country" name="country" value="{{ $shippingAddress->country }}" placeholder="" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="own_phone">{{ __('Phone')}}</label>
                                <input class="form-control" type="text" id="own_phone" name="phone" value="{{$shippingAddress->phone}}" required="required">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="closeB btn btn-secondary" data-dismiss="modal">{{ __('close')}}</button>
                              <button type="submit" class="btn btn-primary" id="addressUpdate" data-id="{{$shippingAddress->id}}">{{ __('update')}} </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-body" style="padding: 0 15px 15px 13px; border: 1px solid <?= $web_config['primary_color'] ?>">
                    <div class="font-name"><span>{{$shippingAddress['contact_person_name']}}</span>
                    </div>
                    <div><span class="font-nameA"> <strong>{{ __('Phone')}} :</strong> {{$shippingAddress['phone']}}</span>
                    </div>
                    <div><span class="font-nameA"> <strong>{{ __('City')}} :</strong> {{$shippingAddress['city']}}</span>
                    </div>
                    <div><span class="font-nameA"> <strong> {{ __('zip_code')}} :</strong> {{$shippingAddress['zip']}}</span>
                    </div>
                    <div><span class="font-nameA"> <strong>{{ __('address')}} :</strong> {{$shippingAddress['address']}}</span>
                    </div>
                    <div><span class="font-nameA"> <strong>{{ __('Country')}} :</strong> {{$shippingAddress['country']}}</span>
                    </div>
                  </div>
                  {{-- </div> --}}
                </div>
                @endforeach
              </section>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-12">
              <h5 class="modal-title font-name ">{{ __('add_new_address')}}</h5>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <form action="{{route('address-store')}}" method="post">
            @csrf

            <div class="col-md-12" style="display: flex">
              <ul class="donate-now">
                <li>
                  <input type="radio" id="permanent" name="addressAs" value="permanent" />
                  <label for="permanent" class="component">{{ __('permanent')}}</label>
                </li>
                <li>
                  <input type="radio" id="home" name="addressAs" value="home" />
                  <label for="home" class="component">{{ __('Home')}}</label>
                </li>
                <li>
                  <input type="radio" id="office" name="addressAs" value="office" />
                  <label for="office" class="component">{{ __('Office')}}</label>
                </li>

              </ul>
            </div>

            <!-- Tab panes -->
            <div class="panel">
              <div id="home"><br>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">{{ __('contact_person_name')}}</label>
                    <input class="form-control" type="text" id="name" name="name" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="address">{{ __('address')}}</label>
                    <input class="form-control" type="text" id="address" onfocus="initialize(this.id)" name="address" required>
                  </div>
                  <div id="map"></div>
                  <div id="infowindow-content">
                    <span id="place-name" class="title"></span><br />
                    <span id="place-address"></span>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="address-city">{{ __('City')}}</label>
                    <input class="form-control" type="text" id="address-city" name="city" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="zip">{{ __('zip_code')}}</label>
                    <input class="form-control" type="number" id="zip" name="zip" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="state">{{ __('State')}}</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="country">{{ __('Country')}}</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="firstName">{{ __('Phone')}}</label>
                    <input class="form-control" type="text" id="phone" name="phone" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close')}}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add')}} {{ __('Informations')}} </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@stop
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhnq5gDJHh8BW8FOQVCCN1RjUffKWk2eQ&libraries=places"></script>
<script>
  $(document).ready(function() {
    $('.address_type_li').on('click', function(e) {
      // e.preventDefault();
      $('.address_type_li').find('.address_type').removeAttr('checked', false);
      $('.address_type_li').find('.component').removeClass('active_address_type');
      $(this).find('.address_type').attr('checked', true);
      $(this).find('.address_type').removeClass('add_type');
      $('#defaultValue').removeClass('add_type');
      $(this).find('.address_type').addClass('add_type');

      $(this).find('.component').addClass('active_address_type');
    });
  })

  $('#addressUpdate').on('click', function(e) {
    e.preventDefault();
    let addressAs, address, name, zip, city, state, country, phone;

    addressAs = $('.add_type').val();

    address = $('#own_address').val();
    name = $('#person_name').val();
    zip = $('#zip_code').val();
    city = $('#city').val();
    state = $('#own_state').val();
    country = $('#own_country').val();
    phone = $('#own_phone').val();

    let id = $(this).attr('data-id');

    if (addressAs != '' && address != '' && name != '' && zip != '' && city != '' && state != '' && country != '' && phone != '') {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{route('address-update')}}",
        method: 'POST',
        data: {
          id: id,
          addressAs: addressAs,
          address: address,
          name: name,
          zip: zip,
          city: city,
          state: state,
          country: country,
          phone: phone
        },
        success: function() {
          toastr.success('Address Update Successfully.');
          location.reload();
          // $('#name').val('');
          // $('#link').val('');
          // $('#icon').val('');
          // $('#image-set').val('');

        }
      });
    } else {
      toastr.error('All input field required.');
    }

  });

  // Address autocomplete
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
  google.maps.event.addDomListener(window, 'load', initialize);

  function initialize(id) {
    var input = document.getElementById(id);
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      // place variable will have all the information you are looking for.
      $('#lat').val(place.geometry['location'].lat());
      $('#long').val(place.geometry['location'].lng());
    });
  }
</script>
<style>
  .modal-backdrop {
    z-index: 0 !important;
    display: none;
  }
</style>
@endpush
