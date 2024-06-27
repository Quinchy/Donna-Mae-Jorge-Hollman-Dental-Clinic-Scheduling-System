<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Donna Mae Jorge-Hollman Dental Clinic</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/lib/aos.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/Website-Logo.png') }}" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        @include('user.layouts.background')
        @include('user.layouts.navbar')
        <div class="wholepage-container">
            @yield('content')
        </div>
        @include('user.layouts.footer')
        @yield('js')
    </body>
</html>