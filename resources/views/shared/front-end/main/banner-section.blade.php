<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
    @foreach($banners as $index => $banner)
        <div class="carousel-item active">
            <div class="sliderimg">
            <img src="{{ asset('storage/' . $banner->image) }}" alt="img">
            <div class="herosection_schemes">
                <div class="innersection_hero">
                    <div class="main_text_section">
                        <div class="main_text_section_wrapper">
                            <h1>{{ $banner->title }} </h1>
                            <div class="empty-line"></div>
                            <a class="application_section" href="/application/new">Click Here To Start Your Application</a>
                        </div>
                        @if($banner->minister_name)
                        <div class="minister-name-in-slider">
                            <h3 class="name-in-middle-slide">{{ $banner->minister_name }}</h3>
                            <h3 class="designation-in-middle-slide">{{ $banner->minister_designation }}</h3>
                        </div>
                        @endif

                        @if($banner->minister_image)
                            <div class="minister_image_name">
                            <img src="{{ asset('storage/' . $banner->minister_image) }}" alt="img">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        <!-- <div class="carousel-item">
            <div class="sliderimg">
            <img src="{{ asset('images/shimlabg2.jpg') }}" alt="img"></div>
            <div class="herosection_schemes">
                <div class="innersection_hero">
                    <div class="main_text_section">
                        <div class ="main_text_section_wrapper">
                            <h1>This scheme is exclusively for Bonafide Himachali Candidates </h1>
                            <div class="empty-line"></div>
                            <a class="application_section" href="/application/new">Click Here To Start Your Application</a>
                        </div>
                        
                        <div class="minister-name-in-slider">
                            <h3 class="name-in-middle-slide">Harshwardhan Chahuan</h3>
                            <h3 class="designation-in-middle-slide">Industries Minister	</h3>
                        </div>
                        <div class="minister_image_name">
                            <img src="{{ asset('images/hwimagemainslider.jpg') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
                
  
  <!-- major points static section starts -->
  <div class="points_four">
      <div class="list_points">
          <span class="one">CAPITAL SUBSIDY</span>
          <span class="two">INTEREST SUBSIDY</span>
          <span class="three">UP-TO 35% SUBSIDY</span>
      </div>
      <div class="new_activity">
          <div class="new_activity_inner_wrapper">
          <span>New Activity Added</span>
          <img src="{{ asset('images/tri.png') }}"/>
          <p> Agriculture,
              Animal Husbandry,
              Sericulture, Mining</p>
          </div>
      </div>
  </div>
  </div>
  </div>
  

  
