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
            
            if (method_exists($user, 'assignRole') && $user->getRoleNames()->isEmpty()) {
                $user->assignRole('patient');
                $user->refresh(); // reload from DB
            }
            session()->put('user', [
                'id'  => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames()->first(), // Spatie roles
            ]);


            // ✅ Login the user
            Auth::login($user);

            // ✅ Redirect based on role & relation (only one role will match)
            if ($user->hasRole('patient')) {
                return redirect()->route($user->patient ? 'dashboard' : 'patient.create');
            } 
            elseif ($user->hasRole('doctor')) {
                return redirect()->route($user->doctor ? 'dashboard' : 'doctor.create');
            } 
            elseif ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            }

            // fallback
            return redirect()->route('dashboard');


        } catch (\Exception $e) {
            // Log error and redirect back with message
            \Log::error('Google Login Error: '.$e->getMessage());

            return redirect('/login')->with('error', 'Failed to login with Google: '.$e->getMessage());
        }
    }
}
