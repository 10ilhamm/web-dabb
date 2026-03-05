<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Login') }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="login-page-bg font-sans text-gray-900 antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    @include('navbar')

    <!-- Breadcrumb -->
    <div class="login-breadcrumb">
        <div class="container">
            <span class="text-cyan">Login</span>
        </div>
    </div>

    <!-- Hero Header -->
    <div class="login-hero">
        <div class="container">
            <h1>LOGIN</h1>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow login-main-wrapper">
        <div class="login-card">

            <!-- Left Side: Form -->
            <div class="login-form-side">
                <h2>Selamat Datang</h2>

                <h3>Login</h3>
                <p class="subtitle">Silahkan masukan email dan password anda</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="login-form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" class="login-input" type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div class="login-form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" class="login-input" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <a class="login-forgot" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        {{ __('Submit') }}
                    </button>

                    <div class="login-divider">Atau</div>

                    <!-- Google Login Button (Placeholder href) -->
                    <a href="#" class="btn-google">
                        <img src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/24px.svg" alt="Google">
                        Masuk dengan Google
                    </a>

                    <!-- Register Link -->
                    <div class="login-register-text">
                        Belum punya akun? <a href="{{ route('register') }}">Registrasi</a>
                    </div>
                </form>
            </div>

            <!-- Right Side: Image Banner -->
            <div class="login-banner-side">
                <div class="banner-overlay-logo">
                    <img src="{{ asset('image/logo_anri.png') }}" alt="ANRI Logo">
                    <div class="banner-overlay-text">
                        <div class="title">Depot Arsip<br>Berkelanjutan Bandung</div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    @include('footer')

</body>

</html>
