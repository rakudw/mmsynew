
<div class="copyright">
    <div class="inner_copyright">
        <div class="reserved">
            2023@ ALL Rights Reserved by <a href="">Himachal Pradesh Government</a>
        </div>
        <div class="follow_us">
            <span> Follow Us:</span>
        </div>
    </div>
</div>
<style>
    .skiptranslate{
        /* display: none !important; */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Initial default font size value
        let defaultFontSize = 18; 
  
        // Initial font size value
        let currentFontSize = defaultFontSize;
  
        // Function to update font size for all elements
        function updateFontSize(fontSize) {
            $('*').css('font-size', fontSize + 'px');
        }
  
        // Initialize font size
        // updateFontSize(currentFontSize);
  
        // Event listener for increasing font size
        $('#increaseFontSize').on('click', function () {
            currentFontSize += 2; // Increase font size by 2px (you can adjust this value)
            updateFontSize(currentFontSize);
        });
  
        // Event listener for decreasing font size
        $('#decreaseFontSize').on('click', function () {
            currentFontSize -= 2; // Decrease font size by 2px (you can adjust this value)
            updateFontSize(currentFontSize);
        });
  
        // Function to toggle dark mode
        function toggleDarkMode() {
            $('body').toggleClass('dark-mode'); // Add a dark-mode class to the body
        }
  
        // Event listener for dark mode toggle
        $('#flexSwitchCheckDefault').on('click', function () {
            toggleDarkMode();
        });
  
        // Event listener for resetting to defaults
        $('#default').on('click', function () {
          window.location.reload()
        });
    });
    $(document).ready(function () {
      var mobileToggle = $("#mobile-toggle");
      var mobileDropdown = $("<ul>").attr("id", "mobile-dropdown");
  
      // Clone and append menu items to the mobile dropdown
      $(".nav-ul li").each(function () {
          var clone = $(this).clone(true);
          mobileDropdown.append(clone);
      });
  
      // Append the mobile dropdown to the document body
      $("body").append(mobileDropdown);
  
      mobileToggle.on("click", function () {
          mobileToggle.toggleClass("active");
          mobileDropdown.slideToggle(); // Show/hide the mobile dropdown
          $(".nav-ul").toggleClass("active"); // Add/remove extra class to the menu
      });
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
  });
  
  
  
  
  
  const toggleSwitch = document.getElementById("toggle");
  const switchLabel = document.getElementById("switch");
  
  toggleSwitch.addEventListener("change", function () {
      if (this.checked) {
          switchLabel.style.backgroundColor = "#2196F3"; // Turned on color
      } else {
          switchLabel.style.backgroundColor = "#ccc"; // Turned off color
      }
  });
    // Function to load Google Translate API
    function loadGoogleTranslateAPI(language) {
            const script = document.createElement('script');
            script.src = `//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit&hl=${language}`;
            script.async = true;
            document.head.appendChild(script);
        }

        // Function to initialize Google Translate
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                includedLanguages: 'en,hi',
            }, 'google_translate_element');
        }

        // Function to change language
        function changeLanguage(language) {
            const googleTranslateElement = document.getElementById('google_translate_element');
            googleTranslateElement.innerHTML = ''; // Clear the existing translation
            loadGoogleTranslateAPI(language); // Load Google Translate API with the selected language
        }

        // Add a click event listener to the Translate button
        document.getElementById('googleTranslateButton').addEventListener('click', function() {
            var dropdownContent = document.querySelector('.custom-dropdown-content');
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });

        // Add click event listeners to language options
        $('#translateToHindi').click(function() {
            console.log('sad')
            changeLanguage('hi');
        });

        document.getElementById('translateToEnglish').addEventListener('click', function() {
            changeLanguage('en');
        });
    </script>
      <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 