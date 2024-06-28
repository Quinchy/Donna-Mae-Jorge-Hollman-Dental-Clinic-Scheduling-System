<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
    public function showStep1()
    {
        return view('user.registration.register-step1');
    }
    public function showStep2()
    {
        return view('user.registration.register-step2');
    }
    public function showStep3()
    {
        return view('user.registration.register-step3');
    }
    public function showStep4()
    {
        return view('user.registration.register-step4');
    }
    public function storeRegisterData(Request $request)
    {
        $this->validateRegisterData($request);
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['password_mismatch' => 'Passwords do not match.']);
        }
        $verificationCode = $this->generateVerificationCode();
        $this->storeRegistrationDataInSession($request, $verificationCode);
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        return redirect()->route('register.step2');
    }
    public function resendVerificationCode(Request $request)
    {
        $email = Session::get('registration.email');
        if (!$email) {
            return response()->json(['error' => 'Email not found. Please register again.'], 400);
        }
    
        $lastSent = Session::get('last_verification_code_sent_time');
        $cooldown = 60; // Cooldown time in seconds
    
        if ($lastSent && (time() - $lastSent) < $cooldown) {
            $remaining = $cooldown - (time() - $lastSent);
            return response()->json(['error' => 'Please wait ' . $remaining . ' seconds before requesting a new code.'], 429);
        }
    
        $verificationCode = $this->generateVerificationCode();
        Session::put('email_verification_code', $verificationCode);
        Session::put('last_verification_code_sent_time', time());
        Mail::to($email)->send(new VerificationCodeMail($verificationCode));
    
        return response()->json(['success' => 'Verification code resent.'], 200);
    }
    
    public function registerData(Request $request)
    {
        $this->validateRegisterDataStep3($request);
        $email = Session::get('registration.email');
        $password = Session::get('registration.password');
        $user = $this->createUser($email, $password);
        $this->createUserInformation($request, $user);
        Auth::login($user);
        return redirect()->route('register.step4');
    }
    private function validateRegisterData(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ], [
            'email.unique' => 'The email address is already taken.'
        ]);
    }
    public function verifyCode(Request $request)
    {
        $this->validateVerificationCode($request);
        $inputCode = trim($this->getInputCode($request));
        $storedCode = trim(Session::get('email_verification_code'));
    
        // Log the inputted code and the stored code for verification
        Log::info('Inputted Verification Code: ' . $inputCode . ' (length: ' . strlen($inputCode) . ')');
        Log::info('Stored Verification Code: ' . $storedCode . ' (length: ' . strlen($storedCode) . ')');
    
        // Check if codes match and handle redirection
        if ($inputCode === $storedCode) {
            Session::forget('email_verification_code');
            Log::info('Verification successful. Redirecting to step 3.');
            return redirect()->route('register.step3');
        }
    
        Log::info('Verification failed. Codes do not match.');
        return redirect()->back()->withErrors(['code_mismatch' => 'The verification code does not match.']);
    }
    private function validateVerificationCode(Request $request)
    {
        $request->validate([
            'digit-1' => 'required|digits:1',
            'digit-2' => 'required|digits:1',
            'digit-3' => 'required|digits:1',
            'digit-4' => 'required|digits:1',
            'digit-5' => 'required|digits:1',
            'digit-6' => 'required|digits:1',
        ]);
    }
    
    private function getInputCode(Request $request)
    {
        return $request->input('digit-1') . $request->input('digit-2') . $request->input('digit-3') .
            $request->input('digit-4') . $request->input('digit-5') . $request->input('digit-6');
    }    
    private function generateVerificationCode()
    {
        return rand(100000, 999999);
    }
    private function storeRegistrationDataInSession(Request $request, $verificationCode)
    {
        Session::put('registration.email', $request->email);
        Session::put('registration.password', $request->password);
        Session::put('register-step1-completed', true);
        Session::put('email_verification_code', $verificationCode);
    }
    private function validateRegisterDataStep3(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['string', 'max:255', 'regex:/^(?:\+\d{1,15}|0\d{9,10})$/']
        ], [
            'phone.regex' => 'The phone number format is invalid.',
        ]);
    }
    private function createUser($email, $password)
    {
        return User::create([
            'email' => $email,
            'password' => $password,
        ]);
    }
    private function createUserInformation(Request $request, User $user)
    {
        UserInformation::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
        ]);
    }
}
