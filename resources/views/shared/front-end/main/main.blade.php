<div class="container-fluid p-0">
    <div class="notifications_outer">
        <div class="notifications">NOTIFICATION </div>
        <marquee  width="100%" direction="left" vspace="8px">
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
      <div class="main_mmsy_portal">
        <div class="nav custom_left_sectionmmsy flex-column nav-pills me-3 col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
           <div class="mmsy_outer">
             <div class="mmsy_Portal">
                <h5>MMSY PORTAL</h5>
             </div>
             <button class="nav-link active" id="v-pills-hn-tab" data-bs-toggle="modal" data-bs-target="#helpDeskModal" type="button" aria-selected="true">
               <img src="{{ asset('images/customer-support.png') }}"/>HELPDESK NO</button>

             <a data-bs-toggle="modal" data-bs-target="#successModal" href="#"><button class="nav-link" id="v-pills-n-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/sucessstoreyicon.png') }}"/>SUCCESS STORIES</button></a>
             <a href="/mmsy-dashboard" target="_blank"><button class="nav-link" id="v-pills-nol-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/security-officer.png') }}"/>MMSY DASHBOARD </button></a>
             <a data-bs-toggle="modal" data-bs-target="#videoModal" href="#"><button class="nav-link" id="v-pills-ff-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/vediotootor.png') }}"/>VIDEO TUTORIAL</button></a>
             <a data-bs-toggle="modal" data-bs-target="#NotificationModal" href="#"><button class="nav-link" id="v-pills-ff-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/bell.png') }}"/>NOTIFICATION</button></a>
             <a data-bs-toggle="modal" data-bs-target="#myModal"><button class="nav-link" id="v-pills-ff-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/gravvv.png') }}"/>GRIEVANCES</button></a>
             <a data-bs-toggle="modal" data-bs-target="#feedbackModal" href="#"><button class="nav-link feedback" id="v-pills-ff-tab" type="button" aria-selected="false" tabindex="-1" role="tab">
                <img src="{{ asset('images/edit.png') }}"/>FEEDBACK FORM</button></a>
             <a data-bs-toggle="modal" data-bs-target="#faqModal" href="#"><button class="nav-link" id="v-pills-faq-tab" type="button" aria-selected="false" tabindex="-1" role="tab"><img src="{{ asset('images/help.png') }}"/>FAQ</button></a>
          </div>
         </div>
         <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-hn" role="tabpanel" aria-labelledby="v-pills-hn-tab">
            <div class="outer_no">
              <div class="row custom_circle">
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    {{-- <h6>8613</h6> --}}
                    <h6>{{ $projectPassed }}</h6>
                    <p>Total Project Passed</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    <h6>23655</h6>
                    <p>Proposed Employement</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    <h6>{{ $industriesEstablished }}</h6>
                    <p>Industries Established</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    <h6>{{ $generateEmp }}</h6>
                    <p>Employement Generated</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    <h6>886 Cr</h6>
                    <p>Investment Generated</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="rounded-circle" >
                    <h6>1600 Cr</h6>
                    <p>Proposed Investment</p>
                  </div>
                </div>
              </div>
            </div>
      </div>
      <div class="mmsy_about">
        <div class="row main_about">
            <div class="col-md-4 ">
                <div class="card-body">
                    <div class="hover01">
                  <figure><a href="#">	<img src="{{ asset('images/mmsyhomepphoto.avif') }}" alt="cheifminister" class="img-fluid img-about"></a></figure>
                    </div>   
                                    
                  </div>
            </div>
            <div class="col-md-8 ">
                <div class="aboutus_right_sections">
                    <div class="top_heading">
                        <h3><span>ABOUT </span> Mukhyamantri Swavalamban Yojana</h3>
                        <p>There is a great need to promote self-employment, whether there is a lack of adequate empolyment in both the government sector or the private sector. The state government of Himachal Pradesh has taken the step in the direction and announced a new scheme for the youth of the state</p>
                        <a href="https://cmhimachal.hp.gov.in/index.php/" target="_blank"><button type="button" class="buttonaward">Donate to CM Relief Fund</button></a>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main_mmsy">
      <h1 class="heading_mmsy">Mukhyamantri Swavalamban Yojana</h1>
      <div class="row main_mmsy">
          <div class="col-md-4 custom_col">
            <div class="card-dark">
              <div class="card-body">
                <img src="{{ asset('images/application.png') }}"/>
                <p class="card-text">Application</p>
                 <a href="/application/new" target="_blank" class="apply_custom">Apply Online</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 custom_col">
            <div class="card-light">
              <div class="card-body">
                <img src="{{ asset('images/notebook.png') }}"/>
                <p class="card-text">Bank Login</p>
                <a href="/login" target="_blank" class="apply_custom">Login</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 custom_col">
            <div class="card-dark">
              <div class="card-body">
                <img src="{{ asset('images/calendar(1).png') }}"/>
                <p class="card-text">View Status</p> 
                <a href="/applicant-login" target="_blank" class="apply_custom">Login</a>
              </div>
            </div>
          </div>
          
        
          <div class="col-md-4 custom_col">
            <div class="card-light">
              <div class="card-body">
                  <img src="{{ asset('images/government.png') }}"/>
                <p class="card-text">Department Login</p>
                <a href="/login" target="_blank" class="apply_custom">Login</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 custom_col">
            <div class="card-dark">
              <div class="card-body">
                <img src="{{ asset('images/guide.png') }}"/>
                <p class="card-text">Guidelines</p> 
                <a href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/Notification/Operational-Guidelines-for-Mukhya-Mantri-Swawlamban-Yojna-2019.pdf" target="_blank"  class="apply_custom">View</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 custom_col">
            <div class="card-light">
              <div class="card-body">
                <img src="{{ asset('images/notification.png') }}"/>
                <p class="card-text">Notification</p>
                <a data-bs-toggle="modal" data-bs-target="#NotificationModal" href="#" class="apply_custom">View</a>
              </div>
            </div>
          </div>
        </div>
      </div>
<!--- footer started -->

<div class="footer_started">
  <div class="innerfooter">
      <button class="notice_caution"> Caution Notice</button>
      <div class="footer_note">
        <p>MMSY have not engaged any private Party/Agency/ Middlemen/ Franchise etc. for promoting or sanctioning of MMSY Projects or any financial assistance under MMSY Programme and any potential enterpreneurs / beneficiaries dealing with such agency shall be doing it at their risk and consequences. </p>
      </div>

  </div>
</div>



  </div>
</div>

{{-- Modals Section --}}

{{-- HelpDesk Modal --}}
<div class="modal fade" id="helpDeskModal" tabindex="-1">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Helpdesk Numbers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
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
{{-- Notification Modal --}}
<div class="modal fade" id="NotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive overflow-auto">
                    <table class="table table-bordered table-striped table-hover">
                        <tbody>
                        @foreach($notifications as $index => $noti)
                            <tr>
                                <td>
                                    {{ $noti->description }}
                                    @if ($noti->file)
                                        <a  href="{{ asset('storage/' . $noti->file) }}" target="_blank">Download</a>
                                    @endif

                                    @if ($noti->link)
                                        <a href="{{ $noti->link }}" target="_blank">Click here</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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

  {{-- FAQ Modal --}}
  <div class="modal fade" id="faqModal" tabindex="-1">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Frequently Ask Questions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
      
          <div class="accordion" id="accordionExample">

          @foreach($faqs as $index => $faq)
              <div class="accordion-item">
                  <h2 class="accordion-header" id="heading{{ $index + 1 }}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index + 1 }}">
                          {{ $faq->question }}
                      </button>
                  </h2>
                  <div id="collapse{{ $index + 1 }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index + 1 }}" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                          <strong>{{ $faq->answer }}</strong> <!-- Replace with your actual FAQ answer variable -->
                          <!-- Add the FAQ answer content here -->
                      </div>
                  </div>
              </div>
          @endforeach

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
    <div class="modal-dialog modal-dialog-centered">
      <form action="/grievance" method="POST" onsubmit="return confirm('Your Grievance has been submitted. We will revert back shortly!')">
          @csrf
          <div class="modal-content">
              <div class="modal-header text-center">
                  <h5 class="modal-title text-center">{{ auth()->user() ? 'Applicant Name: ' . auth()->user()->name : 'Grievance Form' }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
              </div>
              <div class="modal-body">
                  <h6 class="text-center">Applicant Grievance Form</h6>
                  <p class="text-center">(Email will be sent on Submit Your Grievance and a copy of grievance will also be sent to your mail)</p>
                  <div class="text-center">
                      @if (auth()->check())
                          <p>Applicant ID: MMSY- {{ auth()->user()->id }}</p>
                          <p>Applicant Name: {{ auth()->user()->name }}</p>
                      @else
                          <p>User Name</p>
                      @endif
                  </div>
                  <div class="row">
                    <div class="mb-6 col-sm-6">
                        <label for="from" class="form-label">From</label>
                        <input type="text" class="form-control" id="from" readonly value="{{ auth()->user() ? auth()->user()->email : '' }}">
                    </div>
                    <div class="mb-6 col-sm-6">
                        <label for="to" class="form-label">To</label>
                        <input type="text" class="form-control" id="to" readonly value="mmsy2018@gmail.com">
                    </div>
                  </div>
                  <div class="mb-3">
                      <label for="subject" class="form-label">Subject</label>
                      <select class="form-select" name="subject" id="subject" required autofocus>
                          <option value="">-- Select Subject --</option>
                          <option value="Issue related to Implementing Agency">Issue related to Implementing Agency</option>
                          <option value="Issue related to Financing Branch">Issue related to Financing Branch</option>
                          <option value="Technical Issues">Technical Issues</option>
                          <option value="Other Issues">Other Issues</option>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="description" class="form-label">Describe Your Problem/Issues</label>
                      <textarea class="form-control" name="description" id="description" value="" required autofocus placeholder="Describe Your Problem/Issues"> </textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" value="Submit">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </form>
  </div>
</div>
<div class="modal fade" id="feedbackModal" tabindex="-1">
  <form action="/feedback" method="POST" onsubmit="return confirm('Thanks For your Feedback')">
    @csrf
    <div class="modal-dialog">
    <div class="modal-content">
        <div class=" text-center modal-header">
        <h5 class="modal-title">Feedback Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label for="description" class="form-label">Type Your Feedback Below</label>
              <textarea class="form-control" name="description" id="description" value="" required autofocus placeholder="Type Your Feedback Here"> </textarea>
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
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Our Success Stories</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
          </div>
          <div class="modal-body">
              <div id="successCarousel" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <img src="https://via.placeholder.com/800x400?text=Success+1" class="d-block w-100" alt="Success 1">
                      </div>
                      <div class="carousel-item">
                          <img src="https://via.placeholder.com/800x400?text=Success+2" class="d-block w-100" alt="Success 2">
                      </div>
                      <div class="carousel-item">
                          <img src="https://via.placeholder.com/800x400?text=Success+3" class="d-block w-100" alt="Success 3">
                      </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#successCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#successCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                  </button>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Video Tutorials</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="text-center">English</h4>
                  <!-- Hindi Video -->
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID_IN_HINDI"></iframe>
              </div>
              {{-- <hr> --}}
              <div class=" col-sm-6">
                <h4 class="text-center">Hindi</h4>
                  <!-- English Video -->
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID_IN_ENGLISH"></iframe>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
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
    $('.view-button').on('click', function () {
      console.log("moye more")
            var $textElement = $(this).siblings('.text-truncate');
            if ($textElement.hasClass('expanded-text')) {
                $textElement.removeClass('expanded-text');
            } else {
                $textElement.addClass('expanded-text');
            }
        });
});
</script>
<style>
  .accordion-button[aria-expanded="true"] {
    background-color: #007bff; /* Change this to your desired highlight color */
    color: #fff; /* Change this to the text color you prefer */
}
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .expanded-text {
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
    }
    .text-wrapper {
        white-space: normal;
        word-wrap: break-word;
    }

</style>