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
                <li><a href="{{ route("login") }}">{{ auth()->user() ? 'Acount' : 'Department Login'}}</a></li>
            </ul>
        </div>
    
     <div class="himachal_gov_logo">
        <img src="./images/logo2.png"/>
     </div>
    
    </div>
</div>
</div>
{{-- 
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
</div> --}}