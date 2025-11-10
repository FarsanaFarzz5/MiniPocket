<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set Password - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/resetpassword.css') }}">
 
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Title -->
      <h1>Set Your Password</h1>

      <!-- Validation Errors -->
      @if ($errors->any())
        <div class="alert">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Reset Password Form -->
      <form method="POST" action="{{ route('kid.resetpassword.submit', ['token' => $token]) }}" class="reset-form">
        @csrf

        <input type="email" value="{{ $email }}" disabled placeholder="Email">

        <input type="password" name="password" placeholder="New Password" required>

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <button type="submit">Set Password</button>
      </form>
    </div>
  </div>
</body>
</html>
