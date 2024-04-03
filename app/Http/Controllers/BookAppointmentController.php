<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleDate;
use App\Models\TimeSlot;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookAppointmentController extends Controller
{
    public function submitAppointment(Request $request) {
        // Validate request data
        $customMessages = [
            'appointment_date.required' => 'Please select an appointment date.',
            'appointment_date.date' => 'The appointment date must be a valid date.',
            'appointment_date.exists' => 'The selected appointment date is not available.',
            'appointment_service.required' => 'Please select a service.',
            'appointment_service.exists' => 'The selected service is not available.',
            'time_slot.required' => 'Please select a time slot.',
        ];
        $validatedData = $request->validate([
            'appointment_date' => 'required|date|exists:schedule_dates,appointment_date',
            'appointment_service' => 'required|exists:services,name',
            'time_slot' => 'required',
        ], $customMessages);
        $userId = auth()->id();
        $serviceId = Service::where('name', $validatedData['appointment_service'])->first()->id;
        $formattedTimeSlot = date("G:i", strtotime($validatedData['time_slot']));
        $timeSlotId = TimeSlot::where('time_slot', $formattedTimeSlot)->first()->id;
        $scheduleDate = ScheduleDate::where('appointment_date', $validatedData['appointment_date'])
                                    ->where('time_slots_id', $timeSlotId)->first();
    
        if ($scheduleDate && !$scheduleDate->booked) {
            // Generate appointment ID
            $appointmentDate = Carbon::createFromFormat('Y-m-d', $scheduleDate->appointment_date);
            $month = $appointmentDate->format('m');
            $year = $appointmentDate->format('y');
            $day = $appointmentDate->format('d');
            $timeSlotIdPadded = str_pad($timeSlotId, 2, '0', STR_PAD_LEFT);
            $appointmentId = $month.$year."-".$day.$timeSlotIdPadded;
    
            // Check if appointment with generated ID already exists
            $appointment = Appointment::firstOrNew(['appointment_id' => $appointmentId]);
    
            // Update or create the appointment
            $appointment->user_id = $userId;
            $appointment->service_id = $serviceId;
            $appointment->schedule_id = $scheduleDate->id;
            $appointment->status = 'Processing';
            $appointment->save();
            // Mark the schedule date as booked
            $scheduleDate->booked = true;
            $scheduleDate->save();
            return redirect()->to('book-appointment-success');
        } else {
            return back()->withErrors(['msg' => 'The selected time slot is already booked or unavailable.']);
        }
    }
}
