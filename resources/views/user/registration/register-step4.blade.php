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
        <img src="{{ asset('img/CheckMarkDone.svg')}}" alt="">
        <div class="register-heading-container">
            <h1 class="register-title">REGISTRATION COMPLETE</h1>
            <p class="register-description">Thank you for providing your information. Your registration is now complete. You can proceed to schedule your dental appointment at your convenience.</p>
        </div>
        <div class="button-container">
            <a class="book-appointment-button" href="{{ route('book-appointment')}}">Book an Appointment</a>
            <a class="go-home-link" href="{{ route('index')}}">Go Home</a>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="{{ asset('css/user/registration/register4.css') }}" rel="stylesheet">
@endsection
