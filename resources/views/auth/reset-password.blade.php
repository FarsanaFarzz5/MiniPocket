<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set Password - Mini Pocket</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/resetpassword.css') }}">

  <style>
    /* Eye Toggle Wrapper */
    .password-wrapper {
      position: relative;
      width: 100%;
    }

    .password-wrapper input {
      width: 100%;
      padding-right: 45px !important; /* space for eye icon */
    }

    .toggle-eye {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .toggle-eye svg {
      width: 22px;
      height: 22px;
      stroke: #7d7d7d7a;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <h1>Set Your Password</h1>

      <!-- Errors -->
      @if ($errors->any())
        <div class="alert error">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" class="reset-form">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <input type="email" name="email" placeholder="Email" value="{{ request()->email }}" required>

        <!-- NEW PASSWORD -->
        <div class="password-wrapper">
          <input type="password" id="new-password" name="password" placeholder="New Password" required>

          <span class="toggle-eye"
            onclick="togglePassword('new-password','eye-open-1','eye-close-1')">

            <!-- Eye Open -->
            <svg id="eye-open-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                 stroke="#7d7d7d" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>

            <!-- Eye Close -->
            <svg id="eye-close-1" style="display:none" xmlns="http://www.w3.org/2000/svg"
                 fill="none" stroke="#7d7d7d" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7
                       a21.4 21.4 0 012.64-3.38m3.06-2.52A10.94 10.94 0 0112 5
                       c7 0 11 7 11 7a21.4 21.4 0 01-2.56 3.38"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>

          </span>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="password-wrapper">
          <input type="password" id="confirm-password" name="password_confirmation"
                 placeholder="Confirm Password" required>

          <span class="toggle-eye"
            onclick="togglePassword('confirm-password','eye-open-2','eye-close-2')">

            <!-- Eye Open -->
            <svg id="eye-open-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                 stroke="#7d7d7d" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>

            <!-- Eye Close -->
            <svg id="eye-close-2" style="display:none" xmlns="http://www.w3.org/2000/svg"
                 fill="none" stroke="#7d7d7d" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7
                       a21.4 21.4 0 012.64-3.38m3.06-2.52A10.94 10.94 0 0112 5
                       c7 0 11 7 11 7a21.4 21.4 0 01-2.56 3.38"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>

          </span>
        </div>

        <button type="submit">Set Password</button>
      </form>
    </div>
  </div>

<script>
  function togglePassword(inputId, eyeOpenId, eyeCloseId) {
    const field = document.getElementById(inputId);
    const openIcon = document.getElementById(eyeOpenId);
    const closeIcon = document.getElementById(eyeCloseId);

    if (field.type === "password") {
      field.type = "text";
      openIcon.style.display = "none";
      closeIcon.style.display = "block";
    } else {
      field.type = "password";
      openIcon.style.display = "block";
      closeIcon.style.display = "none";
    }
  }
</script>

</body>
</html>
