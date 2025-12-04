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

    /* ===========================================================
🔔 CUSTOM ALERT TOAST (Matches your Mini Pocket theme)
=========================================================== */
.alert-toast {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%) translateY(120%);
  width: 88%;
  max-width: 360px;
  padding: 14px 20px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 500;
  color: #fff;
  text-align: center;
  background: linear-gradient(135deg, #f4731d, #ff9240);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.18);
  opacity: 0;
  z-index: 99999;
  pointer-events: none;
  transition: all 0.4s ease;
}

/* Slide Up Animation */
.alert-toast.show {
  transform: translateX(-50%) translateY(0);
  opacity: 1;
}

/* SUCCESS TOAST */
.alert-success {
  background: linear-gradient(135deg, #2ecc71, #4be08c);
}

/* WARNING / ERROR TOAST */
.alert-warning {
  background: linear-gradient(135deg, #f4731d, #ff9240);
}

/* MOBILE FIX */
@media (max-width: 480px) {
  .alert-toast {
    width: 92%;
    font-size: 13px;
    bottom: 18px;
  }
}

/* ===========================================================
📌 FULL ERROR ALERT BOX (Appears after mistake)
=========================================================== */
.full-alert-box {
  width: 100%;
  padding: 14px 16px;
  background: #fff3e4;
  border-left: 5px solid #f4731d;
  border-radius: 12px;
  color: #4a4a4a;
  font-size: 14px;
  margin-bottom: 18px;
  line-height: 1.55;
  box-shadow: 0 4px 12px rgba(0,0,0,0.07);
  animation: slideDown 0.35s ease;
}

@keyframes slideDown {
  from { opacity: 0; transform: translateY(-8px); }
  to   { opacity: 1; transform: translateY(0); }
}

.full-alert-box strong {
  color: #d65a00;
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

      <!-- Title -->
      <h1>Set Your Password</h1>

      <div id="full-error-box" class="full-alert-box" style="display:none;">
  <strong>Password Requirements:</strong><br>
  • Must contain at least <b>1 uppercase</b><br>
  • Must contain at least <b>1 lowercase</b><br>
  • Must contain at least <b>1 digit</b><br>
  • Must contain at least <b>1 special character</b><br>
  • Must be <b>minimum 6 characters</b>
</div>


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

        <!-- NEW PASSWORD -->
        <div class="password-wrapper">
          <input type="password" id="kid-password" name="password" placeholder="New Password" required>

          <span class="toggle-eye"
            onclick="togglePassword('kid-password','eye-open-1','eye-close-1')">

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
          <input type="password" id="kid-confirm-password" name="password_confirmation"
                 placeholder="Confirm Password" required>

          <span class="toggle-eye"
            onclick="togglePassword('kid-confirm-password','eye-open-2','eye-close-2')">

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
  // Toggle Password Visibility
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

  /* ===============================
      PASSWORD VALIDATION
  ================================ */
  const form = document.querySelector(".reset-form");
  const errorBox = document.getElementById("full-error-box");

  form.addEventListener("submit", function (e) {
    const password = document.getElementById("kid-password").value;
    const confirmPassword = document.getElementById("kid-confirm-password").value;

    // Hide error box initially
    errorBox.style.display = "none";

    // Validation Rules
    const rules = {
      uppercase: /[A-Z]/,
      lowercase: /[a-z]/,
      digit: /[0-9]/,
      special: /[!@#$%^&*(),.?":{}|<>]/,
      length: /.{6,}/   // minimum 6 characters
    };

    // Validate password
    if (
      !rules.uppercase.test(password) ||
      !rules.lowercase.test(password) ||
      !rules.digit.test(password) ||
      !rules.special.test(password) ||
      !rules.length.test(password)
    ) {
      e.preventDefault();
      errorBox.style.display = "block";  // Show big alert box
      return;
    }

    // Password match validation
    if (password !== confirmPassword) {
      e.preventDefault();
      errorBox.style.display = "block";  // Same alert box shows
      return;
    }
  });
</script>


</body>
</html>
