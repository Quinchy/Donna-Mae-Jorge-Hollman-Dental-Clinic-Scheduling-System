<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ScheduleDate;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNotification; 

class MyAppointmentController extends Controller
{
    public function loadAppointment() {
        // Fetch the latest appointment for the authenticated user with related models
        $latestAppointment = Appointment::with(['scheduleDate', 'service', 'user', 'user.userInformation'])
                                        ->where('user_id', auth()->user()->id)
                                        ->latest()
                                        ->first();
        return view('user.my-appointment', compact('latestAppointment'));
    }
    public function appointmentStatus() {
        // Fetch the latest appointment status for the authenticated user using a join
        $latestAppointment = DB::table('appointments')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('users.id', auth()->id())
            ->latest('appointments.created_at')
            ->first();
        return view('user.my-appointment', [
            'latestAppointment' => $latestAppointment
        ]);
    }
    public function cancelAppointment($appointmentId) {
        // Find the appointment by ID or fail
        $appointment = Appointment::findOrFail($appointmentId);
        // Find the schedule date associated with the appointment
        $scheduleDate = ScheduleDate::findOrFail($appointment->schedule_id);
        // Update the schedule date to indicate it is no longer booked
        $scheduleDate->update(['booked' => false]);
        // Cancel the appointment
        $appointment->update(['status' => 'Cancelled']);
        // Send a notification email about the cancellation
        Mail::to($appointment->user->email)->send(
            new AppointmentNotification(
                'Donna Mae Jorge-Hollman Dental Clinic - Appointment Cancelled', 
                'Your appointment has been cancelled successfully.'
            )
        );
        return redirect()->back();
    }    
}
