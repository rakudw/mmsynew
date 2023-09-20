<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        @yield('breadcrumb')
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-md-auto pe-md-3 justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <em class="fa fa-user me-sm-1"></em>
                        <span class="d-sm-inline d-none">{{ auth()->user()? auth()->user()->name : '' }}</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <em class="sidenav-toggler-line"></em>
                            <em class="sidenav-toggler-line"></em>
                            <em class="sidenav-toggler-line"></em>
                        </div>
                    </a>
                </li>
                @if(auth()->user())
                    <x-navbar.notifications :user="auth()->user()"/>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
