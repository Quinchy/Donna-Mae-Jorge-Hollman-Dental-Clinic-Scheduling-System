@extends('layouts.main')
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
            <h1 class="register-title">PERSONAL DETAILS</h1>
            <p class="register-description">Please provide your personal information below.</p>
        </div>
        <form class="register-form-container" method="POST" action="{{ route('register.step3.post') }}">
            <div class="warning-text">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
            @csrf
            <div class="first-name-container">
                <label class="first-name-title" for="first_name">First Name</label>
                <input class="first-name-textfield" id="first_name" type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="last-name-container">
                <label class="last-name-title" for="last_name">Last Name</label>
                <input class="last-name-textfield" id="last_name" type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="phone-number-container">
                <label class="phone-number-title" for="phone">Phone Number</label>
                <input class="phone-number-textfield" id="phone" type="tel" name="phone" placeholder="Phone Number" required>
            </div>
            <button class="submit-button" type="submit">Submit</button>
        </form>        
    </div>
</div>
@endsection
@section('css')
<link href="{{ asset('css/register3.css') }}" rel="stylesheet">
@endsection