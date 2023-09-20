@extends('layouts.app')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('contents')
    <!--  About Section start -->
    <section class="about" id="main-content">
        @php($showMinisters = setting('show_ministers'))
        <div class="container">
            <div class="row">
                <div class="col-lg-{{ $showMinisters ? 8 : 12 }} pt-3">
                    <h2 class="py-2">About</h2>
                    <div class="about-content">
                        <div class="row">
                            <div class="col-md-4 mb-2 align-self-center">
                                <img src="{{ asset("images/shimla-header-bg.jpg") }}" alt="" class="img-fluid"/>
                            </div>
                            <div class="col-md-8">
                                <p>There is a great need to promote self-employment, whether there is a lack of adequate employment in both the public sector or the private sector. Taking a step in this direction, the state government of Himachal Pradesh has announced a new scheme for the youth of the state. The scheme named Mukhya Mantri Swavalamban Yojana (MMSY), 2019 will explore the possibility of new jobs in the field of self-employment.</p>
                                <p><a href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/mmsy/MMSY-as-on-20-04-2022.pdf" class="btn btn-theme-secondary" target="_blank">Read Notification</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                @if($showMinisters)
                    <div class="col-lg-4 pt-3">
                        <h2 class="py-2">Hon'ble Chief Minister</h2>
                        <div class="about-right">
                            <div class="align-self-center img-right">
                                <img src="{{ asset("images/jai-ram-thakur.png") }}" alt="Honourable Chief Minister" class="img-thumbnail rounded-circle">
                            </div>
                            <div class="content-right">
                                <h5>Sh. Jai Ram Thakur</h5>
                                <h4>Hon'ble Chief Minister</h4>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row py-3">
                <div class="col-lg-{{ $showMinisters ? 8 : 12 }}">
                    <h2>Mukhya Mantri Swavalamban Yojana</h2>
                    <div class="yojna-content">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 my-2">
                                <div class="useful-tips">
                                    <em class="fa-solid fa-file-contract"></em>
                                    <h4>Notification</h4>
                                    <a href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/mmsy/MMSY-as-on-20-04-2022.pdf" target="_blank" class="btn rounded-pill btn-theme-primary">Click Here</a>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 my-2">
                                <div class="guideline">
                                    <em class="fa-solid fa-file-arrow-down"></em>
                                    <h4>Guidelines</h4>
                                    <a href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/Notification/Operational-Guidelines-for-Mukhya-Mantri-Swawlamban-Yojna-2019.pdf" target="_blank" class="btn rounded-pill btn-theme-primary">Download</a>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 my-2">
                                <div class="apply-now">
                                    <em class="fa-solid fa-file-signature"></em>
                                    <h4>Submit</h4>
                                    <a href="{{ route('applications.list') }}" class="btn rounded-pill btn-theme-primary">Apply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($showMinisters)
                    <div class="col-lg-4">
                        <h2 class="py-2">Hon'ble Industries Minister</h2>
                        <div class="about-right">
                            <div class="align-self-center img-right">
                                <img src="{{ asset("images/bikram-singh.png") }}" alt="Hon'able Industries Minister" class="img-thumbnail rounded-circle">
                            </div>
                            <div class="content-right">
                                <h5>Sh. Bikram Singh Thakur</h5>
                                <h4>Hon'ble Industries Minister</h4>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row py-3">
                <div class="col-lg-8">
                    <h2>Mukhya Mantri Swavalamban Yojana</h2>
                    <div class="key-feature">
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-users"></i>
                                    <h4 class="px-lg-3">Encourage the youth</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                    <h4 class="px-lg-3">Decrease of Job Deficiency</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-landmark"></i>
                                    <h4 class="px-lg-3">Government Land for Rent</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-stamp"></i>
                                    <h4 class="px-lg-3">Reduction in Stamp Duty</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-briefcase-medical"></i>
                                    <h4 class="px-lg-3">Subsidy for a new investor</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="feature-block">
                                    <i class="fa-solid fa-credit-card"></i>
                                    <h4 class="px-lg-3">Interest Subsidy on Credit</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h2><abbr title="District Level Committee">DLC</abbr> Meetings & Proceedings</h2>
                    <div class="news-circular">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news" type="button" role="tab" aria-controls="news" aria-selected="true">Agendas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-2" id="circular-tab" data-bs-toggle="tab" data-bs-target="#circular" type="button" role="tab" aria-controls="circular" aria-selected="false">Proceedings</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                                <div class="list-group">
                                    {{-- <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a class="list-group-item list-group-item-action disabled">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a> --}}
                                </div>
                                <div class="d-flex justify-content-end"><a href="#" class="btn btn-link-secondary end-0">View More</a></div>
                            </div>
                            <div class="tab-pane fade" id="circular" role="tabpanel" aria-labelledby="circular-tab">
                                <div class="list-group">
                                    {{-- <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a href="#" class="list-group-item list-group-item-action">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a>
                                    <a class="list-group-item list-group-item-action disabled">Activates a list item element and content container. Tab should have either a data-bs-target or an href targeting a container node in the DOM.</a> --}}
                                </div>
                                <div class="d-flex justify-content-end"><a href="#" class="btn btn-link-secondary end-0">View More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-3 justify-content-md-between">
                <div class="col-md-12">
                    <h1>Important Links</h1>
                </div>
                <div class="col-md my-2">
                    <a href="http://www.dmicdc.com/index.aspx" class="important-links"><img src="{{ asset("images/dmicdc-logo.png") }}" alt="" class="img-fluid"></a>
                </div>
                <div class="col-md my-2">
                    <a href="http://www.incredibleindia.org/en/" class="important-links"><img src="{{ asset("images/digitalindia-logo.png") }}" alt="" class="img-fluid"></a>
                </div>
                <div class="col-md my-2">
                    <a href="http://amrut.gov.in/" class="important-links"><img src="{{ asset("images/atulreservation-logo.png") }}" alt="" class="img-fluid"></a>
                </div>
                <div class="col-md my-2">
                    <a href="http://www.makeinindia.com/" class="important-links"><img src="{{ asset("images/makeinindia-logo.png") }}" alt="" class="img-fluid"></a>
                </div>
                <div class="col-md my-2">
                    <a href="http://www.pmindia.gov.in/" class="important-links"><img src="{{ asset("images/housingforall-logo.png") }}" alt="" class="img-fluid"></a>
                </div>
            </div>
        </div>
    </section>
    <!--  About Section ends -->
    <!--  Counter Section start -->
    <section class="counter-section">
        <div class="container">
            <div class="row text-center text-md-start">
                {{-- <div class="col-md my-2">
                    <h2>2000</h2>
                    <h5>Total Applicants</h5>
                </div>
                <div class="col-md my-2">
                    <h2>1600</h2>
                    <h5>Total Subsidy</h5>
                </div>
                <div class="col-md my-2">
                    <h2>1000</h2>
                    <h5>Total Investor</h5>
                </div>
                <div class="col-md my-2">
                    <h2>2000</h2>
                    <h5>Female Investor</h5>
                </div>
                <div class="col-md my-2">
                    <h2>80Cr.</h2>
                    <h5>Budget for the Scheme</h5>
                </div> --}}
            </div>
        </div>
    </section>
    <!--  Counter Section ends -->
@endsection

@section('hero')
    <section class="hero-header" style="background:url({{ asset('front/images/shimla.jpg') }});">
        <div class="middle-header">
            <div class="container d-md-flex justify-content-between">
                <div class="d-md-flex p-2 justify-content-lg-between text-white align-self-auto">
                    <a href="" class="hp-govt-logo">
                        <img src="{{ asset("images/hpgov.png") }}" class="img-fluid" alt="{{ config('app.name') }}"/>
                    </a>
                    <div class="pe-2 align-self-center">
                        <h3 class="text-uppercase">Mukhya Mantri Swavalamban Yojana</h3>
                        <h4 class="text-uppercase">Govt of Himachal Pradesh</h4>
                    </div>
                </div>
                <div class="align-self-center mx-3">
                    <a href="https://cmhimachal.hp.gov.in/index.php/" target="_blank" class="btn btn-theme-primary rounded-pill">Donate to CM Relief Fund</a>
                </div>
            </div>
        </div>
        <div class="bg-light">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav justify-content-between w-100">
                                <li class="nav-item"><a class="nav-link px-2" aria-current="page" href="/">Home</a></li>
                                <li class="nav-item"><a class="nav-link px-2" href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/mmsy/MMSY-as-on-20-04-2022.pdf" target="_blank">Notification</a></li>
                                <li class="nav-item"><a class="nav-link px-2" href="https://emerginghimachal.hp.gov.in/themes/backend/uploads/notification/Notification/Operational-Guidelines-for-Mukhya-Mantri-Swawlamban-Yojna-2019.pdf" target="_blank">Operational Guidelines</a></li>
                                {{-- <li class="nav-item"><a class="nav-link px-2" href="#">FAQ</a></li>
                                <li class="nav-item"><a class="nav-link px-2" href="#">Updates</a></li>
                                <li class="nav-item"><a class="nav-link px-2" href="#">Contact Us</a></li> --}}
                                @guest()
                                    <li class="nav-item"><a class="nav-link px-2" href="{{ route("login") }}">Login</a></li>
                                @endguest()
                                @auth()
                                    <li class="nav-item"><a class="nav-link px-2" href="{{ route("dashboard") }}">Account</a></li>
                                @endauth()
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        @if(isset($events) && $events->count() > 0)
            <div class="div p-2">
                @foreach($events as $event)
                    {!! $event->html !!}
                @endforeach
            </div>
        @endif
        <div class="container hero-content">
            <div class="row justify-content-lg-start">
                <div class="col-md-8 col-lg-6 content-block">
                    <h2>Subsidy for Himachali Entrepreneurs</h2>
                    <p>Investment Subsidy @ 25% of investment upto a maximum investment ceiling of Rs. 60 lakh in plant & machinery (or equipments) with total project cost not  exceeding Rs. 100 lakh (including working capital). Investment subsidy limit would be 30% to Scheduled Castes & Scheduled Tribes and 35% to all women led enterprise & Divyangjan beneficiaries</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('news')
    <!--  News Section start -->
    <section class="d-flex w-100 shadow align-self-center news-section">
        <h3 class="latest-news">
            Latest News
        </h3>
        <marquee class="latest-news-p align-self-center">
            @foreach($newsList as $news)
                @if($news->link)
                    <a href="{{ str($news->link)->startsWith('http') ? $news->link : asset($news->link) }}">
                        @if($news->icon)
                            <em class="fa-solid fa-{{ $news->icon }}"></em>
                        @endif
                        {{ $news->title }}
                    </a>
                @else
                    <span>
                        @if($news->icon)
                            <em class="fa-solid fa-{{ $news->icon }}"></em>
                        @endif
                        {{ $news->title }}
                    </span>
                @endif
            @endforeach
        </marquee>
    </section>
    <!--  News Section ends -->
@endsection
