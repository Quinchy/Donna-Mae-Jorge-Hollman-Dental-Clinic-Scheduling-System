<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $verificationCode;
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }
    public function build()
    {
        return $this->from('dmjorgehollman.dentalclinic@gmail.com', 'Donna Mae Jorge-Hollman Dental Clinic')
                    ->subject('Email Verification Code')
                    ->view('email.verification-code-mail')
                    ->with(['verificationCode' => $this->verificationCode]);
    }
}
