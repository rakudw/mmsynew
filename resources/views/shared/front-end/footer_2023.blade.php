<!-- footer secton startss-->
<div class="footer text-element">
   <div class="inner_footer m-container">
    <div class="column_one">
        <div class="logo_section">
            <img src="images/logofooter.png"/>
            <p>There is a great need to promote self-employment, whether there is a lack of adequate empolyment in both the government sector or the private sector. The state government of Himachal Pradesh has taken the step in the direction and announced a new scheme for the youth of the state</p>
        </div>

      <div class="column_second">
        <h3>Important Links</h3>
        <span class="divider foter"></span>
        <ul>
            <li><a href="#">How To Apply</a></li>
            <li><a href="#">Who We Are</a></li>
            <li><a href="#">What We Do</a></li>
            <li><a href="#">Notification</a></li>
            <li><a href="#">Bank User Manual</a></li>
        </ul>
      </div> 
      
      
      <div class="column_third">
        <h3>Contact Info</h3>
        <span class="divider foter"></span>
        <p class="address">Department of Industries, Udyog Bhawan, Bemloe,Shimla 171001, Himachal Pradesh</p>
        <div class="email_section">
            <span>E-Mail ID</span><a href="mailto:mmsyhp2018@gmail.com">mmsyhp2018@gmail.com</a>
        </div>
        <div class="email_section">
            <span>Helpline number:</span><a href="tel:0177-2813414"> 0177-2813414</a>
        </div>
      </div>
    </div>
   </div>

</div>

<!-- copyright footer starts-->

<div class="footer_section_copyright">
<p>© 2023 Department of Industries, Himachal Pradesh. All rights reserved.</p>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script >
   function googleTranslateElementInit() {
    @if(!empty(auth()->user()->id))
      @if(auth()->user())
        @if("hi")
          setCookie('googtrans', '/en/hi',0.3);
        @else
        
          setCookie('googtrans', '/en/en',0.3);
        @endif
      @endif
    @else
    setCookie('googtrans', '/en/en',0.3);
    @endif
    new google.translate.TranslateElement({
      // pageLanguage: 'HI', 
      includedLanguages: 'en,hi',
    }, document.body);
  }
  function setCookie(key, value, expiry) {
    var expires = new Date();
    const expiryInSeconds = 24 * 60 * 60; // 1 day in seconds
    const expiryInMilliseconds = expiryInSeconds * 1000; // Convert to milliseconds
    expires.setTime(expires.getTime() + expiryInMilliseconds);
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
  }
  
  jQuery(document).ready(function() {
      $("a.about-us").click(function(event) {
          event.preventDefault(); 
          $("html, body").animate({
              scrollTop: $(".aboutus_starts").offset().top
          }, 200, "easeInOutExpo"); 
      });
      $("a.dlc-meet").click(function(event) {
          event.preventDefault(); 
          $("html, body").animate({
              scrollTop: $(".commitee_outer").offset().top
          }, 200, "easeInOutExpo"); 
      });
      $("a.tips").click(function(event) {
          event.preventDefault(); 
          $("html, body").animate({
              scrollTop: $(".mmsy_tips_sections").offset().top
          }, 200, "easeInOutExpo"); 
      });
      $("a.important-links").click(function(event) {
          event.preventDefault(); 
          $("html, body").animate({
              scrollTop: $(".important_lnks_section").offset().top
          }, 200, "easeInOutExpo"); 
      });
  });
</script>
<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->