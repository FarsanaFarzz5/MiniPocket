<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Pocket - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#006400">

    <!-- iOS Support -->
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>

<div class="container">
    <!-- Inner container to center content -->
    <div class="inner-container">
        <!-- Banner Image -->
        <div class="banner">
            <img src="{{ asset('images/mini 04.png') }}" alt="Banner Image">
        </div>

        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
        </div>

        <!-- Welcome text -->
        <div class="title">Welcome to</div>
        <div class="subtitle">Tiny Treasures</div>

        <!-- Login Button -->
        <form method="GET" action="{{ route('login.form') }}">
            <button type="submit" class="btn">Login</button>
        </form>

        {{-- signup for parents --}}
        @if(!Auth::check() || (Auth::check() && Auth::user()->role != 2))
        <form method="GET" action="{{ route('register.form', ['role' => 1]) }}">
        <button type="submit" class="btn">Sign Up</button>
        </form>
        @endif

    </div>
</div>

<script src="{{ asset('assets/js/welcome.js') }}"></script>

</body>
</html>
