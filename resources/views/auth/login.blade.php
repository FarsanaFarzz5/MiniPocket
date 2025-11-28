<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mini Pocket - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Global Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- Auth Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>
  <div class="container">
    <div class="inner-container">

      <!-- Logo -->
      <div class="logo-login">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group">
          <input type="email"
                 name="email"
                 placeholder="Email Address"
                 value="{{ old('email') }}"
                 required
                 class="@error('email') input-error @enderror @error('error') input-error @enderror">
        </div>

<div class="password-wrapper">
  <input type="password"
         id="password"
         name="password"
         placeholder="Password"
         minlength="6"
         required
         class="@error('password') input-error @enderror @error('error') input-error @enderror">

  <span class="toggle-eye" onclick="togglePassword()">
      <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#7d7d7d" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
        <circle cx="12" cy="12" r="3"/>
      </svg>

      <svg id="eye-close" style="display:none" xmlns="http://www.w3.org/2000/svg"
          fill="none" stroke="#7d7d7d" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7
                 a21.4 21.4 0 012.64-3.38m3.06-2.52A10.94 10.94 0 0112 5
                 c7 0 11 7 11 7a21.4 21.4 0 01-2.56 3.38"/>
        <line x1="1" y1="1" x2="23" y2="23"/>
      </svg>
  </span>
</div>


<p class="forgot-password">
 <a href="{{ route('password.request') }}">Forgot Password?</a>
</p>


        <!-- Login Button -->
        <button type="submit" class="login-btn">Login</button>
      </form>

      <!-- Register Link -->
      @if(!isset($role) || $role != 2)
        <p class="register-link">
          Don’t have an account?
          <a href="{{ route('register') }}">Register</a>
        </p>
      @endif

    </div>
  </div>

  <!-- Bottom Toast (Error) -->
  @if ($errors->any())
    <div id="global-toast" class="alert-toast alert-error show toast-bottom" role="alert">
      {{ $errors->first() }}
    </div>
  @endif

<script>

  /* ===============================
     AUTO-HIDE TOAST
     =============================== */
  (function() {
    const toast = document.getElementById('global-toast');
    if (!toast) return;

    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 450);
    }, 3500);
  })();

  /* ===============================
     TOGGLE PASSWORD VISIBILITY
     =============================== */
  function togglePassword() {
    const password = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClose = document.getElementById('eye-close');

    if (password.type === "password") {
      password.type = "text";
      eyeOpen.style.display = "none";
      eyeClose.style.display = "block";
    } else {
      password.type = "password";
      eyeOpen.style.display = "block";
      eyeClose.style.display = "none";
    }
  }
</script>


</body>
</html>
