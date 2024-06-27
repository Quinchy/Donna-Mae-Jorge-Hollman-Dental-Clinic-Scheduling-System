@extends('user.layouts.main')
@section('content')
<div class="main-container">
    <h1 class="appointment-page-title">Book an Appointment</h1>
    <form action="{{ url('/submit-appointment') }}" method="POST" id="myForm">
        @csrf
        <input type="hidden" name="appointment_date" id="appointmentDate">
        <input type="hidden" name="appointment_service" id="appointmentService">
        <div class="appointment-card-container">
            <div class="appointment-date-section">
                @if($errors->any())
                    <p class="warning-text">
                        {{ $errors->first()}}
                    </p>
                @endif        
                <h1 class="appointment-date-title">Appointment Date</h1>
                <p class="appointment-date-subtitle">Please select your preferred schedule of appointment.</p>
                <div class="scheduler-container">
                    <div class="calendar">
                        <input type="text" id="calendarInline" class="flatpickr-calendar animate inline" placeholder="Select Date">
                    </div>
                    <div class="schedule-list">
                        <h1 class="schedule-title">Available Time Slot</h1>
                        <div class="time-slot-container">
                            <ul class="custom-radio">
                                <p class="placeholder-text">Please pick a date.</p>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="appointment-service-section">
                <h1 class="appointment-service-title">Dental Services</h1>
                <p class="appointment-service-subtitle">Please select the type of dental service you want. <a class="service-link" href="{{ route('service')}}#service-section" target="_blank">View Services</a></p>
                <div class="time-slot-adder-container">
                    <div class="container">
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
            <div class="submit-container">
                <button class="submit-button">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/user/book-appointment.css') }}">
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
            const endpoint = '/fetch-appointment-time-slots';
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