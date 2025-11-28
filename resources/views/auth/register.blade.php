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

  <style>
.password-wrapper {
  position: relative;
  width: 100%;
}

.password-wrapper input {
  width: 100%;
  padding-right: 45px !important;
}

.toggle-eye {
  position: absolute;
  right: 15px;
  top: 38%;
  transform: translateY(-50%);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
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
      <div class="logo-register">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Register Form -->
      <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="name-row">
          <input type="text" id="first_name" name="first_name" placeholder="First Name"
                 value="{{ old('first_name') }}" required>
          <input type="text" id="second_name" name="second_name" placeholder="Second Name"
                 value="{{ old('second_name') }}" required>
        </div>

        <input type="email" name="email" placeholder="Email"
               value="{{ old('email') }}" required>

      <input type="tel" name="phone_no" id="phone_no"
       placeholder="Phone"
       value="{{ old('phone_no') }}"
       required 
       inputmode="numeric"
       maxlength="10"
       pattern="[0-9]*">


        <!-- PASSWORD -->
        <div class="password-wrapper">
          <input type="password" id="reg-password" name="password"
                 placeholder="Password" required>

          <span class="toggle-eye" onclick="togglePassword('reg-password','eye-open-1','eye-close-1')">
            <svg id="eye-open-1" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#7d7d7d" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>

            <svg id="eye-close-1" style="display:none" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#7d7d7d" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7
                       a21.4 21.4 0 012.64-3.38m3.06-2.52A10.94 10.94 0 0112 5
                       c7 0 11 7 11 7a21.4 21.4 0 01-2.56 3.38"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
          </span>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="password-wrapper">
          <input type="password" id="reg-confirm-password" name="password_confirmation"
                 placeholder="Confirm Password" required>

          <span class="toggle-eye" onclick="togglePassword('reg-confirm-password','eye-open-2','eye-close-2')">
            <svg id="eye-open-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#7d7d7d"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>

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

        <button type="submit" class="register-btn">Register</button>
      </form>

      <p class="login-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
      </p>
    </div>
  </div>

  <!-- Toast -->
  @if ($errors->any())
    <div id="global-toast" class="alert-toast alert-error show toast-bottom">
      {{ $errors->first() }}
    </div>
  @elseif (session('success'))
    <div id="global-toast" class="alert-toast alert-success show toast-bottom">
      {{ session('success') }}
    </div>
  @endif

<script>
/* =======================
   EYE TOGGLE FUNCTION
======================= */
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

/* =======================
   PHONE NUMBER LIVE VALIDATION
======================= */

// Allow only digits while typing
document.getElementById("phone_no").addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9]/g, ""); 
});

/* =======================
   FORM VALIDATION
======================= */
document.getElementById("registerForm").addEventListener("submit", function(event) {

  const firstName = document.getElementById("first_name").value.trim();
  const secondName = document.getElementById("second_name").value.trim();
  const phone = document.getElementById("phone_no").value.trim();
  const password = document.getElementById("reg-password").value;
  const confirmPassword = document.getElementById("reg-confirm-password").value;

  const nameRegex = /^[A-Za-z]+$/;
  const passwordRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^(){}[\]<>.+-=])[A-Za-z\d@$!%*?&#^(){}[\]<>.+-=]{6,}$/;

  /* NAME VALIDATION */
  if (!nameRegex.test(firstName)) {
    showAlert("First name should contain only alphabets.");
    event.preventDefault();
    return;
  }

  if (!nameRegex.test(secondName)) {
    showAlert("Second name should contain only alphabets.");
    event.preventDefault();
    return;
  }

  /* PHONE NUMBER VALIDATION */
  if (phone.length !== 10) {
    showAlert("Phone number must contain exactly 10 digits.");
    event.preventDefault();
    return;
  }

  /* PASSWORD VALIDATION */
  if (!passwordRegex.test(password)) {
    showAlert("Password must contain uppercase, lowercase, number, special character and 6+ characters.");
    event.preventDefault();
    return;
  }

  if (password !== confirmPassword) {
    showAlert("Passwords do not match.");
    event.preventDefault();
    return;
  }
});

/* =======================
   CUSTOM ALERT (matches UI)
======================= */
function showAlert(message) {
  let toast = document.createElement("div");
  toast.className = "alert-toast alert-error show toast-bottom";
  toast.innerText = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 450);
  }, 3000);
}
</script>


</body>
</html>
