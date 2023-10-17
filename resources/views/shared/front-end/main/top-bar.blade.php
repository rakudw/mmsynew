<!-- top banner started -->
<div class="outer_section">
    <div class="top_bar">
        <div class="helpdesk_n">
            <a href="#">HELPDESK NUMBER</a>
        </div>
    
    
        <div class="right_side_options">
            <div class="list">
                 <a href="#" id="default">Skip to main content</a>
               <!-- Dark Mode Toggle -->
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="toggleDarkMode()">
                  <label class="form-check-label" for="flexSwitchCheckDefault">Dark Mode</label>
                </div>
                {{-- <button class="custom-button" id="translateToHindi">Translate to Hindi</button>
                <button class="custom-button" id="translateToEnglish">Translate to English</button> --}}
                <!-- Font Size Buttons -->
                <div class="three_buttons">
                  <button id="decreaseFontSize">a</button>
                  <button id="increaseFontSize">A</button>
                  <button onclick="window.location.reload()">I</button>
                </div>
    
            </div>
        </div>
    </div>
</div>
<style>
  /* Style for the custom dropdown */
  .custom-dropdown {
      position: relative;
      display: inline-block;
  }

  .custom-dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
  }

  .custom-dropdown:hover .custom-dropdown-content {
      display: block;
  }
  span#\:0\.finishTargetLang {
    position: absolute;
    right: 120px;
    top: 11px;
  }
</style>

<!-- top banner ended-->