<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CalendarController extends Controller
{
    public function fetchAppointmentTimeSlots(Request $request) {
        $date = $request->input('date');
        $availableTimeSlots = [];
        $bookedTimeSlots = [];
        $scheduleDates = DB::table('schedule_dates')
                        ->where('appointment_date', $date)
                        ->where('booked', false) 
                        ->orderBy('time_slots_id', 'asc')
                        ->get();
        foreach ($scheduleDates as $scheduleDate) {
            $timeSlot = DB::table('time_slots')
                        ->where('id', $scheduleDate->time_slots_id)
                        ->first();
            if ($timeSlot) {
                $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->time_slot)->format('g:i A');
                $availableTimeSlots[] = $formattedTime;
            }
        }
        $scheduleTrueDates = DB::table('schedule_dates')
                            ->where('appointment_date', $date)
                            ->where('booked', true) 
                            ->orderBy('time_slots_id', 'asc')
                            ->get();
        foreach ($scheduleTrueDates as $scheduleDate) {
            $timeSlot = DB::table('time_slots')
                        ->where('id', $scheduleDate->time_slots_id)
                        ->first();
            if ($timeSlot) {
                $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->time_slot)->format('g:i A');
                $bookedTimeSlots[] = $formattedTime;
            }
        }
        return response()->json([
            'availableTimeSlots' => $availableTimeSlots,
            'bookedTimeSlots' => $bookedTimeSlots
        ]);
    }    
    public function loadAppointmentCalendar()
    {
        $startDate = now()->addDays(2);
        $endDate = now()->addMonthNoOverflow()->endOfMonth();
        $dates = ScheduleDate::where('appointment_date', '>=', $startDate)
                            ->where('appointment_date', '<=', $endDate)
                            ->get();
        $routeName = Route::currentRouteName();
        $viewName = $this->getViewNameFromRoute($routeName);
        return view($viewName, compact('dates'));
    }
    private function getViewNameFromRoute($routeName)
    {
        $routeToViewMap = [
            'admin.create-appointment' => 'admin.create-appointment',
            'admin.appointment-manager' => 'admin.appointment-manager',
            'book-appointment' => 'book-appointment',
            'admin.appointment-scheduler' => 'admin.appointment-scheduler',
            // Add more mappings as needed
        ];
        return $routeToViewMap[$routeName];
    }
}
