<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'The email does not exist.',
            ]);
        }
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The password is wrong.',
            ]);
        }
        Auth::login($user);
        return redirect('/');
    }
}
