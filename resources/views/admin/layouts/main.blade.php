<!DOCTYPE html>
<html>
    <head>
        <title>Donna Mae Jorge-Hollman Dental Clinic</title>
        <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/Website-Logo.png') }}" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        @include('admin.layouts.sidenavbar')
        <div class="container">
            @yield('content')
        </div>
        @yield('js')
    </body>
</html>
