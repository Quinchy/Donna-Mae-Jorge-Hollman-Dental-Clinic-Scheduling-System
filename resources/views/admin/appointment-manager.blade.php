@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <div class="heading-container">
        <h1 class="title">Appointment List</h1>
        <form class="search-container" method="GET" action="{{ route('admin.appointment-manager') }}">
            <input type="text" name="search" id="search-bar" placeholder="Search appointment...">
            <button type="submit" class="search-button"><img class="search-icon" src="{{ asset('img/Search.svg')}}"></button>
        </form>
    </div>
    <div class="appointment-cards-container">
        @forelse ($appointmentList as $list)
        <div class="appointment-card">
            <div class="information">
                <p class="information-title">Appointment ID: <span class="content">{{ $list->appointment_id }}</span></p>
                <p class="information-title">Patient Name: <span class="content">{{ $list->user->userInformation->first_name }} {{ $list->user->userInformation->last_name }}</span></p>
                <p class="information-title">Schedule: <span class="content">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $list->scheduleDate->appointment_date)->format('F j, Y') }} at {{ date('g:i A', strtotime($list->scheduleDate->timeSlot->time_slot)) }}</span></p>
                <p class="information-title">Service: <span class="content">{{ $list->service->name }}</span></p>
                <p class="information-title">Status: <span class="content1">{{ $list->status}}</span></p>
            </div>
            <div class="buttons-container">
                <form action="{{ route('admin.appointment-manager.done', $list->id) }}" method="POST">
                    @csrf
                    <button class="done-button">Done</button>
                </form>
                <button class="reschedule-button" onclick="showRescheduleModal('{{ $list->id }}', '{{ \Carbon\Carbon::createFromFormat('Y-m-d', $list->scheduleDate->appointment_date)->format('F j, Y') }}', '{{ date('g:i A', strtotime($list->scheduleDate->timeSlot->time_slot)) }}')">Reschedule</button>
                <form action="{{ route('admin.appointment-manager.cancel', $list->id) }}" method="POST">
                    @csrf
                    <button class="cancel-button">Cancel</button>
                </form>
                <button class="view-button" onclick="showViewModal({{ $list->id }})">More Details</button>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no Appointments.</p>
        @endforelse
    </div>
    @if ($appointmentList->total() > 4)
        <div class="pagination-container">
            <p class="page-indicator">Page {{ $appointmentList->currentPage() }} of {{ $appointmentList->lastPage() }}</p>
            <div class="pagination-button-container">
                {{ $appointmentList->links('admin.layouts.pagination') }}
            </div>
        </div>
    @endif
    <div id="appointmentDetailsModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
                    <button type="button" class="close" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.appointment-manager.submitReschedule')}}" method="POST" id="rescheduleForm">
        @csrf
        <input type="hidden" name="appointment_id" id="appointmentId">
        <input type="hidden" name="time_slot_id" id="timeSlotId">
        <input type="hidden" name="appointment_date" id="appointmentDate">
        <div id="appointmentRescheduleModal" class="reschedule-modal">
            <div class="reschedule-modal-container">
                <div class="reschedule-header-modal">
                    <div class="reschedule-modal-titles-container">
                        <h1 class="reschedule-modal-title">Appointment Reschedule</h1>
                    </div>
                    <button type="button" class="close" onclick="closeRescheduleModal()">&times;</button>
                </div>
                <div class="current-schedule-container">
                    <h1 class="current-schedule-date-title">Current Appointment Date: </h1>
                    <p class="current-schedule-date"></p>
                </div>
                <div class="rescheduler-container">
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
                <div class="button-container">
                    <button type="submit" class="reschedule-button-modal">Reschedule</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('css')
<link href="{{ asset('css/admin/appointment-manager.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/lib/flatpickr.css')}}">
@endsection
@section('js')
<script src="{{ asset('js/lib/flatpickr.min.js')}}"></script>
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
            const endpoint = '/admin/appointment-manager/fetch-appointment-time-slots';
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
                li.querySelector('input[type=radio]').addEventListener('click', function() {
                    document.getElementById('timeSlotId').value = convertTo24HourFormat(this.value);
                });
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
            function convertTo24HourFormat(time12h) {
                const [time, modifier] = time12h.split(' ');
                let [hours, minutes] = time.split(':');
                if (hours === '12') {
                    hours = '00';
                }
                if (modifier === 'PM') {
                    hours = parseInt(hours, 10) + 12;
                }
                return `${hours}:${minutes}:00`;
            }
        }
    });
    function showViewModal(appointmentId) {
        fetch('/admin/appointment-manager/view-details/' + appointmentId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const appointment = data.appointment;
            const userInformation = data.userInformation;
            const schedule = data.schedule;
            const timeSlot = convertTimeTo12Hour(data.timeSlot);
            const detailsHtml = `
                <p>Appointment ID: ${appointment.appointment_id}</p>
                <p>Patient Name: ${userInformation.first_name} ${userInformation.last_name || ""}</p>
                <p>Schedule: ${schedule} ${timeSlot}</p>
                <p>Phone Number: ${userInformation.phone_number || ""}</p>
                <p>Service: ${appointment.service.name}</p>
                <p>Email: ${appointment.user.email}</p>
                <p>Status: <span class="${appointment.status.toLowerCase()}">${appointment.status}</span></p>
            `;
            document.querySelector('#appointmentDetailsModal .modal-body').innerHTML = detailsHtml;
            document.getElementById('appointmentDetailsModal').style.display = 'block';
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
    }
    function showRescheduleModal(appointmentId, formattedDate, formattedTime) {
        document.getElementById('appointmentId').value = appointmentId;
        document.getElementById('appointmentRescheduleModal').style.display = 'block';
        // Update the modal with the appointment's date and time
        document.querySelector('.current-schedule-date').textContent = `${formattedDate} at ${formattedTime}`;
    }
    function convertTimeTo12Hour(time24) {
        const timeParts = time24.split(':');
        const hours = parseInt(timeParts[0], 10);
        const minutes = timeParts[1];
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        
        return `${formattedHours}:${minutes} ${ampm}`;
    }
    function closeModal() {
        document.getElementById('appointmentDetailsModal').style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target == document.getElementById('appointmentDetailsModal')) {
            closeModal();
        }
    }
    function closeRescheduleModal() {
        document.getElementById('appointmentRescheduleModal').style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target == document.getElementById('appointmentRescheduleModal')) {
            closeModal();
        }
    }
    window.onkeydown = function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    }
    window.onkeydown = function(event) {
        if (event.key === "Escape") {
            closeRescheduleModal();
        }
    }
</script>
@endsection