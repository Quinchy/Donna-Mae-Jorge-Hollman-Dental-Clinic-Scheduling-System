@extends('user.layouts.main')

@section('content')
<div class="main-container">
    <div class="login-container">
        <div class="login-heading-container">
            <h1 class="login-title">LOGIN</h1>
            <p class="login-description">Are you new to our Dental Clinic? <a class="register-link" href="{{ route('register.step1') }}">Create an Account</a></p>
        </div>
        <div class="login-section-container">
            <form class="login-form-container" method="POST" action="{{ route('login.post')}}">
                @csrf
                @if($errors->any())
                    <div class="warning-text">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="email-container">
                    <label class="email-title" for="email">Email</label>
                    <input class="email-textfield" id="email" type="email" name="email" placeholder="Email" required>
                </div>
                <div class="password-container">
                    <label class="password-title" for="password">Password</label>
                    <input class="password-textfield" id="password" type="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                        <img src="{{ asset('img/Eye-Open.svg') }}" alt="Eye Open" class="eye-open">
                        <img src="{{ asset('img/Eye-Closed.svg') }}" alt="Eye Closed" class="eye-closed">
                    </span>
                </div>
                <button class="login-button" type="submit">Login</button>
            </form>
            <div class="separator-container">
                <div class="line"></div>
                <p class="separator-text">or continue with</p>
                <div class="line"></div>
            </div>
            <a class="google-button" href="{{ route('google.login') }}">
                <div class="google-logo-container">
                    <img class="google-logo normal" src="{{ asset('img/Google.svg') }}" alt="Google Logo">
                    <img class="google-logo highlighted" src="{{ asset('img/Google-Highlighted.svg') }}" alt="Google Highlighted Logo">
                </div>
                <p class="google-logo-text">Google</p>
            </a>
        </div>
    </div>
</div>

@endsection
@section('css')
    <link href="{{ asset('css/user/login.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('js/user/login.js') }}"></script>
@endsection