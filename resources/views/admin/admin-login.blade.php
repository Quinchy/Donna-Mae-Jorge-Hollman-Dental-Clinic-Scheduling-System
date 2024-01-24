<head>
    <title>Donna Mae Jorge-Hollman Dental Clinic</title>
    <link rel="stylesheet" href="{{ asset('css/admin/admin-login.css')}}">
    <link rel="icon" href="{{ asset('img/Website-Logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    @yield('css')
</head>
<div class="main-container">
    <div class="logo-container">
        <img src="{{ asset('img/Logo.svg')}}" alt="">
        <p class="logo-title">Donna Mae Jorge-Hollman Dental Clinic</p>
    </div>
    <div class="admin-login-container">
        <div class="heading-container">
            <h1 class="heading-title">Admin Login</h1>
            <p class="heading-subtitle">Please enter your credentials to access the admin panel.</p>
        </div>
        <form class="input-container" method="POST" action="{{ route('admin.admin-login')}}">
            @csrf
            <div class="input-field">
                <label for="email">Email</label>
                <input class="email" type="email" name="email" id="email" placeholder="Enter your email">
            </div>
            <div class="input-field">
                <label for="password">Password</label>
                <input class="password" type="password" name="password" id="password" placeholder="Enter your password">
            </div>
            <button class="login-button" type="submit">Login</button>
        </form>
    </div>
    <img class="image-background" src="{{asset('img/Website-Image-Background.webp')}}" alt="">
</div>