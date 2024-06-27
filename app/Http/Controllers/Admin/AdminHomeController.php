<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AdminHomeController extends Controller
{
    public function getAppointmentCalendarSchedules($startDate, $endDate) {
        // Fetch appointments along with related data, filtering by status 'In Progress'
        $appointments = Appointment::with(['user.userInformation', 'service', 'scheduleDate.timeSlot'])
                                    ->where('status', 'In Progress')
                                    ->whereHas('scheduleDate', function($query) use ($startDate, $endDate) {
                                        $query->whereBetween('appointment_date', [$startDate, $endDate]);
                                    })
                                    ->get();
        // Format the appointments data for the frontend
        $formattedAppointments = $appointments->map(function ($appointment) {
            return [
                'appointment_id' => $appointment->appointment_id,
                'patient_name' => $appointment->user->userInformation->first_name . ' ' . $appointment->user->userInformation->last_name,
                'time_slot' => $appointment->scheduleDate->timeSlot->time_slot,
                'service' => $appointment->service->name,
                'appointment_date' => $appointment->scheduleDate->appointment_date,
                // Include any other fields you need
            ];
        });
        return response()->json($formattedAppointments);
    }    
}
