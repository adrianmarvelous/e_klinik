<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // Get the authenticated user
        $user = Auth::user();

        
        // Assign default role ONLY if user truly has no role
        if (method_exists($user, 'assignRole') && $user->roles->isEmpty()) {
            $user->assignRole('patient');
        }
        // Store user info + role into session
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



        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
