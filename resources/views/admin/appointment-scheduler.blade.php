@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <h1 class="title">Appointment Scheduler</h1>
    <div class="appointment-preview-schedule-container">
        <div class="appointment-calendar-preview-container">
            <h1 class="scheduler-title">Preview</h1>
            <input type="hidden" name="appointment_date" id="appointmentDate">
            <div class="scheduler-container">
                <div class="calendar">
                    <input type="text" id="calendarInline2" class="flatpickr-calendar animate inline" placeholder="Select Date">
                </div>
                <div class="schedule-list">
                    <h1 class="schedule-title">Available Schedule</h1>
                    <div class="time-slot-container2">
                        <ul class="custom-radio">
                            <p class="placeholder-text">Please pick a date.</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="appointment-scheduler-container">
            <div class="title-warning-container">
                <h1 class="scheduler-title">Scheduler</h1>
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
            <form action="{{ url('/admin/add-time-slot') }}" method="POST" id="myForm">
                @csrf 
                <input type="hidden" name="date" id="hiddenDate">
                <input type="hidden" name="time" id="hiddenTime">
                <div class="scheduler-container">
                    <div class="calendar">
                        <input type="text" id="calendarInline" class="flatpickr-calendar animate inline" placeholder="Select Date">
                    </div>
                    <div class="add-time-slot-container">
                        <h1 class="available-time-slot-title">Time Slot Available:</h1>
                        <div class="time-slot-container">
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="time-slot-title">Add Time Slot:</h1>
                    <div class="time-slot-adder-container">
                        <fieldset class="timeslot-selection-container">
                            <label class="control">
                                <input type="checkbox" name="time[]" value="8:00 AM">
                                <span class="timeslot">
                                    &nbsp;8:00 AM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="9:00 AM">
                                <span class="timeslot">
                                    &nbsp;9:00 AM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="10:00 AM">
                                <span class="timeslot">
                                    10:00 AM
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="11:00 AM">
                                <span class="timeslot">
                                    11:00 AM
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="12:00 PM">
                                <span class="timeslot">
                                    12:00 PM
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="1:00 PM">
                                <span class="timeslot">
                                    &nbsp;1:00 PM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="2:00 PM">
                                <span class="timeslot">
                                    &nbsp;2:00 PM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="3:00 PM">
                                <span class="timeslot">
                                    &nbsp;3:00 PM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="4:00 PM">
                                <span class="timeslot">
                                    &nbsp;4:00 PM&nbsp;
                                </span>
                            </label>
                            <label class="control">
                                <input type="checkbox" name="time[]" value="5:00 PM">
                                <span class="timeslot">
                                    &nbsp;5:00 PM&nbsp;
                                </span>
                            </label>
                        </fieldset>
                        <button type="submit" class="add-button">+ Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/appointment-scheduler.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lib/flatpickr.css')}}">
@endsection
@section('js')
<script src="{{ asset('js/lib/flatpickr.min.js')}}"></script>
<script src="{{ asset('js/custom-dropdown.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var enableDates = @json($dates->pluck('appointment_date')).map(date => new Date(date));
        flatpickr("#calendarInline2", {
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
            const endpoint = 'appointment-scheduler/fetch-appointment-time-slots';
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
                li.className = 'slot2';
                li.innerHTML = `
                    <input type="radio" name="time_slot" value="${time}" id="available${index}" />
                    <label for="available${index}">${time}</label>
                `;
                ul.appendChild(li);
            });
            bookedTimeSlots.forEach((time, index) => {
                const li = document.createElement('li');
                li.className = 'slot2 booked'; 
                li.innerHTML = `
                    <input type="radio" name="time_slot" value="${time}" id="booked${index}" disabled />
                    <label for="booked${index}" class="booked">${time}</label>
                `;
                ul.appendChild(li);
            });
        }
    });
    flatpickr("#calendarInline", {
        inline: true,
        monthSelectorType: 'static',
        yearSelectorType: 'static',
        minDate: 'today',
        onChange: function(selectedDates, dateStr, instance) {
            document.getElementById('hiddenDate').value = dateStr;
            fetch('{{ url('/admin/fetch-time-slot') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ date: dateStr })
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.time-slot-container').innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
        },
    });
    function updateTimeSlot(selectedTime) {
        document.getElementById('hiddenTime').value = selectedTime;
    }
    function deleteTimeSlot(scheduleDateId, buttonElement) {
        if (confirm('Are you sure you want to delete this time slot?')) {
            fetch('{{ url('/admin/delete-time-slot') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ scheduleDateId: scheduleDateId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    buttonElement.closest('.time-slot').remove();
                } else {
                    alert('Failed to delete time slot.');
                }
            })
        }
    }
    document.querySelectorAll('.wrapper-dropdown .item').forEach(item => {
        item.addEventListener('click', function() {
            updateTimeSlot(this.innerText);
        });
    });
</script>
@endsection