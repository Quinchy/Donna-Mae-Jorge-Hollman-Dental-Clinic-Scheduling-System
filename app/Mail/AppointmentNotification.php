<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $messageText;
    public function __construct($subject, $messageText)
    {
        $this->subject = $subject;
        $this->messageText = $messageText;
    }
    public function build()
    {
        return $this->from('dmjorgehollman.dentalclinic@gmail.com', 'Donna Mae Jorge-Hollman Dental Clinic')
                    ->subject($this->subject)
                    ->view('email.appointment-mail')
                    ->with(['messageText' => $this->messageText]);
    }
}
