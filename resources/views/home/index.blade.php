@extends('layouts.new_app')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('contents')
    {{-- @include('shared.front-end.slider')
    @include('shared.front-end.mmsy_tips')
    @include('shared.front-end.our_schemes')
    @include('shared.front-end.commitee')
    @include('shared.front-end.aboutus')
    @include('shared.front-end.details')
    @include('shared.front-end.important_lnks') --}}
    <div class="container">
        <div class="notification-news">
            <div class="update col-md-3"> NOTIFICATION</div>
            <marquee width="100%" class="col-md-9" direction="left" vspace="8px">
                Add some text | Click here to download The Notifications will keep scrolling horizontally | NOTIFICATION |
            </marquee>
        </div>
    </div>
</div>

<div class="container main">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3 col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="mmsy_outer">
                <div class="mmsy_Portal">
                <h5>MMSY PORTAL</h5>
                </div>
              <button class="nav-link active" id="v-pills-hn-tab" data-bs-toggle="pill" data-bs-target="#v-pills-hn" type="button" role="tab" aria-controls="v-pills-hn" aria-selected="true"><i class="fa-solid fa-bell"></i>Helpdesk Number</button>
              <button class="nav-link" id="v-pills-n-tab" data-bs-toggle="pill" data-bs-target="#v-pills-n" type="button" role="tab" aria-controls="v-pilla-n=" aria-selected="false"><i class="fa-solid fa-bell"></i>Notification</button>
              <button class="nav-link" id="v-pills-nol-tab" data-bs-toggle="pill" data-bs-target="#v-pills-nol" type="button" role="tab" aria-controls="v-pills-nol" aria-selected="false"><i class="fa-solid fa-bell"></i>Nodal Officer List</button>
              <button class="nav-link" id="v-pills-ff-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ff" type="button" role="tab" aria-controls="v-pills-ff" aria-selected="false"><i class="fa-solid fa-bell"></i>Feedback Form</button>
              <button class="nav-link" id="v-pills-fr-tab" data-bs-toggle="pill" data-bs-target="#v-pills-fr" type="button" role="tab" aria-controls="v-pills-fr" aria-selected="false"><i class="fa-solid fa-bell"></i>Feedback Report</button>
              <button class="nav-link" id="v-pills-faq-tab" data-bs-toggle="pill" data-bs-target="#v-pills-faq" type="button" role="tab" aria-controls="v-pills-faq" aria-selected="false"><i class="fa-solid fa-bell"></i>FAQ</button>
              <button class="nav-link" id="v-pills-g-tab" data-bs-toggle="pill" data-bs-target="#v-pills-g" type="button" role="tab" aria-controls="v-pills-g" aria-selected="false"><i class="fa-solid fa-bell"></i>Grievances</button>
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
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Application</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="card-light">
                          <div class="card-body">
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Guidelines</p> 
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="card-dark">
                          <div class="card-body">
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Notification</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row main_mmsy">
                      <div class="col-md-4 col-12">
                        <div class="card-dark">
                          <div class="card-body">
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Application</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="card-light">
                          <div class="card-body">
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Guidelines</p> 
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="card-dark">
                          <div class="card-body">
                            <img src="{{ asset("images/Rectangle4.png") }}">
                            <p class="card-text">Notification</p>
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
                              <figure><a href="../../pmegpeportal/pmegpaward">	<img src="{{ asset("images/cheifminister.png") }}" alt="cheifminister" class="img-fluid"></a></figure>
                                </div>   
                                <a href="../pmegpaward/"><button type="button" class="buttonaward">Donate to CM Relif Fund</button></a>                
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
    
<style>
</style>
@endsection
