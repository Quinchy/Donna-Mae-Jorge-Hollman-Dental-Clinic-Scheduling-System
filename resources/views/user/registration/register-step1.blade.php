@extends('user.layouts.main')

@section('content')
<div class="main-container">
    <div class="progress-bar-container">
        <div class="milestone-1"></div>
        <div class="road-1"></div>
        <div class="milestone-2"></div>
        <div class="road-2"></div>
        <div class="milestone-3"></div>
        <div class="road-3"></div>
        <div class="milestone-4"></div>
    </div>
    <div class="register-container">
        <div class="register-heading-container">
            <h1 class="register-title">REGISTER</h1>
            <p class="register-description">Already have an account? <a class="login-link" href="{{ route('login') }}">Login your Account</a></p>
        </div>
        <div class="register-section-container">
            <div class="warning-text">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
            <form class="register-form-container" method="POST" action="{{ route('register.step1.post') }}">
                @csrf
                <div class="email-container">
                    <label class="email-title" for="email">Email</label>
                    <input class="email-textfield" id="email" type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="password-container">
                    <label class="password-title" for="password">Password</label>
                    <input class="password-textfield" id="password" type="password" name="password" placeholder="Password" required>
                    <span class="toggle-password">
                        <img src="{{ asset('img/Eye-Open.svg') }}" alt="Eye Open" class="eye-open">
                        <img src="{{ asset('img/Eye-Closed.svg') }}" alt="Eye Closed" class="eye-closed">
                    </span>
                </div>
                <div class="confirm-password-container">
                    <label class="confirm-password-title" for="password_confirmation">Confirm Password</label>
                    <input class="confirm-password-textfield" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    <span class="toggle-password">
                        <img src="{{ asset('img/Eye-Open.svg') }}" alt="Eye Open" class="eye-open">
                        <img src="{{ asset('img/Eye-Closed.svg') }}" alt="Eye Closed" class="eye-closed">
                    </span>
                </div>
                <button class="next-button" type="submit">Next</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="{{ asset('css/user/registration/register.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('js/user/registration/register.js') }}"></script>
@endsection
