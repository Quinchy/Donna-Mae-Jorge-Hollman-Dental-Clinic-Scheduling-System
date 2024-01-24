<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\UserInformation;
use App\Models\TimeSlot;
use App\Models\ScheduleDate;
use App\Mail\AppointmentNotification; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppointmentListController extends Controller
{
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
    public function doneAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::with('user')->findOrFail($appointmentId);
            $appointment->update(['status' => 'Done']);
            Mail::to($appointment->user->email)
                ->queue(new AppointmentNotification('Appointment Done', 'Thank you for your appointment. We hope to see you again.'));
        } catch (\Exception $e) {
            // Handle exception (log or return error message)
        }
        return redirect()->back();
    }
    public function submitReschedule(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $appointmentId = $request->input('appointment_id');
                $appointment = Appointment::with('user')->find($appointmentId);
                $currentSchedule = ScheduleDate::find($appointment->schedule_id);
                $currentSchedule->booked = false;
                $currentSchedule->save();
    
                $timeSlot = TimeSlot::where('time_slot', $request->input('time_slot'))->first();
                $scheduleDate = ScheduleDate::where('appointment_date', $request->input('appointment_date'))
                                            ->where('time_slots_id', $timeSlot->id)
                                            ->first();
                $scheduleDate->booked = true;
                $scheduleDate->save();
    
                $appointment->schedule_id = $scheduleDate->id;
                $appointment->save();
    
                Mail::to($appointment->user->email)
                    ->queue(new AppointmentNotification('Appointment Rescheduled', 'Your appointment has been rescheduled.'));
            });
        } catch (\Exception $e) {
            // Handle exception (log or return error message)
        }
        return redirect()->back()->with('success', 'Appointment rescheduled successfully.');    
    }
    public function cancelAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::with('user')->findOrFail($appointmentId);
            $scheduleDate = ScheduleDate::findOrFail($appointment->schedule_id);
            $scheduleDate->update(['booked' => false]);
            $appointment->update(['status' => 'Cancelled']);
    
            Mail::to($appointment->user->email)
                ->queue(new AppointmentNotification('Appointment Cancelled', 'Your appointment has been cancelled.'));
        } catch (\Exception $e) {
            // Handle exception (log or return error message)
        }
        return redirect()->back();
    }
    public function loadAppointmentManagerData(Request $request) {
        $perPage = 4;
        $searchQuery = $request->query('search');
        $appointmentList = Appointment::with(['scheduleDate.timeSlot', 'service', 'user.userInformation'])
                                    ->join('schedule_dates', 'appointments.schedule_id', '=', 'schedule_dates.id')
                                    ->join('time_slots', 'schedule_dates.time_slots_id', '=', 'time_slots.id')
                                    ->where('appointments.status', 'In Progress');
        if (!empty($searchQuery)) {
            $appointmentList = $appointmentList->where('appointments.appointment_id', 'LIKE', '%' . $searchQuery . '%');
        }
        $appointmentList = $appointmentList->orderBy('schedule_dates.appointment_date', 'asc')
                                            ->orderBy('time_slots.time_slot', 'asc')
                                            ->select('appointments.*') // Select only columns from appointments table
                                            ->paginate($perPage);
        $startDate = now()->addDays(2);
        $endDate = now()->addMonthNoOverflow()->endOfMonth();
        $dates = ScheduleDate::where('appointment_date', '>=', $startDate)
                            ->where('appointment_date', '<=', $endDate)
                            ->get();
        return view('admin.appointment-manager', compact('appointmentList', 'dates'));
    }    
}
