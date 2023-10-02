
<div class="container main">
    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3 col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <div class="mmsy_outer">
            <div class="mmsy_Portal">
            <h5>MMSY PORTAL</h5>
            </div>
          <button class="nav-link active" id="v-pills-hn-tab" data-bs-toggle="pill" data-bs-target="#v-pills-hn" type="button" role="tab" aria-controls="v-pills-hn" aria-selected="true"><i class="fa-solid fa-house-chimney"></i>HOME</button>
          <a data-bs-toggle="modal" data-bs-target="#helpDeskModal" href="#"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-house-chimney"></i>HELPDESK NO </button></a>
          <a data-bs-toggle="modal" data-bs-target="#helpDeskModal" href="#"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-house-chimney"></i>SUCCESS STORIES </button></a>
          <a href="/mmsy-dashboard" target="_blank"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-wrench"></i>MMSY DASHBOARD</button></a>
          <a data-bs-toggle="modal" data-bs-target="#helpDeskModal" href="#"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-video"></i>VIDEO TUTORIAL </button></a>
          <a href="/mmsy-dashboard" target="_blank"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-bell"></i>NOTIFICATIONS</button></a>
          <a data-bs-toggle="modal" data-bs-target="#myModal"><button class="nav-link grievance" id="v-pills-n-tab" type="button"><i class="fa-solid fa-envelope"></i>GRIEVANCES</button></a>
          <a data-bs-toggle="modal" data-bs-target="#feedbackModal" href="#"><button class="nav-link feedback" id="v-pills-n-tab" type="button"><i class="fa-solid fa-envelope"></i>FEEDBACK FORM</button></a>
          <a data-bs-toggle="modal" data-bs-target="#helpDeskModal" href="#"><button class="nav-link" id="v-pills-n-tab" type="button"><i class="fa-solid fa-envelope"></i>REQUENTLY ASK QUESTIONS</button></a>
          </div>
        </div>
        <div class="tab-content col-md-9" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-hn" role="tabpanel" aria-labelledby="v-pills-hn-tab">
            <div class="main_mmsy">
              <h1 class="heading_mmsy">Mukhyamantri Swavalamban Yojana</h1>
              <div class="row main_mmsy">
                  <div class="col-md-4 col-12">
                    <div class="card-dark">
                      <div class="card-body">
                        <img src="{{ asset("images/newloan.png") }}">
                        <p class="card-text">Application For New Unit</p>
                        <p class="card-text"><a href="/application/new"><button class="btn btn-success">Apply</button></a></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="card-light">
                      <div class="card-body">
                        <img src="{{ asset("images/non-individual.png") }}">
                        <p class="card-text">Registered Applicant</p> 
                        <p class="card-text"><a href="{{ auth()->user() ? route("logout") : route("login.applicant") }}"><button class="btn btn-success">Login</button></a></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="card-dark">
                      <div class="card-body">
                        <img src="{{ asset("images/Official.png") }}">
                        <p class="card-text">Check Status</p>
                        <p class="card-text"><a href="{{ auth()->user() ? route("logout") : route("login.applicant") }}"><button class="btn btn-success">Status</button></a></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row main_mmsy">
                  <div class="col-md-4 col-12">
                    <div class="card-light">
                      <div class="card-body">
                        <img src="{{ asset("images/banking.png") }}">
                        <p class="card-text">Bank Login</p>
                        <p class="card-text"><a href="{{ auth()->user() ? route("logout") : route("login") }}"><button class="btn btn-success">Login</button></a></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="card-dark">
                      <div class="card-body">
                        <img src="{{ asset("images/department.png") }}">
                        <p class="card-text">Department Login</p> 
                        <p class="card-text"><a href="{{ auth()->user() ? route("logout") : route("login.applicant") }}"><button class="btn btn-success">Login</button></a></p>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
            
            
            
          </div>
          <div class="tab-pane fade" id="v-pills-g" role="tabpanel" aria-labelledby="v-pills-g-tab">
            <div class="center">
                <a href="" class="ButtonRound">Home Page</a>
            </div>
            <div class="form_outer">
                <div class="form_heading">
                    <p>Applicants whose Margin Money  has been released can submit online feedback form.<br> 
                    Please login with your registered User Name and Password to submit the online feedbackform</p>
                </div>
                <div class="notification_outer">
                    <a href="" download="" class="notification">
                        <span>Download Physical verification and Geo tagging Letter</span>
                        <span class="badge">New</span>
                </a>
                <div class="title_outer">
                <h2 class="form_title">Login Form for Registered Applicant </h2>
                </div>
                </div>
                <form>
                    
                    <div class="form-inline ">
            
                        <label class="col-md-4" for="form2Example1">User Id :</label>
                            
                      <input type="text" id="form2Example1" class="col-md-8" />
                        
                    </div>
                  
                    
                    <div class="form-inline">
                        <label class="col-md-4" for="form2Example2">Password :</label>
                      <input type="password" id="form2Example2" class="col-md-8" />
                      
                    </div>
                  
                    
                    <div class="row mb-8 btns">
                      <div class="col d-flex justify-content-center">
                    
                        
                        <div class="form-check">
                          <button type="button" class="btn btn-primary btn-block mb-8">Log in</button>
                        </div>
                      </div>
                  
                      <div class="col">
                        
                        <a href="#!">Forgot password?</a>
                      </div>
                    </div> 
                  </form>
            </div>
          </div>
      </div>
    </div>

  <!---- about us --->
  <div class="mmsy_about">
    <div class="row main_about">
        <div class="col-md-4 ">
            <div class="card-body">
                <div class="hover01">
              <figure><a href="#">	<img src="{{ asset("images/cheifminister.png") }}" alt="cheifminister" class="img-fluid"></a></figure>
                </div>   
                <a href="https://cmhimachal.hp.gov.in/index.php/" target="_blank"><button type="button" class="buttonaward">Donate to CM Relif Fund</button></a>                
              </div>
        </div>
        <div class="col-md-8 ">
            <div class="aboutus_right_sections">
                <div class="top_heading">
                    <h3><span>ABOUT </span> Mukhyamantri Swavalamban Yojana</h3>
                    <p>There is a great need to promote self-employment, whether there is a lack of adequate empolyment in both the government sector or the private sector. The state government of Himachal Pradesh has taken the step in the direction and announced a new scheme for the youth of the state</p>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- about us end --> 
    <div class="container-fluid">
      <div class="caution">
  
        <div class="caution-main">
          <div class="caution-head">
            <h5>CAUTION NOTICE</h5>
          </div>
          <div class="caution-notice">
            <p>KVIC /KVIB /DIC /COIR have not engaged any private Party/Agency/ Middlemen/ Franchise etc.
              for promoting or sanctioning of MMSY Projects or any financial assistance under MMSY
              Programme and any potential enterpreneurs / beneficiaries dealing with such agency
              shall be doing it at their risk and consequences.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="footer-content ">
        <div class="row ">
            <div class="col-lg-5">
            <p>2023 @ All Rights Reserved by<span> Himachal Government</span></p>
          </div>
          <div class="col-lg-7">
              <div class="row">
                  <div class="col-md-5">
              <h6>Follow Us:</h6>
                  </div>
                  <div class="col-md-4">
              <div class="social_icon">
              <span><i class="fa-brands fa-facebook-f"></i></span>
              <span><i class="fa-brands fa-twitter"></i></i></span>
              <span><i class="fa-brands fa-google-plus"></i></span>
              <span><i class="fa-brands fa-linkedin-in"></i></i></span>
              <span><i class="fa-brands fa-pinterest"></i></span>
              </div>
              <div class="col-md-3">
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>  

  {{-- HelpDesk Modal --}}
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
  {{-- HelpDesk Modal --}}
  <div class="modal fade" id="myModal" tabindex="-1">
  <form action="/grievance" method="POST" onsubmit="return confirm('Thanks For your Feedback')">
    @csrf
    <div class="modal-dialog">
    <div class="modal-content">
        <div class=" text-center modal-header">
        <h5 class="modal-title">{{ auth()->user() ? 'Applicant Name: ' . auth()->user()->name : 'User Name' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                
                <tbody>
                    <tr><td class="text-center">Applicant Grievance Form</td></tr>
                    <tr><td class="text-center" >(Email will be sent on Submit Your Grievance and copy of grievance will also sent to your mail:)</td></tr>
                    <tr><td class="text-center">@if (auth()->check())
                        Applicant ID: MMSY- {{ auth()->user()->id }}<br>
                        Applicant Name: {{ auth()->user()->name }}
                      @else
                          User Name
                      @endif</td></tr>
                      <tr><td class="text-center"> From<br>
                      <input style="background-color: wheat; color: black;" type="text" readonly value="">
                      <br>
                      TO <br>
                      <input style="background-color: wheat; color: black;" type="text" readonly value="mmsy2018@gmail.com">
                      <br>
                      Subjet <br>
                      <select name="subject" id="subject" style="background-color: wheat; color: black;" required autofocus>
                        <option value="">--select subject--</option>
                        <option value="Issue related to Implementing Agency">Issue related to Implementing Agency</option>
                        <option value="Issue relted to Financing Branch">Issue relted to Financing Branch</option>
                        <option value="Technical Issues">Technical Issues</option>
                        <option value="Other Issues">Other Issues</option>
                      </select> <br>
                      Discribe Your Problem/Issues <br>
                      <input style="background-color: wheat; color: black;" name="discription" type="text" value="" required autofocus>
                    </td></tr>
                </tbody>
                
            </table>
        </div>
        </div>
        <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Submit">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
  </form>
</div>
<div class="modal fade" id="feedbackModal" tabindex="-1">
  <form action="/feedback" method="POST" onsubmit="return confirm('Thanks For your Feedback')">
    @csrf
    <div class="modal-dialog">
    <div class="modal-content">
        <div class=" text-center modal-header">
        <h5 class="modal-title">Feedback Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                
                <tbody>
                    <tr><td class="text-center">Type Your Feedback Below</td></tr>
                    <tr><td class="text-center" ><input style="background-color: wheat; color: black;" name="feedback" type="text" value="" required autofocus></td></tr>
                    
                </tbody>
                
            </table>
        </div>
        </div>
        <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Submit">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  var isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    $(".grievance").click(function () {
        if(isAuthenticated){
          console.log('true')
          $("#myModal").css("display", "block");
        }
        else{
          window.location.href = '/applicant-login';
        }
    });
    $("#closeModalBtn").click(function () {
        $("#myModal").css("display", "none");
    });
    $(".feedback").click(function () {
        if(isAuthenticated){
          console.log('true')
          $("#feedbackModal").css("display", "block");
        }
        else{
          window.location.href = '/applicant-login';
        }
    });
    $("#closeModalBtn").click(function () {
        $("#feedbackModal").css("display", "none");
    });
});
</script>