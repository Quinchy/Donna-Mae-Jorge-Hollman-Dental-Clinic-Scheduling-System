@extends('layouts.main')
@section('content')
<div class="main-container">
    <div class="appointment-card-container">
        <img src="{{ asset('img/CheckMarkDone.svg')}}" alt="">
        <div class="booking-success-heading-container">
            <h1 class="booking-success-title">BOOKING COMPLETE</h1>
            <p class="booking-success-description">Thank you for booking your dental appointment! Please note that your booking is currently pending confirmation. We'll notify you once it's accepted. You can view your appointment details in your account.</p>
        </div>
        <a class="go-appointments-link" href="{{ route('load-appointment')}}">Check Appointment</a>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/book-appointment-success.css') }}">
@endsection