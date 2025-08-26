{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in | {{ config('app.name') }}</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('images/bb-logo.png') }}">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom Colors */
    .bg-burgundy { background-color: #5D0F0F; }
    .text-gold   { color: #D69E2E; }
    .border-gold { border-color: #D69E2E; }
  </style>
</head>
<body class="min-h-screen bg-burgundy flex items-center justify-center p-4">
  <div class="w-full max-w-md space-y-6">
    <!-- Logo -->
    <div class="flex justify-center">
      <img src="{{ asset('images/bb-logo.png') }}" alt="Logo" class="h-24 w-auto drop-shadow-lg" />
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-2xl border-4 border-gold overflow-hidden">
      <form action="{{ route('login') }}" method="POST" class="space-y-6 p-8">
        @csrf

        <!-- Title -->
        <h2 class="text-center text-2xl font-extrabold text-gray-800 mb-4">Log In <span class="text-gold">Now</span></h2>

        <!-- Email -->
        <div class="relative">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
              <!-- mail icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.94 6.94a1.5 1.5 0 012.12 0L10 11.88l4.94-4.94a1.5 1.5 0 112.12 2.12l-6 6a1.5 1.5 0 01-2.12 0l-6-6a1.5 1.5 0 010-2.12z" />
              </svg>
            </span>
            <input id="email" name="email" type="email" autocomplete="username" value="{{ old('email') }}" required autofocus
                   class="block w-full pl-10 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-full shadow-inner placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-gold transition" />
          </div>
        </div>

        <!-- Password -->
        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
              <!-- lock icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 8V6a5 5 0 0110 0v2a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm2-2a3 3 0 016 0v2H7V6z" clip-rule="evenodd" />
              </svg>
            </span>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="block w-full pl-10 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-full shadow-inner placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-gold transition" />
          </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
          <label for="remember_me" class="inline-flex items-center text-sm text-gray-600">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-burgundy border-gray-300 rounded focus:ring-gold" />
            <span class="ml-2">Remember me</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-burgundy hover:text-gray-800">Forgot your password?</a>
          @endif
        </div>

        <!-- Submit -->
        <div>
          <button type="submit"
                  class="w-full flex justify-center py-2 px-4 border-2 border-gold text-sm font-bold rounded-full text-white bg-burgundy hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold transition">
            Log in
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>