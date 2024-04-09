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
                <div>
                    <p class="information-title">Appointment ID:</p>
                    <span class="content">{{ $list->appointment_id }}</span>
                </div>
                <div>
                    <p class="information-title">Patient Name:</p>
                    <span class="content">{{ $list->user->userInformation->first_name }} {{ $list->user->userInformation->last_name }}</span>
                </div>
                <div>
                    <p class="information-title">Schedule:</p>
                    <span class="content">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $list->scheduleDate->appointment_date)->format('F j, Y') }} at {{ date('g:i A', strtotime($list->scheduleDate->timeSlot->time_slot)) }}</span>
                </div>
                <div>
                    <p class="information-title">Service:</p>
                    <span class="content">{{ $list->service->name }}</span>
                </div>
                <div>
                    <p class="information-title">Status:</p>
                    <span class="content1">{{ $list->status }}</span>
                </div>
            </div>
            <div class="buttons-container">
                <form action="{{ route('admin.appointment-manager.done', $list->id) }}" method="POST">
                    @csrf
                    <button class="done-button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                        </svg>   
                        Done
                    </button>
                </form>
                <button onclick="showRescheduleModal('{{ $list->id }}', '{{ \Carbon\Carbon::createFromFormat('Y-m-d', $list->scheduleDate->appointment_date)->format('F j, Y') }}', '{{ date('g:i A', strtotime($list->scheduleDate->timeSlot->time_slot)) }}')" class="reschedule-button">
                    <div class="button-icon">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>                    
                    Reschedule
                </button>
                <form action="{{ route('admin.appointment-manager.cancel', $list->id) }}" method="POST">
                    @csrf
                    <button class="cancel-button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>     
                        Cancel
                    </button>
                </form>
                <button class="view-button" onclick="showViewModal({{ $list->id }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>                                         
                </button>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no Appointments.</p>
        @endforelse
    </div>
    @if ($appointmentList->total() > 7)
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
                    <button type="button" class="close" onclick="closeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>
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
                    <button type="button" class="close" onclick="closeRescheduleModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>
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
            const scheduleDate = new Date(schedule); // Assuming 'schedule' is in the format 'YYYY-MM-DD'
            const formattedDate = scheduleDate.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            const formattedTimeSlot = timeSlot; // Assuming 'timeSlot' is already in a human-readable format like '8:00 AM'

            const detailsHtml = `
                <div><span class="label-bold">Appointment ID:</span> ${appointment.appointment_id}</div>
                <div><span class="label-bold">Patient Name:</span> ${userInformation.first_name} ${userInformation.last_name || ""}</div>
                <div><span class="label-bold">Schedule:</span> ${formattedDate} at ${formattedTimeSlot}</div>
                <div><span class="label-bold">Phone Number:</span> ${userInformation.phone_number || ""}</div>
                <div><span class="label-bold">Service:</span> ${appointment.service.name}</div>
                <div><span class="label-bold">Email:</span> ${appointment.user.email}</div>
                <div><span class="label-bold">Status:</span> <span class="${appointment.status.toLowerCase()}">${appointment.status}</span></div>
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