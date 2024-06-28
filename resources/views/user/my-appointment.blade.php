@extends('user.layouts.main')

@section('content')
<div class="main-container">
    <h1 class="account-page-title">Appointment</h1>
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
                <div class="no-appointment-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="gray" class="bi bi-calendar-x" viewBox="0 0 16 16">
                        <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                    </svg>
                    <p class="my-appointment-subtitle-no-appointment">You have no appointment.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/my-appointment.css') }}">
@endsection