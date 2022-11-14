@extends('layouts.home.app')
@section('title', 'Chat with Seller')

@section('page_title')
<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-title">
          <h2>Chat with Seller</h2>
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
            <div class="row mt-3">
              {{-- Seller List start --}}
              @if (isset($unique_shops))

              <div class="col-lg-4 chatSel">
                <div class="card box-shadow-sm">
                  <div class="inbox_people">
                    <div class="headind_srch">
                      <form class="form-inline d-flex justify-content-center md-form form-sm active-cyan-2 mt-2">
                        <input class="form-control form-control-sm mr-3 w-75" id="myInput" type="text" placeholder="Search" aria-label="Search">
                        <!-- <i class="fa fa-search" style="color: #92C6FF" aria-hidden="true"></i> -->
                      </form>
                      <hr>
                    </div>
                    <div class="inbox_chat">
                      @if (isset($unique_shops))

                      @foreach($unique_shops as $key=>$shop)
                      <div class="chat_list @if ($key == 0) btn-primary @endif" id="user_{{$shop->shop_id}}">
                        <div class="chat_people" id="chat_people">
                          <div class="d-flex justify-content-between">
                            <div class="chat_img">
                              <img width="50px" height="50px" src="@if($shop->image == 'def.png'){{asset('storage/app/public/def.png')}} @else {{asset($shop->image)}} @endif" style="border-radius: 10px">
                            </div>
                            <div class="chat_ib">
                              <h5 class="seller @if($shop->seen_by_customer)active-text @endif" id="{{$shop->shop_id}}">{{$shop->name}}</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endForeach

                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <section class="col-lg-8">
                <div class="card box-shadow-sm Chat">
                  <div class="messaging">
                    <div class="inbox_msg">

                      <div class="mesgs">
                        <div class="msg_history" id="show_msg">
                          @if (isset($chattings))

                          @foreach($chattings as $key => $chat)
                          @if ($chat->sent_by_seller)
                          <div class="incoming_msg">
                            <div class="incoming_msg_img"> 
                              <!-- <img width="50px" height="50px" src="@if($chat->image == 'def.png'){{asset('storage/app/public/'.$chat->image)}} @else {{asset('storage/app/public/shop/'.$chat->image)}} @endif" alt="sunil"> -->
                            </div>
                            <div class="received_msg">
                              <div class="received_withd_msg">
                                {!! $chat->message !!}
                                <span class="time_date"> {{$chat->created_at->format('h:i A')}} | {{$chat->created_at->format('M d')}} </span>
                              </div>
                            </div>
                          </div>

                          @else

                          <div class="outgoing_msg">
                            <div class="send_msg">
                              <p class="btn-primary">
                                {!! $chat->message !!}
                              </p>
                              <span class="time_date"> {{$chat->created_at->format('h:i A')}} | {{$chat->created_at->format('M d')}} </span>
                            </div>
                          </div>
                          @endif
                          @endForeach
                          {{-- for scroll down --}}
                          <div id="down"></div>

                          @endif
                        </div>
                        <div class="col-12">
                          <div class="input_msg_write">
                            <form class="form-inline d-flex justify-content-center md-form form-sm active-cyan-2 mt-2" id="myForm">
                              @csrf

                              <input type="text" id="hidden_value" hidden value="{{$last_chat->shop_id}}" name="">
                              <input type="text" id="seller_value" hidden value="{{$last_chat->shop->seller_id}}" name="">

                              <input class="form-control form-control-sm mr-3 w-75" id="msgInputValue" type="text" placeholder="Send a message" aria-label="Search">
                              <input class="aSend" type="submit" id="msgSendBtn" style="width: 45px;" value="Send">
                              {{-- <a class="aSend" id="msgSendBtn">Send</a> --}}
                              {{-- <i class="fa fa-send" style="color: #92C6FF" aria-hidden="true"></i> --}}

                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              @else
              <div class="col-md-8" style="display: flex; justify-content: center;align-items: center;">
                <p>No conversetion found</p>
              </div>
              @endif
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
@stop

@push('js')
<script>
  $(document).ready(function() {
    var shop_id;
    $(".msg_history").stop().animate({
      scrollTop: $(".msg_history")[0].scrollHeight
    }, 1000);
    // var perams_url = window.location.search.substring(1);
    // var perams_url_split = perams_url.split('&');

    $(".seller").click(function(e) {
      e.stopPropagation();
      shop_id = e.target.id;
      //active when click on seller
      $('.chat_list.btn-primary').removeClass('btn-primary');
      $(`#user_${shop_id}`).addClass("btn-primary");
      $('.seller').css('color', 'black');
      $(`#user_${shop_id} h5`).css('color', 'white');

      $.ajax({
        type: "get",
        url: "messages?shop_id=" + shop_id,
        success: function(data) {
          $('.msg_history').html('');
          $('.chat_ib').find('#' + shop_id).removeClass('active-text');

          if (data.length != 0) {
            data.map((element, index) => {
              let dateTime = new Date(element.created_at);
              var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

              let time = dateTime.toLocaleTimeString().toLowerCase();
              let date = month[dateTime.getMonth().toString()] + " " + dateTime.getDate().toString();

              if (element.sent_by_customer) {

                $(".msg_history").append(`
                    <div class="outgoing_msg"> 
                      <div class='send_msg'> 
                        <p  class="btn-primary">${element.message}</p>
                        <span class='time_date'> ${time}    |    ${date}</span> 
                      </div> 
                    </div>`)

              } else {
                let img_path = element.image == 'def.png' ? `${window.location.origin}/storage/app/public/${element.image}` : `${window.location.origin}/storage/app/public/shop/${element.image}`;

                $(".msg_history").append(`
                    <div class="incoming_msg" style="display: flex;" id="incoming_msg"> 
                      <div class="incoming_msg_img" id=""> 
                        <img src="${img_path}" alt="">
                      </div> 
                      <div class="received_msg"> 
                        <div class="received_withd_msg"> 
                          <p id="receive_msg">${element.message}</p> 
                        <span class="time_date">${time}    |    ${date}</span></div> 
                      </div> 
                    </div>`)
              }
              $('#hidden_value').attr("value", shop_id);
            });
          } else {
            $(".msg_history").html(`<p> No Message available </p>`);
            data = [];
          }
          // data = "";
          // $('.msg_history > div').remove();

        }
      });

      $('.type_msg').css('display', 'block');
      $(".msg_history").stop().animate({
        scrollTop: $('.msg_history').prop("scrollHeight")
      }, 1000);

    });

    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".chat_list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#msgSendBtn").click(function(e) {
      e.preventDefault();
      // get all the inputs into an array.
      var inputs = $('#myForm').find('#msgInputValue').val();
      var new_shop_id = $('#myForm').find('#hidden_value').val();
      var new_seller_id = $('#myForm').find('#seller_value').val();


      let data = {
        message: inputs,
        shop_id: new_shop_id,
        seller_id: new_seller_id
      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      $.ajax({
        type: "post",
        url: "{{route('messages_store')}}",
        data: data,
        success: function(respons) {
          $(".msg_history").append(`
                <div class="outgoing_msg" id="outgoing_msg"> 
                  <div class='send_msg'> 
                    <p>${respons}</p>
                    <span class='time_date'> now</span> 
                  </div> 
                </div>`)
        }
      });
      $('#myForm').find('#msgInputValue').val('');
      $(".msg_history").stop().animate({
        scrollTop: $(".msg_history")[0].scrollHeight
      }, 1000);

    });
  });
</script>

@endpush