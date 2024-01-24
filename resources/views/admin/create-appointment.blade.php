@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <div class="heading-container">
        <h1 class="title">Create Appointment</h1>
    </div>
    <div class="create-appointment-main-container">
        <form class="create-appointment-container" action="{{ url('/admin/submit-created-appointment') }}" method="POST">
            @csrf
            <input type="hidden" name="appointment_date" id="appointmentDate">
            <input type="hidden" name="appointment_service" id="appointmentService">
            <div class="personal-information-section-container">
                <div class="title-warning-container">
                    <h1 class="personal-info-title">Personal Information</h1>
                    @if($errors->any())
                    <div class="alert-warning">
                        <ul class="warning-sign">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="personal-info-input-container">
                    <div class="personal-input-container">
                        <input placeholder="First Name" class="personal-info-input" type="text" name="first_name" id="firstName">
                        <input placeholder="Last Name" class="personal-info-input" type="text" name="last_name" id="lastName">
                    </div>
                    <div class="personal-input-container">
                        <input placeholder="Email" class="personal-info-input" type="text" name="email" id="email">
                        <input placeholder="Contact Number" class="personal-info-input" type="text" name="contact_number" id="contactNumber">
                    </div>
                </div>
            </div>
            <div class="schedule-service-container">
                <div class="schedule-time-section-container">
                    <h1 class="schedule-time-title">Schedule Date and Timeslot</h1>
                    <div class="scheduler-container">
                        <div class="calendar">
                            <input type="text" id="calendarInline" class="flatpickr-calendar animate inline" placeholder="Select Date">
                        </div>
                        <div class="schedule-list">
                            <h1 class="schedule-title">Available Schedule</h1>
                            <div class="time-slot-container">
                                <ul class="custom-radio">
                                    <p class="placeholder-text">Please pick a date.</p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="service-section-container">
                    <h1 class="service-title">Service</h1>
                    <div class="service-container">
                        <div class="setting-description">
                            <div class="setting-description-text" style="margin-left: 15px">
                                <h1 class="description">SERVICES</h1>
                            </div>
                        </div>
                        <div class="wrapper-dropdown" id="dropdown">
                            <span class="selected-display" id="destination">Pick a service!</span>
                            <svg class="arrow" id="drp-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-all ml-auto rotate-180">
                                <path d="M7 14.5l5-5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <ul class="dropdown">
                                <li class="item">Check-Up</li>
                                <li class="item">Cleaning</li>
                                <li class="item">Surgery</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <button class="create-appointment-button" type="submit">Create Appointment</button>
        </form>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/create-appointment.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lib/flatpickr.css')}}">
@endsection
@section('js')
<script src="{{ asset('js/lib/flatpickr.min.js')}}"></script>
<script src="{{ asset('js/custom-dropdown.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var enableDates = @json($dates->pluck('appointment_date')).map(date => new Date(date));
        flatpickr("#calendarInline", {
            inline: true,
            monthSelectorType: 'static',
            yearSelectorType: 'static',
            minDate: "today",
            enable: enableDates,
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('appointmentDate').value = dateStr;
                submitDate(dateStr);
            }
        });
        function submitDate(dateStr) {
            const endpoint = 'create-appointment/fetch-appointment-time-slots';
            const data = { date: dateStr };
            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                updateRadioButtons(data.availableTimeSlots, data.bookedTimeSlots);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
        function updateRadioButtons(availableTimeSlots, bookedTimeSlots) {
            const ul = document.querySelector('.custom-radio');
            ul.innerHTML = ''; 
            availableTimeSlots.forEach((time, index) => {
                const li = document.createElement('li');
                li.className = 'slot';
                li.innerHTML = `
                    <input type="radio" name="time_slot" value="${time}" id="available${index}" />
                    <label for="available${index}">${time}</label>
                `;
                ul.appendChild(li);
            });
            bookedTimeSlots.forEach((time, index) => {
                const li = document.createElement('li');
                li.className = 'slot booked'; 
                li.innerHTML = `
                    <input type="radio" name="time_slot" value="${time}" id="booked${index}" disabled />
                    <label for="booked${index}" class="booked">${time}</label>
                `;
                ul.appendChild(li);
            });
        }
    });
    document.querySelectorAll('.dropdown .item').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('destination').textContent = this.textContent;
            document.getElementById('appointmentService').value = this.textContent;
        });
    });
</script>
@endsection