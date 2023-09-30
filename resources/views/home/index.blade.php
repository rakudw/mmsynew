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
    <style>
        
    .notification-news
        {
        background-color: #fff;
        width: 100%;
        border-bottom: 2px solid #6D6D6D ;
        position: relative;
       }
    .notification-news .update {
        position: absolute;
        top: 0;
        left: 0;
        padding: 10px 49px;
        color: #fff;
        font-size: 15px;
        background-color: #B51E1E;
        font-weight: bold;
        z-index: 4;
        text-align: center;
    }
    
        marquee
        {
        color: #6D6D6D;
        font-size: 15px;
        margin-top: 3px;   
    }
    .mmsy_outer
     {
    border: 1px solid #C2C0C0;
    background-color: #EFEFEF;
    height: 840px;
}
.mmsy_Portal
 {
    background-color: #9D9D9D;
    text-align: center;
    padding: 20px 15px;
 }
 .mmsy_Portal h5
 {
    color: #ffff;
    font-size: 20px;
    font-weight: bold;
   
}
.nav-pills .nav-link.active
{
   background-color: #727272; 
   margin-left: 10px;
   margin-right: 10px;
   padding: 10px!important;
   border-radius: 50px;
}
#v-pills-hn-tab
 {
    margin-top: 20px;
}
 #v-pills-hn-tab,#v-pills-n-tab,#v-pills-nol-tab,#v-pills-ff-tab,#v-pills-fr-tab,#v-pills-faq-tab,#v-pills-g-tab
{
    padding: 20px;
    column-gap: 15px;
    display: flex;
    color: #010101;
    font-size: 16px;
    font-weight: 500;
}
i.fa-solid.fa-bell
 {
    font-size: 16px;
    padding-top: 5px;
}
#v-pills-hn
{
    background-color: #F8F8F8;
    width: 1065px;
}
.card-body
 {
    width: 100%;
    height: auto;
    text-align: center;
    margin: 1rem auto;
}
.img-fluid
{
    border: 1px solid transparent;
    border-radius:100%;
}

button.buttonaward
 {
    background-color: #F58D1E;
    color: #fff;
    border: 1px solid;
    font-size: 15px;
    font-weight: 500;
    padding: 10px 30px;
}
.aboutus_right_sections
 {
    margin-top: 75px;
    
}
.top_heading span 
{
    color: #000;
    font-weight: 500;
}
.top_heading h3 
{
    font-size: 22px;
    font-weight: 600;
    line-height: 36px;
    letter-spacing: 0em;
    color: #E36E2C;
}
.top_heading p
 {
   
    font-size: 15px;
    font-weight: 500;
    line-height: 26px;
    letter-spacing: 0em;
    text-align: left;
    color: #4B4B4B;
    max-width: 100%;
    width: 501px;
}
h1.heading_mmsy
 {
    text-align: center;
    color: #484848;
    font-size: 25px;
    font-weight: bold;
 }
.card-dark
{
    
    background-color: #FFA23D;
    margin: 10px;
    height: 150px;
    padding: 10px;
    border-radius: 10px;
}
.card-light
{
    background-color: #EFEFEF;
    margin: 10px;
    height: 150px;
    padding: 10px;
    border-radius: 10px;
}
.main_mmsy img
{  
    width: 145px;
}
p.card-text
 {
    font-size: 20px;
    font-weight: 600;
    color: #333333;
}
.footer-content
 {
   
    background-color: #001529;
    height: 40px;
}
.footer-content p
 {
    color: #fff;
    font-size: 15px;
    float: right;
    padding: 10px;
    
}
.footer-content span
{
    color: #FFA23D;
}
.footer-content h6 
{
    color: #698494;
    padding: 10px;
    float: right;
}
.social_icon 
{
    padding: 10px;
}
.social_icon span
{
    padding: 5px;
    color: #fff;
}
.center 
{
    text-align: center;
}
a.ButtonRound
         {
    border: 4px solid #FFFFFF;
    border-radius: 10px;
    background-color: #F58D1E;
    color: #ffffff;
    font-weight: bold;
    text-decoration: none;
    margin: 1px;
    padding: 5px 10px 5px 10px;
    display: inline-block;
}
.form_outer
{
    border-spacing: 1px;
    border-style: solid;
    border-color: #2C4F85;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
    padding: 20px;
}
.form_heading p
{
    color: #CC6600;
    font-size: 16px;
    font-weight: bold;
    background-color: #BDE5F8;
    text-align: center;
}
.form-inline 
{
    margin: 10px;
    display: flex;
}
label.col-md-4 {
   
    justify-content: end;
    display: flex;
    padding: 10px 20px;
}
.notification_outer
{
    text-align: center;
    text-align: center;
}
.notification
{
    background-color: #CC6600;
    color: white;
    text-decoration: none;
    padding: 15px 26px;
    position: relative;
    display: inline-block;
    border-radius: 2px;
    font-size: 15px;
}
.notification .badge {
    position: absolute;
    top: -10px;
    right: -10px;
    padding: 5px 10px;
    border-radius: 50%;
    background-color: red;
    color: white;
}
.form_title
{
    color: #CC6600;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    padding: 10px;
}
.title_outer
{ 
    color: #333333;
    background-color: #EFE0D1;
    padding: 5px;
    margin: 10px;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    
}
input[type=text],input[type=password]
{
    width: 250px;
    border: 1px solid #000;
    border-radius: 10px;
}
label.col-md-4
 {
    justify-content: end;
    display: flex;
    padding: 10px;
    font-size: 12px;
    font-weight: bold;
    background-color: #EFE0D1;
    margin: 5px 10px;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    
}
.btns
 {
    padding: 10px;
    background-color: #EFE0D1;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;   
}
button.btn.btn-primary.btn-block.mb-8
{
    background-color: #CC6600;
    color: white;
    border: 1px solid #cc6600;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 15px;
}
.col a
{
   border: 4px solid #FFFFFF;
    border-radius: 10px;
    background-color: #0000CC;
    color: #ffffff;
    font-weight: bold;
    text-decoration: none;
    padding: 5px 10px 5px 10px;
    display: inline-block;
}


    </style>

    <div class="container">
        <div class="notification-news">
            <div class="update"> NOTIFICATION</div>
            <marquee width="100%" direction="left" vspace="8px">
                Add some text | Click here to download The Notifications will keep scrolling horizontally | NOTIFICATION |
            </marquee>
        </div>
    </div>
</div>

<div class="container main">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
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
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-hn role="tabpanel" aria-labelledby="v-pills-hn-tab">
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
              <div class="tab-pane fade" id="v-pills-n" role="tabpanel" aria-labelledby="v-pills-n-tab">2nd</div>
              <div class="tab-pane fade" id="v-pills-nol" role="tabpanel" aria-labelledby="v-pills-nol-tab">3rd</div>
              <div class="tab-pane fade" id="v-pills-nf" role="tabpanel" aria-labelledby="v-pills-nf-tab">4th</div>
              <div class="tab-pane fade" id="v-pills-nr" role="tabpanel" aria-labelledby="v-pills-nr-tab">4th</div>
              <div class="tab-pane fade" id="v-pills-faq" role="tabpanel" aria-labelledby="v-pills-faq-tab">4th</div>
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
    
      
@endsection
