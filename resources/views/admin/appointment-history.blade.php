@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <div class="heading-container">
        <h1 class="title">Appointment History</h1>
        <form class="search-container" method="GET" action="{{ route('admin.appointment-history') }}">
            <input type="text" name="search" id="search-bar" placeholder="Search appointment history...">
            <button type="submit" class="search-button"><img class="search-icon" src="{{ asset('img/Search.svg')}}"></button>
        </form>
    </div>
    <div class="appointment-cards-container">
        @forelse ($appointmentHistory as $history)
        <div class="appointment-card">
            <div class="information">
                <div>
                    <p class="information-title">Appointment ID:</p>
                    <span class="content">{{ $history->appointment_id }}</span>
                </div>
                <div>
                    <p class="information-title">Patient Name:</p>
                    <span class="content">{{ $history->user->userInformation->first_name }} {{ $history->user->userInformation->last_name }}</span>
                </div>
                <div>
                    <p class="information-title">Schedule:</p>
                    <span class="content">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $history->scheduleDate->appointment_date)->format('F j, Y') }} at {{ date('g:i A', strtotime($history->scheduleDate->timeSlot->time_slot)) }}</span>
                </div>
                <div>
                    <p class="information-title">Service:</p>
                    <span class="content">{{ $history->service->name }}</span>
                </div>
                <div>
                    <p class="information-title">Status:</p>
                    <span class="content1 {{ $history->status == 'Cancelled' ? 'cancelled' : ($history->status == 'Done' ? 'done' : '') }}">{{ $history->status}}</span>
                </div>
            </div>
            <div class="buttons-container">
                <button class="view-button" onclick="showModal({{ $history->id }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg> 
                </button>
                <form action="{{ route('admin.appointment-history.delete', $history->id) }}" method="POST">
                    @csrf
                    <button class="delete-button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                        </svg>                          
                    </button>
                </form>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no history of Appointments.</p>
        @endforelse
    </div>
    @if ($appointmentHistory->total() > 7)
    <div class="pagination-container">
        <p class="page-indicator">Page {{ $appointmentHistory->currentPage() }} of {{ $appointmentHistory->lastPage() }}</p>
        <div class="pagination-button-container">
            {{ $appointmentHistory->links('admin.layouts.pagination') }}
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
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/appointment-history.css') }}" rel="stylesheet">
@endsection
@section('js')
<script>
function showModal(appointmentId) {
    // AJAX request to get the appointment details using GET
    fetch('/admin/appointment-history/view-details/' + appointmentId)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();  // Process the response as JSON
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
function convertTimeTo12Hour(time24) {
    const timeParts = time24.split(':');
    const hours = parseInt(timeParts[0], 10);
    const minutes = timeParts[1];
    const ampm = hours >= 12 ? 'PM' : 'AM';
    const formattedHours = hours % 12 || 12;  // Converts "0" to "12"
    
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
window.onkeydown = function(event) {
    if (event.key === "Escape") {
        closeModal();
    }
}
</script>
@endsection