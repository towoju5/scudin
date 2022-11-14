<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
$colmun_1 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_1'])->get();
$colmun_2 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_2'])->get();
$colmun_3 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_3'])->get();
$colmun_4 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_4'])->get();
?>
<!-- back to top -->
<div class="back-to-top">
   @php
   $social_media = \App\Model\SocialMedia::where('active_status', 1)->get();
   @endphp
   @if(isset($social_media))
      @foreach ($social_media as $item)
         <a class="social-btn sb-light sb-{{$item->name}} ml-2 mb-2" href="{{$item->link}}">
             <i class="{{$item->icon}} fa-2x" aria-hidden="true"></i>
         </a>
      @endforeach
   @endif
</div>
<!-- <a id="button"></a> -->
@include('layouts.home.partials.mobile-menu')
<!-- Get to Know Us -->
<div class="get-to-know" style="padding: 10px 30px 30px 10px;">
   <div class="get-to-know-1">
      <h2>{{ str_replace('-', ' ', getenv('column_1')) }}</h2>
      <ul class="links">
         @foreach($colmun_1 as $link)
         <li>
            <a href="{{ $link->menu_link }}" title="{{ $link->menu_title }}">
               {{ $link->menu_title }}
            </a>
         </li>
         @endforeach
      </ul>
   </div>
   <div class="get-to-know-2">
      <h2>{{ str_replace('-', ' ', getenv('column_2')) }}</h2>
      <ul class="links">
         @foreach($colmun_2 as $link)
         <li>
            <a href="{{ $link->menu_link }}" title="{{ $link->menu_title }}">
               {{ $link->menu_title }}
            </a>
         </li>
         @endforeach
      </ul>
   </div>
   <div class="get-to-know-3">
      <h2>{{ str_replace('-', ' ', getenv('column_3')) }}</h2>
      <ul class="links">
         @foreach($colmun_3 as $link)
         <li>
            <a href="{{ $link->menu_link }}" title="{{ $link->menu_title }}">
               {{ $link->menu_title }}
            </a>
         </li>
         @endforeach
      </ul>
   </div>
   <div class="get-to-know-4">
      <h2>{{ str_replace('-', ' ', getenv('column_4')) }}</h2>
      <ul class="links">
         @foreach($colmun_4 as $link)
         <li>
            <a href="{{ $link->menu_link }}" title="{{ $link->menu_title }}">
               {{ $link->menu_title }}
            </a>
         </li>
         @endforeach
      </ul>
   </div>
</div>
<!-- footer -->
<script>
   var btn = $('#button');

   $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
         btn.addClass('show');
      } else {
         btn.removeClass('show');
      }
   });

   btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({
         scrollTop: 0
      }, '300');
   });
</script>
<style>
   #button {
      display: inline-block;
      background-color: #FF9800;
      width: 50px;
      height: 50px;
      text-align: center;
      border-radius: 4px;
      position: fixed;
      bottom: 30px;
      right: 30px;
      transition: background-color .3s, opacity .5s, visibility .5s;
      opacity: 0;
      visibility: hidden;
      z-index: 1000;
   }

   #button::after {
      content: "\f077";
      font-family: FontAwesome;
      font-weight: normal;
      font-style: normal;
      font-size: 2em;
      line-height: 50px;
      color: #fff;
   }

   #button:hover {
      cursor: pointer;
      background-color: #333;
   }

   #button:active {
      background-color: #555;
   }

   #button.show {
      opacity: 1;
      visibility: visible;
   }

   /* Styles for the content section */

   .content {
      width: 100%;
      /* margin: 50px auto; */
      font-family: 'Merriweather', serif;
      font-size: 17px;
      color: #6c767a;
      line-height: 1.9;
   }


   ul {
      list-style-type: none;
      margin: 0px;
      padding: 0px;
   }

   a {
      text-decoration: none !important;
   }
</style>
