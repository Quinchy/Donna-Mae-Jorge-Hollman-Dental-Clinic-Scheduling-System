@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <div class="heading-container">
        <h1 class="title">Appointment Request</h1>
        <form class="search-container" method="GET" action="{{ route('admin.appointment-request-manager') }}">
            <input type="text" name="search" id="search-bar" placeholder="Search appointment request...">
            <button type="submit" class="search-button"><img class="search-icon" src="{{ asset('img/Search.svg')}}"></button>
        </form>
    </div>
    <div class="appointment-cards-container">
        @forelse ($appointmentRequests as $request)
        <div class="appointment-card">
            <div class="information">
                <p class="information-title">Appointment ID: <span class="content">{{ $request->appointment_id }}</span></p>
                <p class="information-title">Patient Name: <span class="content">{{ $request->user->userInformation->first_name }} {{ $request->user->userInformation->last_name }}</span></p>
                <p class="information-title">Schedule: <span class="content">{{ $request->scheduleDate->appointment_date }} {{ date('g:i A', strtotime($request->scheduleDate->timeSlot->time_slot)) }}</span></p>
                <p class="information-title">Service: <span class="content">{{ $request->service->name }}</span></p>
            </div>
            <div class="buttons-container">
                <form action="{{ route('admin.appointment-request-manager.accept', $request->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="accept-button">Accept</button>
                </form>
                <form action="{{ route('admin.appointment-request-manager.decline', $request->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="decline-button">Decline</button>
                </form>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no Appointment Request.</p>
        @endforelse
    </div>
    @if ($appointmentRequests->count() > 4)
        <div class="pagination-container">
            <p class="page-indicator">Page {{ $appointmentRequests->currentPage() }} of {{ $appointmentRequests->lastPage() }}</p>
            <div class="pagination-button-container">
                <button class="previous-button" {{ $appointmentRequests->onFirstPage() ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
                        <path d="M9.5 1L2 8.5L9.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <button class="next-button" {{ $appointmentRequests->hasMorePages() ? '' : 'disabled' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
                        <path d="M1.5 1L9 8.5L1.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/appointment-request-manager.css') }}" rel="stylesheet">
@endsection
