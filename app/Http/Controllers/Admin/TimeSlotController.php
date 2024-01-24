<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScheduleDate;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;

class TimeSlotController extends Controller
{
    
    public function fetchTimeSlots(Request $request)
    {
        $date = $request->input('date');
        $html = '';
        $scheduleDates = ScheduleDate::where('appointment_date', $date)
                            ->orderBy('time_slots_id', 'asc')
                            ->get();
        foreach ($scheduleDates as $scheduleDate) {
            $timeSlot = TimeSlot::find($scheduleDate->time_slots_id);
            if ($timeSlot) {
                $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->time_slot)->format('g:i A');
                $statusClass = $scheduleDate->booked ? 'booked' : 'available';
                $html .= "<div class='time-slot {$statusClass}'><span>Time: {$formattedTime}</span>";
                if(!$scheduleDate->booked) {
                    $html .= "<button onclick='deleteTimeSlot(\"{$scheduleDate->id}\", this)' class='delete-button'>Delete</button>";
                }
                $html .= "</div>";
            }
        }
        if (empty($html)) {
            $html = "<div>No available time slots for this date.</div>";
        }
        return response()->json(['html' => $html]);
    }
    public function deleteTimeSlot(Request $request)
    {
        $request->validate([
            'scheduleDateId' => 'required|integer',
        ]);
        $scheduleDateId = $request->input('scheduleDateId');
        try {
            DB::table('schedule_dates')->where('id', $scheduleDateId)->delete();
            return redirect()->back()->withSuccess('Schedule date deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while deleting the schedule date.');
        }
    }
    public function addTimeSlot(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required|array',
            'time.*' => 'required', // Each time in the array is required
        ], 
        [
            'date.required' => 'Please pick a date.',
            'time.required' => 'Please pick at least one time slot.',
            'time.*.required' => 'Invalid time slot selected.',
        ]);
    
        $conflicts = []; // Array to store conflicts
    
        try {
            foreach ($validatedData['time'] as $time) {
                $formattedTime = date("G:i", strtotime($time));
                $timeSlot = TimeSlot::firstOrCreate(['time_slot' => $formattedTime]);
    
                // Check if the date and time slot combination already exists
                $existingAppointment = ScheduleDate::where([
                    'appointment_date' => $validatedData['date'],
                    'time_slots_id' => $timeSlot->id,
                ])->first();
    
                if ($existingAppointment) {
                    // Add to conflicts array
                    $conflicts[] = $time;
                    continue; // Skip this time slot
                }
    
                ScheduleDate::create([
                    'appointment_date' => $validatedData['date'],
                    'time_slots_id' => $timeSlot->id,
                ]);
            }
    
            if (!empty($conflicts)) {
                // Handle scenarios where one or more time slots are already booked
                $conflictString = implode(', ', $conflicts);
                return back()->with('error', "The following time slots are already booked for this date: $conflictString.");
            }
    
            return back()->with('success', "Time slots added successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add time slots.');
        }
    }
}