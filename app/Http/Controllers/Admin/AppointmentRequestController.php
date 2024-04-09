<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ScheduleDate;
use App\Mail\AppointmentNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentRequestController extends Controller
{
    public function acceptAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::with('user')->findOrFail($appointmentId);
            $appointment->update(['status' => 'In Progress']);
            Mail::to($appointment->user->email)
                ->queue(new AppointmentNotification('Appointment Accepted', 'Your appointment has been accepted.'));
        } catch (\Exception $e) {
            // Handle exception (log or return error message)
        }
        return redirect()->back();
    }
    public function declineAppointment($appointmentId)
    {
        try {
            DB::transaction(function () use ($appointmentId) {
                $appointment = Appointment::with('user', 'scheduleDate')->findOrFail($appointmentId);
                $appointment->update(['status' => 'Cancelled']);
                $appointment->scheduleDate->update(['booked' => false]);
                Mail::to($appointment->user->email)
                    ->queue(new AppointmentNotification('Appointment Declined', 'Your appointment has been declined.'));
            });
        } catch (\Exception $e) {
            // Handle exception (log or return error message)
        }
        return redirect()->back();
    }
    public function loadAppointmentRequest(Request $request) {
        $searchQuery = $request->query('search');
        $appointmentRequests = Appointment::with(['scheduleDate.timeSlot', 'service', 'user.userInformation'])
                                    ->join('schedule_dates', 'appointments.schedule_id', '=', 'schedule_dates.id')
                                    ->join('time_slots', 'schedule_dates.time_slots_id', '=', 'time_slots.id')
                                    ->where('appointments.status', 'Processing');
        if (!empty($searchQuery)) {
            $appointmentRequests = $appointmentRequests->where('appointments.appointment_id', 'LIKE', '%' . $searchQuery . '%');
        }
        $appointmentRequests = $appointmentRequests->orderBy('schedule_dates.appointment_date', 'asc')
                                                    ->orderBy('time_slots.time_slot', 'asc')
                                                    ->select('appointments.*') // Select only columns from appointments table
                                                    ->paginate(7);
        return view('admin.appointment-request-manager', compact('appointmentRequests'));
    }    
}
