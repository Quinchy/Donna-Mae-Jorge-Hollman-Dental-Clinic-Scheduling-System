<nav class="navbar">
    <ul class="navigation-left">
        <li>
            <a href="https://www.facebook.com/profile.php?id=100076185674873" target="_blank">
                <svg width="35" height="35" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M35 70C54.33 70 70 54.33 70 35C70 15.67 54.33 0 35 0C15.67 0 0 15.67 0 35C0 52.2507 12.4802 66.5865 28.9042 69.471V45.7039H20V35.8252H28.9042V28.2961C28.9042 19.7323 34.1371 15 42.1507 15C45.9863 15 50 15.6675 50 15.6675V24.0777H45.5754C41.2192 24.0777 39.863 26.7143 39.863 29.4175V35.8252H49.589L48.0343 45.7039H39.863V69.5862C38.175 69.8446 36.4503 69.984 34.6947 69.9987C34.7964 69.9996 34.8981 70 35 70Z" fill="white"/>
                </svg>                
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