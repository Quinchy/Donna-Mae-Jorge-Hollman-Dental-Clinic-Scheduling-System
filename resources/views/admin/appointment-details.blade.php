<p>Appointment ID: {{ $appointment->appointment_id }}</p>
<p>Patient Name: {{ $appointment->user->userInformation->first_name }} {{ $appointment->user->userInformation->last_name }}</p>
<p>Schedule: {{ $appointment->scheduleDate->appointment_date->format('F d, Y') }} {{ date('g:i A', strtotime($appointment->scheduleDate->timeSlot->time_slot)) }}</p>
<p>Service: {{ $appointment->service->name }}</p>
<p>Phone Number: {{ $appointment->user->userInformation->phone_number }}</p>
<p>Email: {{ $appointment->user->email }}</p>
<p>Status: <span class="{{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></p>
@section('css')
<link href="{{ asset('css/admin/appointment-manager.css') }}" rel="stylesheet">
@endsection