@extends('user.layouts.main')
@section('content')
<div class="main-container">
    <h1 class="account-page-title">My Account</h1>
    <div class="link-container">
        <a class="account-link" href="{{ route('account')}}">Account</a>
        <a class="appointment-link" href="{{ route('load-appointment')}}">Appointment</a>
    </div>
    <form action="{{ route('account.save') }}" method="POST">
        @csrf
        <div class="account-card-container">
            <h1 class="account-title">Account Information</h1>
            @if($errors->any())
                <div class="warning-text">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span><br>
                    @endforeach
                </div>
            @endif
            <div class="information-container">
                <div class="input-container">
                    <label class="input-label" for="first_name">First Name</label>
                    <input class="text-input" type="text" name="first_name" id="first_name" value="{{ $user->userInformation->first_name ?? '' }}">
                </div>
                <div class="input-container">
                    <label class="input-label" for="last_name">Last Name</label>
                    <input class="text-input" type="text" name="last_name" id="last_name" value="{{ $user->userInformation->last_name ?? '' }}">
                </div>
                <div class="input-container">
                    <label class="input-label" for="email">Email</label>
                    <input class="text-input" type="text" name="email" id="email" value="{{ $user->email }}">
                </div>
                <div class="phone-input-container">
                    <label class="phone-input-label" for="phone_number">Phone Number</label>
                    <input class="phone-text-input" type="text" name="phone_number" id="phone_number" value="{{ $user->userInformation->phone_number ?? '' }}">
                </div>
            </div>
            <div class="save-container">
                <button type="submit" class="save-button">Save</button>
            </div>
        </div>
    </form>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-button">
            <img src="{{ asset('img/Sign_out.svg')}}" alt="">Log Out
        </button>
    </form>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/user/my-account.css') }}">
@endsection