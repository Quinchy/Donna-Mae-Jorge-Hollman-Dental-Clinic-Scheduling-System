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
                <div>
                    <p class="information-title">Appointment ID:</p>
                    <span class="content">{{ $request->appointment_id }}</span>
                </div>
                <div>
                    <p class="information-title">Patient Name:</p>
                    <span class="content">{{ $request->user->userInformation->first_name }} {{ $request->user->userInformation->last_name }}</span>
                </div>
                <div>
                    <p class="information-title">Schedule:</p>
                    <span class="content">{{(new DateTime($request->scheduleDate->appointment_date . ' ' . $request->scheduleDate->timeSlot->time_slot))->format('F j, Y \a\t g:i A') }}</span>
                </div>
                <div>
                    <p class="information-title">Service:</p>
                    <span class="content">{{ $request->service->name }}</span>
                </div>
            </div>
            <div class="buttons-container">
                <form action="{{ route('admin.appointment-request-manager.accept', $request->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="accept-button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                        </svg>                          
                        Accept
                    </button>
                </form>
                <form action="{{ route('admin.appointment-request-manager.decline', $request->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="decline-button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>                          
                        Decline
                    </button>
                </form>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no Appointment Request.</p>
        @endforelse
    </div>
    @if ($appointmentRequests->total() > 7)
        <div class="pagination-container">
            <p class="page-indicator">Page {{ $appointmentRequests->currentPage() }} of {{ $appointmentRequests->lastPage() }}</p>
            <div class="pagination-button-container">
                {{ $appointmentRequests->links('admin.layouts.pagination') }}
            </div>
        </div>
    @endif
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/appointment-request-manager.css') }}" rel="stylesheet">
@endsection
