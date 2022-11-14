<div class="popup1">
  <div class="newsletter-sign-box">

    <div class="newsletter">
      <img src="{{ url('/') }}/home/images/close-icon.png" alt="close" class="x1" onClick="HideMe();">
      <form method="post" id="popup-newsletter" name="popup-newsletter" class="email-form">
        @csrf
        <h3>Newsletter Sign up</h3>

        <h4>Flipmart Men's clothing store is updated regularly with offers.</h4>
        <div class="newsletter-form">
          <div class="input-box">
            <input type="text" name="email" id="newsletter2" title="Sign up for our newsletter" placeholder="Enter your email address" class="input-text required-entry validate-email">
            <button type="submit" title="Subscribe" class="button subscribe"><span>Subscribe</span></button>

          </div>
          <!--input-box-->
        </div>
        <!--newsletter-form-->
        <!-- <label class="subscribe-bottom"><input type="checkbox" name="notshowpopup" id="notshowpopup">Don’t show this popup again</label> -->
      </form>



    </div>
    <!--newsletter-->

  </div>
</div>