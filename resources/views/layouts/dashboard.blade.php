<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body class="antialiased">
    <div class="wrapper">
        @include('includes.dashboard.topbar')
        @include('includes.dashboard.leftsidebar')
        <div class="main-panel">
            @yield('content')
            @include('includes.dashboard.footbar')
        </div>
    </div>
    @include('includes.footer')
</body>

</html>
