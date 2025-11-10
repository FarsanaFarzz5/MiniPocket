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

      <!-- Invalid Credentials Alert -->
      @if ($errors->has('error'))
        <div class="alert-error" role="alert">
          {{ $errors->first('error') }}
        </div>
      @endif

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group">
          <input type="email" name="email" placeholder="Email Address"
                 value="{{ old('email') }}" required
                 class="@error('error') input-error @enderror @error('email') input-error @enderror">
          @error('email')
            <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <input type="password" name="password" placeholder="Password"
                 minlength="6" required
                 class="@error('error') input-error @enderror @error('password') input-error @enderror">
          @error('password')
            <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <!-- Login Button -->
        <button type="submit" class="login-btn">Login</button>
      </form>

<!-- Register Link -->
@if(!isset($role) || $role != 2)
  <p class="register-link">
    Don’t have an account? <a href="{{ route('register') }}">Register</a>
  </p>
@endif


    </div>
  </div>
</body>
</html>
