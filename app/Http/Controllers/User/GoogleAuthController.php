<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        /**
         * @SuppressWarnings(PHPMD.UnusedLocalVariable)
         */
        $googleUser = Socialite::driver('google')->stateless()->user();
        $existingUser = User::where('email', $googleUser->getEmail())->first();
        if ($existingUser) {
            Auth::login($existingUser);
        } 
        else {
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'password' => null,
            ]);
            UserInformation::updateOrCreate([
                'user_id' => $user->id,
                'first_name' => $googleUser->user['given_name'] ?? null,
                'last_name' => $googleUser->user['family_name'] ?? null,
                'phone_number' => null,
            ]);
            Auth::login($user);
        }
        return redirect()->route('index');
    }
}
