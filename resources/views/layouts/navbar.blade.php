<nav class="navbar">
    <ul class="navigation-left">
        <li>
            <a href="https://www.facebook.com/profile.php?id=100076185674873" target="_blank">
                <img class="facebook-logo" src="{{ asset('img/facebook-logo.svg') }}" />
            </a>
        </li>
        <li>
            <a href="{{ route('index') }}" class="nav-link" {{ Request::routeIs('index') ? 'style=text-decoration:underline;' : '' }}>Home</a>
        </li>
        @if(Auth::check())
            <li>
                <a href="{{ route('account') }}" class="nav-link" {{ Request::routeIs('account') || Request::routeIs('my-appointment') ? 'style=text-decoration:underline;' : '' }}>Account</a>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}" class="nav-link" {{ Request::routeIs('login') ? 'style=text-decoration:underline;' : '' }}>Login</a>
            </li>
        @endif
    </ul>
    <div class="website-logo">
        <img class="logo" src="{{ asset('img/Website-Logo.png') }}" />
        <p class="title">Donna Mae Jorge-Hollman Dental Clinic</p>
    </div>
    <ul class="navigation-right">
        <li>
            <a href="{{ route('about') }}" class="nav-link" {{ Request::routeIs('about') ? 'style=text-decoration:underline;' : '' }}>About</a>
        </li>
        <li>
            <a href="{{ route('service') }}" class="nav-link" {{ Request::routeIs('service') ? 'style=text-decoration:underline;' : '' }}>Service</a>
        </li>
        <li class="{{ Request::routeIs('contact') ? 'active' : '' }}">
            <a href="{{ route('contact') }}" class="nav-link" {{ Request::routeIs('contact') ? 'style=text-decoration:underline;' : '' }}>Contact</a>
        </li>
    </ul>
</nav>
<nav class="mobile-navbar">
    <button class="sidebar-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M7.5 10.5H28.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M7.5 18H28.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M7.5 25.5H28.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
    <div class="website-logo">
        <img class="logo" src="{{ asset('img/Website-Logo.png') }}" />
        <p class="title">Donna Mae Jorge-Hollman Dental Clinic</p>
    </div>
</nav>