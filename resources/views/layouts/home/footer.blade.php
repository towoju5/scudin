<?php
$colmun_1 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_1'])->get();
$colmun_2 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_2'])->get();
$colmun_3 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_3'])->get();
$colmun_4 = App\MenuLink::where(['menu_type' => 'footer', 'menu_column' => 'column_4'])->get();
?>
<footer>
  <!-- BEGIN INFORMATIVE FOOTER -->
  <div class="footer-inner">
    <div class="newsletter-row">
      <div class="container"></div>
      <!--footer-column-last-->
    </div>
    <div class="container">
      <div class="row">
        <?php 
        <div class="col-sm-4 col-xs-12 col-lg-4">
          <div class="co-info">
            <h4>Contact Us</h4>
            <?php
            $company_name   = App\Model\BusinessSetting::where('type', 'company_name')->first();
            $company_addr   = App\Model\BusinessSetting::where('type', 'company_address')->first();
            $company_email  = App\Model\BusinessSetting::where('type', 'company_email')->first();
            $company_phone  = App\Model\BusinessSetting::where('type', 'company_phone')->first();
            ?>
            <address>
              <div><em class="icon-location-arrow"></em> <span>{{$company_addr->value}}</span></div>
              <div> <em class="icon-mobile-phone"></em><span>{{$company_phone->value}}</span></div>
              <div> <em class="icon-envelope"></em><span>{{$company_email->value}}</span></div>
            </address>
            <div class="social">

              <ul class="link">
                <li class="fb pull-left"><a target="_blank" rel="nofollow" href="#" title="Facebook"></a></li>
                <li class="tw pull-left"><a target="_blank" rel="nofollow" href="#" title="Twitter"></a></li>
                <li class="googleplus pull-left"><a target="_blank" rel="nofollow" href="#" title="GooglePlus"></a></li>
                <li class="rss pull-left"><a target="_blank" rel="nofollow" href="#" title="RSS"></a></li>
                <li class="pintrest pull-left"><a target="_blank" rel="nofollow" href="#" title="PInterest"></a></li>
                <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="#" title="Linkedin"></a></li>
                <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="#" title="Youtube"></a></li>
              </ul>
            </div>
          </div>
        </div>
        

        <div class="col-md-12">
          <div class="footer-column">
            <h4>{{ str_replace('-', ' ', getenv('column_1')) }}</h4>
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
          <div class="footer-column">
            <h4>{{ str_replace('-', ' ', getenv('column_2')) }}</h4>
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
          <div class="footer-column">
            <h4>{{ str_replace('-', ' ', getenv('column_3')) }}</h4>
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
          <div class="footer-column">
            <h4>{{ str_replace('-', ' ', getenv('column_4')) }}</h4>
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

        <!--col-sm-12 col-xs-12 col-lg-8-->
        <!--col-xs-12 col-lg-4-->
      </div>
      <!--row-->

    </div>

    <!--container-->
  </div>
  <!--footer-inner-->
<?php /*
  <div class="footer-middle">
    <div class="container">
      <div class="row">
        <div class="our-features-box wow bounceInUp animated animated">
          <div class="container">
            <ul>
              <li>
                <div class="feature-box free-shipping">
                  <div class="icon-truck"></div>
                  <div class="content">Free Shipping on order over $99</div>
                </div>
              </li>
              <li>
                <div class="feature-box need-help">
                  <div class="icon-support"></div>
                  <div class="content">Need Help +(888) 123-4567</div>
                </div>
              </li>
              <li>
                <div class="feature-box money-back">
                  <div class="icon-money"></div>
                  <div class="content">Money Back Guarantee</div>
                </div>
              </li>
              <li class="last">
                <div class="feature-box return-policy">
                  <div class="icon-return"></div>
                  <div class="content">30 days return Service</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--row-->
    </div>
    <!--container-->
  </div>
*/ ?>
  <!-- BEGIN SIMPLE FOOTER -->
</footer>
<!--page-->
@include('layouts.home.partials.mobile-menu')
<?php /*
<!-- @include('layouts.home.partials.pop-up') -->
*/ ?>


<!-- <div id="fade"></div> -->


<!-- Start of HubSpot Embed Code -->
<!-- <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/22047928.js"></script> -->
<!-- End of HubSpot Embed Code -->

<!-- Cookie Consent by https://www.PrivacyPolicies.com -->
<script type="text/javascript" src="//www.privacypolicies.com/public/cookie-consent/4.0.0/cookie-consent.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
  document.addEventListener('DOMContentLoaded', function() {
    cookieconsent.run({
      "notice_banner_type": "simple",
      "consent_type": "express",
      "palette": "dark",
      "language": "en",
      "page_load_consent_levels": ["strictly-necessary"],
      "notice_banner_reject_button_hide": true,
      "preferences_center_close_button_hide": false,
      "page_refresh_confirmation_buttons": false,
      "website_name": "Scudin",
      "website_privacy_policy_url": "https://example.com/privacy-policy"
    });
  });
</script>
<!-- End Cookie Consent -->