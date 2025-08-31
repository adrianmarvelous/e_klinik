<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class SocialiteController extends Controller
{
    /**
     * Redirect user to Google for login.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            // ✅ Use stateless() for local dev to avoid InvalidStateException
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Debug info (only in dev, remove in production)
            // dd($googleUser);

            // ✅ Create or update user
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'password' => bcrypt(Str::random(16)), // random dummy password
                ]
            );
            session()->put('user', [
                'id'  => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]);


            // ✅ Assign default role if none
            if (method_exists($user, 'assignRole') && !$user->hasAnyRole()) {
                $user->assignRole('patient'); // make sure "user" role exists
            }

            // ✅ Login the user
            Auth::login($user);

            // ✅ Kalau user punya role "patient"
            if ($user->hasRole('patient')) {
                if ($user->patient) {
                    return redirect()->route('dashboard'); // sudah punya data pasien
                } else {
                    return redirect()->route('patient.create'); // belum punya data pasien
                }
            }


            // return redirect()->intended('/dashboard');
            return redirect()->route('dashboard'); // sudah punya data pasien

        } catch (\Exception $e) {
            // Log error and redirect back with message
            \Log::error('Google Login Error: '.$e->getMessage());

            return redirect('/login')->with('error', 'Failed to login with Google: '.$e->getMessage());
        }
    }
}
