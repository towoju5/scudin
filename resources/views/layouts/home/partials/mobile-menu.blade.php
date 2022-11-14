<!-- Mobile Menu-->
<style>
.dropdown-submenu {
   position: relative;
}

.dropdown-submenu .dropdown-menu {
   /* top: 0;
      left: 100%; */
   margin-top: -1px;
   min-width: 250px;
}


.dropdown-submenu:hover>.dropdown-menu {
   display: block;
}

li v {
   display: block;
   overflow: hidden;
   white-space: normal;
   color: #c2c2c2;
   text-decoration: none;
   padding: 10px;
   padding-left: 15px;
   font-size: 14px;
   letter-spacing: 0.5px;
   font-family: 'Raleway', sans-serif;
}
</style>
<div id="mobile-menu" style="overflow-y: hidden">
   <ul class="mobile-menu">
      <li>
         <div class="home">
            <a href="#"><i class="icon-times"></i>Close</a>
         </div>
      </li>
      <li>
         <a href="{{ route('home') }}">Home</a>
      </li>
      <?php $headerMenu = App\MenuLink::where(['menu_type' => 'header'])->get(); ?>
      @foreach($headerMenu->take(7) as $link)
      <li>
         <a href="{{ $link->menu_link }}" title="{{ $link->menu_title }}">
            {{ $link->menu_title }}
         </a>
      </li>
      @endforeach

      <li>
         <?php ($categories = \App\CPU\CategoryManager::parents()) ?>
         <span class="expand fa fa-angle-right"></span>
         <v class="mobile_menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Categories</v>
         <ul class="dropdown-menu" id="mobile_menu">
            @foreach($categories as $category)
            <li class="dropdown-submenu">
               <a class="test" href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                  &emsp; {{$category['name']}}
                  <?php if ($category->childes->count() > 0) : ?>
                  <span class="icaret fa fa-angle-right"></span>
                  <?php endif ?>
               </a>
               @if($category->childes->count()>0)
               <ul class="dropdown-menu" style="top: 0; left: 100%;">
                  @foreach($category['childes'] as $subCategory)
                  <li>
                     <a href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                        &emsp; - {{$subCategory['name']}}
                        <?php if ($subCategory->childes->count() > 0) : ?>
                        <span class="icaret fa fa-angle-right"></span>
                        <?php endif ?>
                     </a>
                     @if($subCategory->childes->count()>0)
                     <ul class="dropdown-menu" style="top: 0; left: 100%;">
                        @foreach($subCategory['childes'] as $subSubCategory)
                        <li>
                           <a
                              href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">&emsp;
                              -- {{$subSubCategory['name']}}
                           </a>
                        </li>
                        @endforeach
                     </ul>
                     @endif
                  </li>
                  @endforeach
               </ul>
               @endif
            </li>
            @endforeach
         </ul>
      </li>
      <li><a href="{{ route('customer.auth.login') }}">Login</a> </li>
   </ul>
</div>
<script>
$(document).ready(function() {
   $('.mobile_menu').on("click", function(e) {
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
   });
});
</script>