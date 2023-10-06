

<div class="wrapper">
    <div class="wrapper-inner">
    
        <!-- logo and nav section -->
        <div class="flex-wrapper">
            <div class="image-text">
                <div class="image">
                    <img src="{{ asset('images/Sawavlamban-logo.png') }}" alt="logo">
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
            </div>
    
            
    
        <div class="himachal_gov_logo">
            <img src="{{ asset('images/logo2.png') }}"/>
        </div>
    
        </div>
        <!-- logo and nav end here -->
    
</div>