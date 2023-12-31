<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <base href="{{ url('/') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'MMSY') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <!-- Styles -->
    <script src="https://kit.fontawesome.com/7a54dc380d.js" crossorigin="anonymous"></script>

    @include('shared.tracking')
    @vite('resources/scss/stylesheet.scss')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- font family -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/scss/applicant.scss'])
    @if (Route::currentRouteName() == 'front-dashboard')
        @vite(['resources/scss/admin.scss', ...(empty($pageVars['assets']['css']) ? [] : $pageVars['assets']['css'])])
    @endif
    {{-- @yield('styles') --}}
</head>

<body class="g-sidenav-show  bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-4">
            @if(session()->has('success'))
                <x-alert type="success" :message="session()->get('success')" class="mt-4"/>
            @endif
            <div id="myModalError"  class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close closeMe" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{!! $error !!}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert :message="$error" :type="'danger'"/>
                @endforeach
            @endif --}}
            @yield('content')
        </div>
    </main>
    <!-- Scripts -->
    @vite(['resources/ts/admin.ts', ...(empty($pageVars['assets']['js']) ? [] : $pageVars['assets']['js'])])
    @yield('scripts')
</body>
   

</html>
