<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function storeRegisterData(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ], [
            'email.unique' => 'The email address is already taken.'
        ]);
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()
                            ->withInput($request->except('password', 'password_confirmation'))
                            ->withErrors(['password_mismatch' => 'Passwords do not match.']);
        }    
        $verificationCode = rand(100000, 999999);
        Session::put('registration.email', $request->email);
        Session::put('registration.password', $request->password);
        Session::put('register-step1-completed', true);
        Session::put('email_verification_code', $verificationCode);
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        return redirect()->route('register.step2');
    }
    public function verifyCode(Request $request)
    {
        $request->validate([
            'digit-1' => 'required|digits:1',
            'digit-2' => 'required|digits:1',
            'digit-3' => 'required|digits:1',
            'digit-4' => 'required|digits:1',
            'digit-5' => 'required|digits:1',
            'digit-6' => 'required|digits:1',
        ]);
        $inputCode = $request->input('digit-1').$request->input('digit-2').$request->input('digit-3').$request->input('digit-4').$request->input('digit-5').$request->input('digit-6');
        Log::info('Verification code entered: ' . $inputCode);
        Log::info('Session stored code: ' . Session::get('email_verification_code'));
        if ($inputCode == Session::get('email_verification_code')) {
            Session::forget('email_verification_code');
            return redirect()->route('register.step3');
        } else {
            Log::info('Verification code entered: ' . $inputCode);
            Log::info('Session stored code: ' . Session::get('email_verification_code'));
            return redirect()->back()->withErrors(['code_mismatch' => 'The verification code does not match.']);
        }
    }
    public function resendVerificationCode()
    {
        $email = Session::get('registration.email');
        if (!$email) {
            return redirect()->route('register.step1')->withErrors(['email_not_found' => 'Email not found. Please register again.']);
        }
        $verificationCode = rand(100000, 999999);
        Session::put('email_verification_code', $verificationCode);
        Mail::to($email)->send(new VerificationCodeMail($verificationCode));
        return redirect()->back()->with('status', 'Verification code resent.');
    }
    public function registerData(Request $request)
    {
        $email = Session::get('registration.email');
        $password = Session::get('registration.password');
        $customMessages = [
            'phone.regex' => 'The phone number format is invalid.',
        ];
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['string', 'max:255', 'regex:/^(?:\+\d{1,15}|0\d{9,10})$/']
        ], $customMessages);
        $user = User::create([
            'email' => $email,
            'password' => $password,
        ]);
        UserInformation::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
        ]);
        Auth::login($user);
        return redirect()->route('register.step4');
    }
}
