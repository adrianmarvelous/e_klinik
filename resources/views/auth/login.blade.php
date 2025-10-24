<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}
            {{-- <div class="flex items-center justify-center mt-4">
                <x-primary-button class="px-5 py-2">
                    {{ __('Log in') }}
                </x-primary-button>
            </div> --}}
            {{-- <div class="flex items-center justify-center mt-4"> --}}
                <button type="submit" class="btn btn-primary w-100">
                    Log In
                </button>
            {{-- </div> --}}

        </div>
    </form>
    <!-- Google Login Button -->
    <a href="{{ route('google.login') }}" class="btn btn-danger d-flex align-items-center justify-content-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-google me-2" viewBox="0 0 16 16">
            <path
                d="M8.159 7.999h7.84c.111.59.171 1.205.171 1.841 0 4.146-2.776 7.086-7.011 7.086A8.002 8.002 0 0 1 .173 8.325c0-4.42 3.58-8 8-8 2.16 0 3.976.798 5.294 2.102l-2.146 2.145C10.594 3.714 9.463 3.26 8.173 3.26c-2.708 0-4.91 2.217-4.91 5.065s2.202 5.065 4.91 5.065c2.799 0 4.348-1.74 4.521-3.323H8.159V7.999z" />
        </svg>
        Login with Google
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</x-guest-layout>
