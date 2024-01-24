<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail; 

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        $details = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];
        Mail::to('dmjorgehollman.dentalclinic@gmail.com')
            ->send(new ContactMail($details));   
        return back()->with('message_sent', 'Your message has been sent successfully!');
    }
}
