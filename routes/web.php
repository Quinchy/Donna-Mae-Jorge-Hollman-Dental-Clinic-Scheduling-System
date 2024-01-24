<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookAppointmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\AppointmentRequestController;
use App\Http\Controllers\Admin\AppointmentListController;
use App\Http\Controllers\Admin\AppointmentHistoryController;
use App\Http\Controllers\Admin\CreateAppointmentController;
use App\Http\Controllers\Admin\ScheduleViewerController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContactController;

// Non Authenticated Routes
Route::get('/', function () {
    return view('index');
})->name('index');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/service', function () {
    return view('service');
})->name('service');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');
Route::get('/login/post', function () {
    return redirect('/login');
});
Route::get('/register-step1', function () {
    return view('registration.register-step1');
})->middleware('guest')->name('register.step1');
Route::get('/register-step2', function () {
    return view('registration.register-step2');
})->middleware('check-step-completion')->name('register.step2');
Route::get('/register-step3', function () {
    return view('registration.register-step3');
})->middleware('check-step-completion')->name('register.step3');
Route::get('/register-step4', function () {
    return view('registration.register-step4');
})->middleware('check-step-completion')->name('register.step4');
// Google Login Routes
Route::get('/auth/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback',[GoogleAuthController::class, 'handleGoogleCallback']);
// Route Post
Route::post('/login/post', [LoginController::class, 'loginUser'])->name('login.post');
Route::post('/register/step1', [RegistrationController::class, 'storeRegisterData'])->name('register.step1.post');
Route::post('/register/verify-code', [RegistrationController::class, 'verifyCode'])->name('register.verify-code');
Route::post('/register/resend-code', [RegistrationController::class, 'resendVerificationCode'])->name('register.resend-code');
Route::post('/register/step3', [RegistrationController::class, 'registerData'])->name('register.step3.post');
Route::post('/send-contact-mail', [ContactController::class, 'sendMail'])->name('send.contact.mail');
// User Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserController::class, 'loadAccount'])->name('account');
    Route::get('/my-appointment', [AppointmentController::class, 'appointmentStatus'])->name('load-appointment-status');
    Route::get('/my-appointment', [AppointmentController::class, 'loadAppointment'])->name('load-appointment');
    Route::get('/book-appointment', [CalendarController::class, 'loadAppointmentCalendar'])->middleware('single.appointment')->name('book-appointment');
    Route::get('/book-appointment-success', function () {
        return view('book-appointment-success');
    })->name('book-appointment-success');
    Route::post('/submit-appointment', [BookAppointmentController::class, 'submitAppointment']);
    Route::post('/fetch-appointment-time-slots', [CalendarController::class, 'fetchAppointmentTimeSlots']);
    Route::post('/cancel-appointment/{appointmentId}', [AppointmentController::class, 'cancelAppointment'])->name('my-appointment.cancel');
    Route::post('/account/save', [UserController::class, 'saveAccount'])->middleware('auth')->name('account.save');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', function() {
            return view('admin.admin-login');
        })->name('login.admin');
    });
    // Admin Authenticated Routes
    Route::middleware(['auth:admin', 'verified'])->group(function () {
        Route::get('schedule-viewer', function () {
            return view('admin.schedule-viewer');
        })->name('schedule-viewer');
        Route::get('appointment-scheduler', [CalendarController::class, 'loadAppointmentCalendar'])->name('appointment-scheduler');
        Route::get('/schedule-viewer/appointments/{startDate}/{endDate}', [ScheduleViewerController::class, 'getAppointments']);
        Route::get('appointment-request-manager', [AppointmentRequestController::class, 'loadAppointmentRequest'])->name('appointment-request-manager');
        Route::get('appointment-manager', [AppointmentListController::class, 'loadAppointmentManagerData'])->name('appointment-manager');
        Route::get('appointment-manager/view-details/{appointment}', [AppointmentListController::class, 'viewAppointmentDetails'])->name('admin.appointment-manager.view');
        Route::get('appointment-history', [AppointmentHistoryController::class, 'loadAppointmentHistory'])->name('appointment-history');
        Route::get('appointment-history/view-details/{appointment}', [AppointmentHistoryController::class, 'viewAppointmentDetails'])->name('admin.appointment-history.view');
        Route::get('create-appointment', [CalendarController::class, 'loadAppointmentCalendar'])->name('create-appointment');
        Route::post('delete-time-slot', [TimeSlotController::class, 'deleteTimeSlot']);
        Route::post('fetch-time-slot', [TimeSlotController::class, 'fetchTimeSlots'])->name('fetch-time-slot');
        Route::post('add-time-slot', [TimeSlotController::class, 'addTimeSlot'])->name('add-time-slot');
        Route::post('appointment-scheduler/fetch-appointment-time-slots', [CalendarController::class, 'fetchAppointmentTimeSlots']);
        Route::post('appointment-request-manager/accept/{appointment}', [AppointmentRequestController::class, 'acceptAppointment'])->name('appointment-request-manager.accept');
        Route::post('appointment-request-manager/decline/{appointment}', [AppointmentRequestController::class, 'declineAppointment'])->name('appointment-request-manager.decline');
        Route::post('appointment-manager/done/{appointment}', [AppointmentListController::class, 'doneAppointment'])->name('appointment-manager.done');
        Route::post('appointment-manager/cancel/{appointment}', [AppointmentListController::class, 'cancelAppointment'])->name('appointment-manager.cancel');
        Route::post('appointment-manager/fetch-appointment-time-slots', [CalendarController::class, 'fetchAppointmentTimeSlots'])->name('fetch-appointment-time-slots');
        Route::post('appointment-manager/submit-reschedule', [AppointmentListController::class, 'submitReschedule'])->name('appointment-manager.submitReschedule');
        Route::post('appointment-history/delete/{appointment}', [AppointmentHistoryController::class, 'deleteAppointment'])->name('appointment-history.delete');
        Route::post('create-appointment/fetch-appointment-time-slots', [CalendarController::class, 'fetchAppointmentTimeSlots']);
        Route::post('submit-created-appointment', [CreateAppointmentController::class, 'submitCreatedAppointment'])->name('submit-created-appointment');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';