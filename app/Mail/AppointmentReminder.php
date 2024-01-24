<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }
    public function build()
    {
        $appointmentDate = Carbon::parse($this->appointment->appointment_date);
        return $this->view('email.appointment-reminder')
                    ->with([
                        'appointmentDate' => $appointmentDate,
                        'serviceName' => $this->appointment->service->name,
                    ]);
    }
}
