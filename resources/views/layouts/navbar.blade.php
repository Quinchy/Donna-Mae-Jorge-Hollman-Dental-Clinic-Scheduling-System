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
        <a href="{{ route('index') }}" class="nav-link" {{ Request::routeIs('index') ? 'style=text-decoration:underline;' : '' }}>
            <img class="logo" src="{{ asset('img/Website-Logo.png') }}" />
        </a>
    </div>
</nav>
<div class="sidebar" id="sidebar">
    <button class="close-sidebar">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24">
            <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
        </svg>
    </button>
    <ul class="sidebar-navigations">
        <li>
            <a class="sidebar-navigation-link-container" href="{{ route('index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                </svg>
                HOME
            </a>
        </li>
        <li>
            <a class="sidebar-navigation-link-container" href="{{ route('about') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                ABOUT
            </a>
        </li>
        <li>
            <a class="sidebar-navigation-link-container" href="{{ route('service') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                </svg>
                SERVICE
            </a>
        </li>
        <li>
            <a class="sidebar-navigation-link-container" href="{{ route('contact') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                </svg>
                CONTACT
            </a>
        </li>
        @if(Auth::check())
            <li>
                <a class="sidebar-navigation-link-container" href="{{ route('account') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    </svg>
                    ACCOUNT
                </a>
            </li>
        @else
            <li>
                <a class="sidebar-navigation-link-container" href="{{ route('login') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    LOGIN
                </a>
            </li>
        @endif
    </ul>
</div>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.sidebar-button').click(function() {
        $('#sidebar').toggleClass('active');
    });
    $('.close-sidebar').click(function() {
        $('#sidebar').removeClass('active');
    });
    $('#sidebar ul li a').click(function() {
        $('#sidebar').removeClass('active');
    });
});
</script>
