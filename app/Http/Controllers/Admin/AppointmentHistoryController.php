<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\UserInformation;

class AppointmentHistoryController extends Controller
{
    public function deleteAppointment($appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->delete();
    }
    public function viewAppointmentDetails($appointmentId)
    {
        $appointment = Appointment::with([ 'user.userInformation', 'scheduleDate.timeSlot', 'service'])
                                ->findOrFail($appointmentId);
        $userId = $appointment->user->id;
        $userInformation = UserInformation::where('user_id', $userId)->firstOrFail();
        $schedule = $appointment->scheduleDate->appointment_date;
        $timeSlot = $appointment->scheduleDate->timeSlot->time_slot;
        return response()->json([
            'appointment' => $appointment,
            'userInformation' => $userInformation,
            'schedule' => $schedule,
            'timeSlot' => $timeSlot,
        ]);
    }
    public function loadAppointmentHistory(Request $request) {
        $searchQuery = $request->query('search');
        $appointmentHistory = Appointment::with(['scheduleDate.timeSlot', 'service', 'user.userInformation'])
                                    ->where('status', 'Cancelled');
        if (!empty($searchQuery)) {
            $appointmentHistory = $appointmentHistory->where('appointment_id', 'LIKE', '%' . $searchQuery . '%');
        }
        $appointmentHistory = $appointmentHistory->paginate(4);
        return view('admin.appointment-history', compact('appointmentHistory'));
    }
}
