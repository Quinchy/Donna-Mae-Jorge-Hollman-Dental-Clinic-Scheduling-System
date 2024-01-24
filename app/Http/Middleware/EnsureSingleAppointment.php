<?php

namespace App\Http\Middleware;

use App\Models\Appointment; // Import the Appointment model
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\DB; // Import the DB facade
class EnsureSingleAppointment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasAppointment = DB::table('appointments')
                            ->join('users', 'appointments.user_id', '=', 'users.id')
                            ->where('users.id', auth()->id())
                            ->latest('appointments.created_at')
                            ->first();
        if ($hasAppointment && $hasAppointment->status === 'Processing' || $hasAppointment && $hasAppointment->status === 'In Progress') {
            return redirect('/my-appointment');
        }
        return $next($request);
    }
}
