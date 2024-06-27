<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInformation;

class MyAccountController extends Controller
{
    public function loadAccount()
    {
        // Load the authenticated user along with their user information
        $user = auth()->user()->load('userInformation');
        // Return the account view with the user data
        return view('user.account', compact('user'));
    }
    public function saveAccount(Request $request)
    {
        $userId = auth()->id();
        // Find the user or fail if not found
        $user = User::findOrFail($userId);
        // Validate the request data
        $this->validateRequest($request, $userId);
        // Update the user's email if provided
        $this->updateEmail($request, $user);
        // Update the user's information
        $this->updateUserInformation($request, $userId);
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Account information updated successfully.');
    }
    private function validateRequest(Request $request, $userId)
    {
        $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'phone' => ['string', 'max:255', 'regex:/^(?:\+\d{1,15}|0\d{9,10})$/']
        ], [
            'email.unique' => 'This email is already taken.',
            'phone_number.regex' => 'The phone number format is invalid.'
        ]);
    }
    private function updateEmail(Request $request, User $user)
    {
        if ($request->filled('email')) {
            $user->email = $request->email;
            $user->save();
        }
    }
    private function updateUserInformation(Request $request, $userId)
    {
        $userInformation = UserInformation::where('user_id', $userId)->first();
        if (!$userInformation) {
            return;
        }
        $updated = false;
        if ($request->filled('first_name')) {
            $userInformation->first_name = $request->first_name;
            $updated = true;
        }
        if ($request->filled('last_name')) {
            $userInformation->last_name = $request->last_name;
            $updated = true;
        }
        if ($request->filled('phone_number')) {
            $userInformation->phone_number = $request->phone_number;
            $updated = true;
        }
        if ($updated) {
            $userInformation->save();
        }
    }
}