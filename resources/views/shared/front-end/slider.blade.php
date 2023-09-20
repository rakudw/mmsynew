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
                            <a href="{{ route('application.create', 1) }}"><button class="apply_online"> Apply Online for Mukhyamantri Swavalamban Yojana</button></a>
            
                        <!-- cheif_minister_industrial_minister -->
                       
            
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