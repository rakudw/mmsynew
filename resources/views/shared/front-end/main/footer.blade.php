
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
  
  </script>