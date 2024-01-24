<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleDate;
use App\Models\TimeSlot;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateAppointmentController extends Controller
{
    public function submitCreatedAppointment(Request $request) {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_number' => 'required|string|max:255',
            'appointment_date' => 'required|date|exists:schedule_dates,appointment_date',
            'appointment_service' => 'required|exists:services,name',
            'time_slot' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails() && empty(array_filter($request->all()))) {
            return back()->withErrors(['customError' => 'The first name, last name, email, contact number, appointment date, appointment service, and time slot field is required.']);
        } else if ($validator->fails()) {
            return back()->withErrors(['customError' => 'The first name, last name, email, contact number, appointment date, appointment service, and time slot field is required.']);
        }
        $validatedData = $validator->validated();
        $user = User::firstOrCreate(['email' => $validatedData['email']]);
        $user->userInformation()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone_number' => $validatedData['contact_number']
            ]
        );
        $existingAppointment = Appointment::where('user_id', $user->id)
                                            ->whereIn('status', ['Processing', 'In Progress'])
                                            ->first();
        if ($existingAppointment) {
            return back()->withErrors(['msg' => 'This user already has an ongoing appointment.']);
        }
        $serviceId = Service::where('name', $validatedData['appointment_service'])->first()->id;
        $formattedTimeSlot = date("G:i", strtotime($validatedData['time_slot']));
        $timeSlotId = TimeSlot::where('time_slot', $formattedTimeSlot)->first()->id;
        $scheduleDate = ScheduleDate::where('appointment_date', $validatedData['appointment_date'])
                                    ->where('time_slots_id', $timeSlotId)->first();
        if ($scheduleDate && !$scheduleDate->booked) {
            $appointmentId = $this->generateAppointmentId($scheduleDate, $timeSlotId);
            $appointment = Appointment::firstOrNew(['appointment_id' => $appointmentId]);
            $appointment->fill([
                'user_id' => $user->id,
                'service_id' => $serviceId,
                'schedule_id' => $scheduleDate->id,
                'status' => 'Processing'
            ])->save();
            $scheduleDate->update(['booked' => true]);
            Log::info('Appointment created', ['appointment_id' => $appointmentId]);
            return redirect()->to('admin/create-appointment')->with('success', 'Appointment created successfully.');
        } else {
            return back()->withErrors(['msg' => 'The selected time slot is already booked or unavailable.']);
        }
    }
    private function generateAppointmentId($scheduleDate, $timeSlotId) {
        $appointmentDate = Carbon::createFromFormat('Y-m-d', $scheduleDate->appointment_date);
        $month = $appointmentDate->format('m');
        $year = $appointmentDate->format('y');
        $day = $appointmentDate->format('d');
        $timeSlotIdPadded = str_pad($timeSlotId, 2, '0', STR_PAD_LEFT);
        return $month.$year."-".$day.$timeSlotIdPadded;
    }
}
