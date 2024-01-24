<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDate;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNotification; 

class AppointmentController extends Controller
{
    public function loadAppointment() {
        $latestAppointment = Appointment::with(['scheduleDate', 'service', 'user', 'user.userInformation'])
                                ->where('user_id', auth()->user()->id)
                                ->latest()
                                ->first();
        return view('my-appointment', compact('latestAppointment'));
    }
    public function appointmentStatus() {
        $latestAppointment = DB::table('appointments')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->where('users.id', auth()->id())
        ->latest('appointments.created_at')
        ->first();
        return view('my-appointment', [
            'latestAppointment' => $latestAppointment
        ]);
    }
    public function cancelAppointment($appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $scheduleDate = ScheduleDate::findOrFail($appointment->schedule_id);
        $scheduleDate->update(['booked' => false]);
        $appointment->update(['status' => 'Cancelled']);
        Mail::to($appointment->user->email)->send(new AppointmentNotification('Appointment Cancelled', 'Your appointment has been cancelled succesfully.'));
        return redirect()->back();
    }
}
