<div class="wrapper">
    <div class="wrapper-inner">
    
        <!-- logo and nav section -->
    <div class="flex-wrapper">
        <div class="image-text">
            <div class="image">
                <img src="{{ asset("images/Sawavlamban-logo.png") }}" alt="logo">
            </div> 
        </div>
    
        <div class="nav navcustommain">
            <button id="mobile-toggle">☰</button>
            <ul class="nav-ul">
                <li><a href="/">Home</a></li>
                <li><a href="/application/new">Apply New</a></li>
                <!-- <li><a href="/application/status">Applicant Login</a></li> -->
                <li><a href="{{ auth()->user() ? route("logout") : route("login.applicant") }}">{{ auth()->user() ? 'Logout' : 'Applicant Login' }}</a></li>
                {{-- <li><a href="#">Operational Guidelines</a></li> --}}
                <li><a href="{{ route("login") }}">Department Login</a></li>
            </ul>
        </div>
    
     <div class="himachal_gov_logo">
        <img src="./images/logo2.png"/>
     </div>
    
    </div>
    <!-- logo and nav end here -->
    
    <!-- cards section start -->
    <div class="cards-container">
        <div class="card-1-wrapper design_card"><div id="card-1"><h5><a href="#">CAPITAL <br>SUBSIDY</a></h5></div></div>
        <div class="card-2-wrapper design_card"><div id="card-2"><h5><a href="#">INTEREST <br>SUBSIDY</a></a></h5></div></div>
        <div class="card-3-wrapper design_card"><div id="card-3"><h5><a href="#">UP-TO 35% <br>SUBSIDY</a></h5></div></div>
        <div class="card-4-wrapper"><div id="card-4">
            <h4>New <br> Activites <br> Added</h4>
            <img src="{{ asset('images/arrow.png') }}"></div>
            <ul>
                <li>Agriculture,</li>
                <li>Animal Husbandry,</li>
                <li>Sericulture, Mining</li>
            </ul>
        </div>
     </div>

    <!-- notification started -->
    <div class="container notification_custom">
        <div class="notification-news">
            <div class="update col-md-3"> NOTIFICATION</div>
            <marquee class="col-md-9 align-self-center" width="100%" direction="left" vspace="8px">
                <a href="https://mmsy.hp.gov.in/storage/files/1/User-Manual/Bank-Manager.pdf">
                    <em class="fa-solid fa-book"></em>
                User Manual for Bank Managers
                </a>
                                <a href="https://mmsy.hp.gov.in/old-portal/">
                    <em class="fa-solid fa-info-circle"></em>
                Old Portal will be working for clearing pendency, click here to visit
                </a>
                                <a href="https://mmsy.hp.gov.in/storage/files/1/Launch-of-MMSY-Portal.pdf">
                    <em class="fa-solid fa-home"></em>
                Welcome to the new portal of Mukhya Mantri Swavalamban Yojana
                </a>
            </marquee>
        </div>
    </div>




 
    <!-- card section end -->
    
        <div class="independence_and_achivement">
            <div class="header_residence">
                <h3>This scheme is exclusively for HIMACHALI RESIDENTS </h3> 
                <a class="clickhere_custom" href="/application/new">Click here to start your application</a>
               </div>
            {{-- <h3>On this independence day add more freedom to your lives</h3> --}}
            <div class="achievements">
                <h2>Achivements</h2>
                <ul class="achivelist">
                    <li>Total 8613 projects passed</li>
                    <li>23655 employment proposed</li>
                    <li>Total 5347 Industries established</li>
                    <li>1370 emplyoment generated </li>
                    <li>INR 886.32 Cr investment Made</li>
                    <li>INR 1600.68 Cr proposed investment</li>
                </ul>
        
            </div>
        </div>
        <!-- sukhu image section-->
        <div class="cm_section">
        
            <img src="{{ asset('images/minister1.png') }}" class="industrial_minister"/>
            <img src="images/cm.png" class="cm_image"/>
        </div>
        <div class="banner_section">
            <img src="{{ asset('images/namebanner1.png') }}" class="name_banner_one"/>
            <img src="{{ asset('images/namebanner2.png') }}" class="name_banner_two"/>
        </div>
    
    
    </div>
    </div>
    <script>
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
        
    </script>
     