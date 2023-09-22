<!--- slider section  starts -->
<div class="slider_plus_section">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
            
            @foreach($banners as $key => $banner)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="images/SHIMLA.png" alt="First slide">
                    <div class="slider_text_heading">
                        <h1 class="hindi_heading">सुख की सरकार</h1>
                        <h2 class="enterprenur_heading"> {{ $banner->title }}</h2>
                        <p>{{ $banner->description }}</p>
                        <button type="button" class="apply_online btn btn-primary" data-bs-toggle="modal" data-bs-target="#instructionModal"> Apply Online for Mukhyamantri Swavalamban Yojana</button>
                    </div>
                </div>
            @endforeach
                <!-- <div class="carousel-item">
                   


                    <div class="slider_text_heading">
                        <h1 class="hindi_heading">सुख की सरकार</h1>
                        <h2 class="enterprenur_heading"> HIMACHALI ENTREPRENEURS </h2>
                        <p>Investment Subsidy @ 25% of investment upto a maximum investment ceiling of Rs. 60 lakh in plant &
                            machinery (or equipments) with total project cost not exceeding Rs. 100 lakh (including working
                            capital). Investment subsidy limit would be 30% to Scheduled Castes & Scheduled Tribes and 35% to all
                            women led enterprise & Divyangjan beneficiaries.</p>
                            <a href="{{ route('application.create', 1) }}"><button class="apply_online"> Apply Online for Mukhyamantri Swavalamban Yojana</button></a>
            
                        
                       
            
                    </div>
                </div> -->
               
            </div>
           
           <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="misniter_position_outer">
                <div class="ministers">
                    <img src="images/industrial.png" alt="industrialministeer">
                    <img src="images/cheifminister.png" alt="cheif_minister" />
                </div>
            </div>
        </div>

          
      
    </div>

    <!--- background slider ends -->
    <div class="modal fade modal-lg" id="instructionModal" style="z-index: 9999999; " tabindex="-1" aria-labelledby="instructionModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="background-color:#ecf8f9" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Instructions and Declaration</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Place your instructions content here -->
                    <h5 class="card-title">By clicking the button below you agree to the following:</h5>
                    <ul class="list-group">
                        <li class="list-group-item">• The applicant is a <abbr title="Bonafide certificate is certification provided to the citizen by the government confirming and testifying their place of residence in the district of Himachal Pradesh.">Bonafied Himachali</abbr>.</li>
                        <li class="list-group-item">• The age of the applicant is as per the policy requirements.</li>
                        <li class="list-group-item">• The applicant and their spouse have not taken the benefit of this scheme yet.</li>
                        <li class="list-group-item">• The applicant has read the policy document thoroughly.</li>
                        <li class="list-group-item">* <small>The applicant above refers to all the partners/shareholders collectively or the individual in case of a proprietorship.</small></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <!-- Add a button to close the modal -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add a button to continue with the application -->
                    <a href="{{ route('application.create', 1) }}"><button type="button" class="btn btn-primary">Accept & Continue With New Application</button></a>
                </div>
            </div>
        </div>
      </div>