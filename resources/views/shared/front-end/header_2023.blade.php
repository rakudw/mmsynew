    <!-- header starts -->
    <div class="main_header_starts">
        <!-- row one-->
        <div class="header_row_one m-container">
            <!-- left side top header bar starts-->
            <div class="social_darktheme_section">
                <div class="facebook_icon">
                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                </div>
                <div class="darktheme_button_a">
                    <div class="darktheme_button">
                        <button class="light" id="toggle-light-mode"></button>
                        <button class="dark"  id="toggle-dark-mode"></button>
                    </div>
                    <div class="triple_a">
                        <button class="a-minus"  id="decrease-font-size">A-</button>
                        <button class="a-normal" id="toggle-italic">A</button>
                        <button class="a-plus"  id="increase-font-size">A+</button>
                    </div>

                </div>

            </div>
            <!-- left side top header bar ends-->
            <!-- right sidebar top button starts -->
            <div class="donate_button">
                <button class="donate_button">Donate to CM Relief Fund</button>
            </div>
            <!-- right sidebar top button ends -->

        </div>

        <!-- row two header starts-->
        <div class="header_row_two middle_logo_button text-element">
            <div class="outer_section m-container">
            <!-- left section starts-->
            <div class="logo_plus_text">
                <div class="logo_section">
                    <img src="{{ asset("images/logo_hp.png") }}" title="logo">
                </div>
                <div class="text_logo">
                    <h1>MUKHYA MANTRI SWAVALAMBAN YOJANA</h1>
                    <h2> GOVT OF HIMACHAL PRADESH</h2>
                </div>
            </div>


            <!-- login section starts-->
            <div class="login_buttons">
            <a href="{{ route('application.create', 1) }}"><button class="applicant_login">Applicant Login</button></a>
                @guest()
                    <a href="{{ route("login") }}"><button class="department_login">Department Login</button></a>
                @endguest()
                @auth()
                    <a href="{{ route("login") }}"><button class="department_login">Account</button></a>
                @endauth()
                <button class="notification"><i class="fa fa-bell" aria-hidden="true"></i></button>
            </div>
            <!-- login section ends-->

        </div>
    </div>
        <!-- row two header ends-->


       <!-- row three header starts-->
       <div class="menu_row m-container">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#helpDeskModal" href="#">Help Desk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">How to Apply</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link about-us" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dlc-meet" href="#">DLC Meetings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link notification" href="#">Objectives</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bank-user" href="#">Bank User Manual</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tips" href="#">Useful Tips</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link important-links" href="#">Important Links
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>

    </div>

    <div class="modal fade" id="helpDeskModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Helpdesk Numbers</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">District</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th scope="row">Bilaspur</th><td>01978-224248</td><td>gmdicblp-hp@nic.in</td></tr>
                    <tr><th scope="row">Chamba</th><td>01899-222257</td><td>gmdiccba-hp@nic.in</td></tr>
                    <tr><th scope="row">Hamirpur</th><td>01972-222309</td><td>gmdichmr-hp@nic.in</td></tr>
                    <tr><th scope="row">Kullu</th><td>01902-222532</td><td>gmdicklu-hp@nic.in</td></tr>
                    <tr><th scope="row">Kinnaur</th><td>01786-222276</td><td>gmdicknr-hp@nic.in</td></tr>
                    <tr><th scope="row">Lahaul and Spiti</th><td>01900-222265</td><td>gmdicls-hp@nic.in</td></tr>
                    <tr><th scope="row">Kangra</th><td>01892-223242</td><td>gmdickgr@gmail.com</td></tr>
                    <tr><th scope="row">Mandi</th><td>01905-222161</td><td>gmdicmnd-hp@nic.in</td></tr>
                    <tr><th scope="row">Sirmaur</th><td>01702-222259</td><td>gmdicsmr-hp@gov.in</td></tr>
                    <tr><th scope="row">Solan</th><td>01792-230528</td><td>gmdicslnhp@gmail.com</td></tr>
                    <tr><th scope="row">Shimla</th><td>0177-2628270</td><td>gmdicsml-hp@nic.in</td></tr>
                    <tr><th scope="row">Una</th><td>01975-223002</td><td>gmdicuna12@gmail.com</td></tr>
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <!--- header ends -->