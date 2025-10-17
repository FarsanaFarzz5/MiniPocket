<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mini Pocket - Register</title>
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
      <div class="logo-register">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Register Form -->
      <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="name-row">
          <input type="text" name="first_name" placeholder="First Name"
                 value="{{ old('first_name') }}" required
                 pattern="[A-Za-z]+" title="Only letters allowed">
          <input type="text" name="second_name" placeholder="Second Name"
                 value="{{ old('second_name') }}" required
                 pattern="[A-Za-z]+" title="Only letters allowed">
        </div>
        @error('first_name') <p class="error-text">{{ $message }}</p> @enderror
        @error('second_name') <p class="error-text">{{ $message }}</p> @enderror

        <input type="email" name="email" placeholder="Email"
               value="{{ old('email') }}" required>
        @error('email') <p class="error-text">{{ $message }}</p> @enderror

 <input type="text" 
       name="phone_no" 
       placeholder="Phone" 
       value="{{ old('phone_no') }}" 
       required 
       pattern="[0-9]{10}" 
       maxlength="10" 
       title="Enter a valid 10-digit number">
        @error('phone_no') <p class="error-text">{{ $message }}</p> @enderror

        <input type="password" name="password" placeholder="Password"
               minlength="6" required>
        <input type="password" name="password_confirmation"
               placeholder="Confirm Password" minlength="6" required>
        @error('password') <p class="error-text">{{ $message }}</p> @enderror

        <button type="submit" class="register-btn">Register</button>
      </form>

      <!-- Login Link -->
      <p class="login-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
      </p>
    </div>
  </div>

  <!-- ✅ Perfect viewport height fix -->
  <script>
    function updateViewportHeight() {
      const vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
    updateViewportHeight();
    window.addEventListener('resize', updateViewportHeight);
    window.addEventListener('orientationchange', updateViewportHeight);
  </script>
</body>
</html>
