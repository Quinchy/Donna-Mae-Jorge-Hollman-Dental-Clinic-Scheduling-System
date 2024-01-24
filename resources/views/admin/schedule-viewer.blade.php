@extends('admin.layouts.main')
@section('content')
<div class="main-container">
    <div class="calendar-container">
        <div class="calendar-header-container">
            <h1 class="appointment-calendar-title">Appointment Calendar</h1>
            <button class="previous-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 17" fill="none">
                    <path d="M9.5 1L2 8.5L9.5 16" stroke="#0A7F9C" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="date-indicator-container">
                <p class="start-date">January 14, 2024</p>
                <div class="line"></div>
                <p class="end-date">January 20, 2024</p>
            </div>
            <button class="next-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 17" fill="none">
                    <path d="M1.5 1L9 8.5L1.5 16" stroke="#0A7F9C" stroke-width="2" stroke-linecap="round"/>
                </svg> 
            </button>
        </div>
        <div class="weekday-appointment-container" id="my-scrollbar">
            <div class="weekday-container">
                <div class="date-container">
                    <div class="weekday">Sun</div>
                    <div class="week-number">14</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Mon</div>
                    <div class="week-number">15</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Tue</div>
                    <div class="week-number">16</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Wed</div>
                    <div class="week-number">17</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Thu</div>
                    <div class="week-number">18</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Fri</div>
                    <div class="week-number">19</div>
                </div>
                <div class="date-container">
                    <div class="weekday">Sat</div>
                    <div class="week-number">20</div>
                </div>
            </div>
            <div class="appointment-column-container">
                <div class="sunday-appointment-container">
                    <div class="appointment-container">
                        
                    </div>
                </div>
                <div class="monday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
                <div class="tuesday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
                <div class="wednesday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
                <div class="thursday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
                <div class="friday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
                <div class="saturday-appointment-container">
                    <div class="appointment-container">
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="{{ asset('css/admin/schedule-viewer.css') }}" rel="stylesheet">
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let week = getCurrentWeek();
        updateDisplay();
        document.querySelector('.previous-button').addEventListener('click', () => {
            week = updateWeek(week, -1);
            updateDisplay();
        });
        document.querySelector('.next-button').addEventListener('click', () => {
            week = updateWeek(week, 1);
            updateDisplay();
        });
        function getCurrentWeek() {
            let curr = new Date();
            let week = [];
            for (let i = 0; i < 7; i++) {
                let first = curr.getDate() - curr.getDay() + i;
                let day = new Date(curr.setDate(first));
                week.push(day); // Store Date objects in week array
            }
            return week;
        }
        function updateWeek(week, addWeeks) {
            return week.map(date => {
                let newDate = new Date(date);
                newDate.setDate(newDate.getDate() + addWeeks * 7);
                return newDate;
            });
        }
        function updateDisplay() {
            document.querySelector('.start-date').textContent = formatDateForDisplay(week[0]);
            document.querySelector('.end-date').textContent = formatDateForDisplay(week[6]);
            updateWeekNumbers();
            fetchAppointments(formatDateForApi(week[0]), formatDateForApi(week[6]));
            if (isCurrentWeek(week)) {
                document.querySelector('.previous-button').disabled = true;
            } else {
                document.querySelector('.previous-button').disabled = false;
            }
        }
        function updateWeekNumbers() {
            const dateContainers = document.querySelectorAll('.weekday-container .date-container');
            dateContainers.forEach((container, index) => {
                const weekNumberElement = container.querySelector('.week-number');
                if (weekNumberElement) {
                    weekNumberElement.textContent = week[index].getDate();
                }
            });
        }
        function isCurrentWeek(week) {
            const today = new Date();
            return week.some(day => day.getDate() === today.getDate() &&
                                    day.getMonth() === today.getMonth() &&
                                    day.getFullYear() === today.getFullYear());
        }
        async function fetchAppointments(startDate, endDate) {
            console.log(`Fetching appointments from ${startDate} to ${endDate}`);
            try {
                const response = await fetch(`/admin/schedule-viewer/appointments/${startDate}/${endDate}`);
                const appointments = await response.json();
                console.log('Appointments received:', appointments);
                clearAppointments();
                appointments.forEach(appointment => {
                    addAppointmentToCalendar(appointment);
                });
            } catch (error) {
                console.error('Error fetching appointments:', error);
            }
        }
        function clearAppointments() {
            document.querySelectorAll('.appointment-container').forEach(container => {
                container.innerHTML = '';
            });
        }
        function addAppointmentToCalendar(appointment) {
            const appointmentElement = document.createElement('div');
            appointmentElement.className = 'appointment';
            appointmentElement.innerHTML = `
                <p class="appointment-id">${appointment.appointment_id}</p>
                <p class="patient-name">${appointment.patient_name}</p>
                <div class="time-service-container">
                    <p class="time-slot">${appointment.time_slot}</p>
                    <p class="line2"></p>
                    <p class="service">${appointment.service}</p>
                </div>
            `;
            const appointmentDate = new Date(appointment.appointment_date);
            const dayOfWeek = appointmentDate.getDay();
            const containerSelectors = [
                '.sunday-appointment-container',
                '.monday-appointment-container',
                '.tuesday-appointment-container',
                '.wednesday-appointment-container',
                '.thursday-appointment-container',
                '.friday-appointment-container',
                '.saturday-appointment-container'
            ];
            const containerSelector = containerSelectors[dayOfWeek];
            const container = document.querySelector(containerSelector + ' .appointment-container');
            container.appendChild(appointmentElement);
        }
        function formatDateForDisplay(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }
        function formatDateForApi(date) {
            return date.getFullYear() + '-' +
                (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                date.getDate().toString().padStart(2, '0');
        }
    });
</script>
@endsection