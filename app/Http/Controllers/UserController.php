<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInformation;

class UserController extends Controller
{
    public function loadAccount()
    {
        $user = auth()->user()->load('userInformation');
        return view('account', compact('user'));
    }
    public function saveAccount(Request $request)
    {
        $userId = auth()->id();
        $user = User::findOrFail($userId);
        $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'phone' => ['string', 'max:255', 'regex:/^(?:\+\d{1,15}|0\d{9,10})$/']
        ], [
            'email.unique' => 'This email is already taken.',
            'phone_number.regex' => 'The phone number format is invalid.'
        ]);
        if ($request->filled('email')) {
            $user->email = $request->email;
            $user->save();
        }
        $userInformation = UserInformation::where('user_id', $userId)->first();
        if ($userInformation) {
            if ($request->filled('first_name')) {
                $userInformation->first_name = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $userInformation->last_name = $request->last_name;
            }
            if ($request->filled('phone_number')) {
                $userInformation->phone_number = $request->phone_number;
            }
            $userInformation->save();
        }
        return redirect()->back()->with('success', 'Account information updated successfully.');
    }
}