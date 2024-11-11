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

    <!-- Styles -->
    @vite(['resources/scss/admin.scss', ...(empty($pageVars['assets']['css']) ? [] : $pageVars['assets']['css'])])
    @yield('styles')
</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('shared.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('shared.navbar')
        <div class="container-fluid py-4">
            @if(session()->has('success'))
                <x-alert type="success" :message="session()->get('success')" class="mt-4"/>
            @endif
            @if(session()->has('danger'))
                <x-alert type="danger" :message="session()->get('danger')" class="mt-4"/>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert :message="$error" :type="'danger'"/>
                @endforeach
            @endif
            @yield('content')
        </div>
    </main>
    <!-- Scripts -->
    @vite(['resources/ts/admin.ts', ...(empty($pageVars['assets']['js']) ? [] : $pageVars['assets']['js'])])
    @yield('scripts')
</body>

</html>
