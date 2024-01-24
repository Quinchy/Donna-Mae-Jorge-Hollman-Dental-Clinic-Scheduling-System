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
                <p class="information-title">Appointment ID: <span class="content">{{ $history->appointment_id }}</span></p>
                <p class="information-title">Patient Name: <span class="content">{{ $history->user->userInformation->first_name }}</span></p>
                <p class="information-title">Schedule: <span class="content">{{ $history->scheduleDate->appointment_date }} {{ date('g:i A', strtotime($history->scheduleDate->timeSlot->time_slot)) }}</span></p>
                <p class="information-title">Service: <span class="content">{{ $history->service->name }}</span></p>
                <p class="information-title">Status: <span class="content1 {{ $history->status == 'Cancelled' ? 'cancelled' : ($history->status == 'Done' ? 'done' : '') }}">{{ $history->status}}</span></p>
            </div>
            <div class="buttons-container">
                <form action="{{ route('admin.appointment-history.delete', $history->id) }}" method="POST">
                    @csrf
                    <button class="delete-button">Delete</button>
                </form>
                <button class="view-button" onclick="showModal({{ $history->id }})">More Details</button>
            </div>
        </div>
        @empty
            <p class="no-appointments">You have no history of Appointments.</p>
        @endforelse
    </div>
    @if ($appointmentHistory->total() > 4)
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
                    <button type="button" class="close" onclick="closeModal()">&times;</button>
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
        // Build HTML content with the appointment details
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