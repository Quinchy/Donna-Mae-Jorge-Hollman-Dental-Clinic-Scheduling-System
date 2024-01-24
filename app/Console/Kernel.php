<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->sendAppointmentReminders();
        })->everyThreeMinutes();
    }
    protected function sendAppointmentReminders()
    {
        $tomorrow = now()->addDay()->startOfDay();
        $appointments = \App\Models\Appointment::where('status', 'In Progress')
                            ->join('schedule_dates', 'appointments.schedule_id', '=', 'schedule_dates.id')
                            ->whereDate('schedule_dates.appointment_date', $tomorrow)
                            ->with(['user', 'service'])
                            ->get();
        foreach ($appointments as $appointment) {
            Mail::to($appointment->user->email)->send(new \App\Mail\AppointmentReminder($appointment));
        }
    }
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}