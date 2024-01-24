@extends('layouts.main')
@section('content')
<div class="main-container">
    <h1 class="account-page-title">My Appointment</h1>
    <div class="link-container">
        <a class="account-link" href="{{ route('account')}}">Account</a>
        <a class="appointment-link" href="{{ route('load-appointment')}}">Appointment</a>
    </div>
    <div class="account-card-container">
        <div class="my-appointment-container">
            <h1 class="my-appointment-title">Appointment Information</h1>
        </div>
        @if ($latestAppointment && $latestAppointment->status === 'Processing')
            <div class="appointment-infos-container">
                <p class="my-appointment-subtitle">Your dental appointment request is now being processed. Please return to this page shortly. Once processed, your appointment details will be present here. Thank you for your patience!</p>
            </div>
            <form action="{{ route('my-appointment.cancel', $latestAppointment->id) }}" method="POST">
                @csrf
                <button class="cancel-button">Cancel</button>
            </form>
        @elseif($latestAppointment && $latestAppointment->status === 'In Progress')
            <div class="appointment-infos-container">
                <div class="appointment-info-container">
                    <p class="appointment-info-title">Patient Name</p>
                    <p class="appointment-info-subtitle">
                        {{ $latestAppointment->user->userInformation->first_name }} {{ $latestAppointment->user->userInformation->last_name }}
                    </p>
                </div>
                <div class="appointment-info-container">
                    <p class="appointment-info-title">Schedule</p>
                    <p class="appointment-info-subtitle">
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $latestAppointment->scheduleDate->appointment_date)->format('F j, Y') }} at {{ date('g:i A', strtotime($latestAppointment->scheduleDate->timeSlot->time_slot)) }}
                    </p>
                </div>
                <div class="appointment-info-container">
                    <p class="appointment-info-title">Dental Service</p>
                    <p class="appointment-info-subtitle">
                        {{ $latestAppointment->service->name }}
                    </p>
                </div>
            </div>
            <div class="appointment-id-container">
                <p class="appointment-id-title">Appointment ID:</p>
                <p class="appointment-id">{{ $latestAppointment->appointment_id }}</p>
            </div>
            <form action="{{ route('my-appointment.cancel', $latestAppointment->id) }}" method="POST">
                @csrf
                <button class="cancel-button">Cancel</button>
            </form>
        @else
            <div class="appointment-infos-container">
                <p class="my-appointment-subtitle">You have no appointment.</p>
            </div>
        @endif
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/my-appointment.css') }}">
@endsection