<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/resetpassword.css') }}">
</head>

<style>
/* ===========================
   BACK TO LOGIN - TEXT LINK
=========================== */
.back-login {
  margin-top: 5px;
  text-align: center;      /* SAME alignment as Forgot Password */
  margin-right: 5px;
}

.back-login-link {
  font-size: 14px;
  color: #555;
  text-decoration: none;
  font-weight: 400;
}

.back-login-link:hover {
  color: #e05500;
}
</style>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <h1>Forgot Password</h1>

      <!-- Success -->
      @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
      @endif

      <!-- Error -->
      @if ($errors->any())
        <div class="alert error">
            {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="reset-form">
        @csrf

        <input type="email" name="email" placeholder="Enter your email" required>

        <button type="submit">Send Reset Link</button>
      </form>

      <p class="back-login">
<a href="{{ route('login.form') }}" class="back-login-link">← Back to Login</a>

</p>

    </div>
  </div>
</body>
</html>
