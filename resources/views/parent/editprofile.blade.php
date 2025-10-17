<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Sidebar + Parent Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  body {
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100%;
    min-height: -webkit-fill-available;
    overflow-y: auto;
  }

  .container {
    width: 100%;
    max-width: 420px;
    min-height: 100vh;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    padding: 20px 24px 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow-y: auto;
  }

  .inner-container {
    width: 100%;
    text-align: center;
  }

  .logo-section {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 8px;
    margin-bottom: 10px;
    position: relative;
    z-index: 2;
  }

  .logo-section img {
    width: 75px;
    height: auto;
    display: block;
    margin: 0 auto;
    filter: brightness(1.1) saturate(1.1);
    transition: transform 0.3s ease;
  }

  .logo-section img:hover {
    transform: scale(1.05);
  }

  h1 {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 22px;
    text-transform: capitalize;
  }

  .profile-form {
    width: 100%;
    display: grid;
    gap: 14px;
    text-align: left;
  }

  .profile-form .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .profile-form input {
    width: 100%;
    height: 48px;
    padding: 0 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    color: #222;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .profile-form input::placeholder {
    color: #bfbfbf;
    font-weight: 400;
  }

  .profile-form input:focus {
    border-color: #f4731d;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(244,115,29,.15);
  }

  /* ✅ Error message style */
  .error-message {
    color: #e63946;
    font-size: 13px;
    margin-top: 2px;
    margin-left: 5px;
  }

  button {
    display: block;
    width: 100%;
    padding: 13px 0;
    background: #f4731d;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin: 10px auto;
    box-shadow: 0 5px 10px rgba(244, 115, 29, 0.3);
    transition: all 0.3s ease;
  }

  button:hover {
    background: #e25f00;
    transform: translateY(-2px);
  }

  input[type="date"] {
    width: 100%;
    height: 48px;
    padding: 0 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    font-size: 14px;
    color: #222;
    text-align: left !important;
    direction: ltr;
    appearance: none;
    background-color: #fff;
  }

  input[type="date"]::-webkit-datetime-edit,
  input[type="date"]::-webkit-datetime-edit-text,
  input[type="date"]::-webkit-datetime-edit-month-field,
  input[type="date"]::-webkit-datetime-edit-day-field,
  input[type="date"]::-webkit-datetime-edit-year-field {
    text-align: left !important;
  }

  @media (max-width: 480px) {
    .form-section { width: 90%; margin: 0 auto; }
    h1 { font-size: 15px; }
    button { font-size: 14px; padding: 11px 0; border-radius: 8px; }
    input[type="date"] { font-size: 13px; height: 46px; }
  }

  /* ========================= FIX DATE FIELD ALIGNMENT ========================= */
input[type="date"] {
  width: 100%;
  height: 48px;
  padding: 0 14px;
  border: 1px solid #e7e7e7;
  border-radius: 10px;
  font-size: 14px;
  color: #222;
  background-color: #fff;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  text-align: left;          /* ✅ ensures text starts from left */
  text-align-last: left;     /* ✅ keeps alignment consistent */
  direction: ltr;
}

/* ✅ specifically target iOS Safari and Chrome mobile */
input[type="date"]::-webkit-datetime-edit-fields-wrapper {
  text-align: left;
}

input[type="date"]::-webkit-datetime-edit,
input[type="date"]::-webkit-datetime-edit-text,
input[type="date"]::-webkit-datetime-edit-month-field,
input[type="date"]::-webkit-datetime-edit-day-field,
input[type="date"]::-webkit-datetime-edit-year-field {
  text-align: left !important;
  display: inline-block;
}

/* remove inner padding and arrows if necessary */
input[type="date"]::-webkit-calendar-picker-indicator {
  margin-right: 10px;
}




  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')

      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <h1>Edit Profile</h1>

      <form id="profileForm" method="POST" action="{{ route('parent.update.profile') }}" class="profile-form">
        @csrf

        <div class="row-2">
          <div>
            <input type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" required>
            <div class="error-message" id="firstNameError"></div>
          </div>
          <div>
            <input type="text" name="second_name" id="second_name" placeholder="Second Name" value="{{ old('second_name', $user->second_name) }}">
            <div class="error-message" id="secondNameError"></div>
          </div>
        </div>

        <div>
          <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
          <div class="error-message" id="emailError"></div>
        </div>

        <div>
          <input type="tel" name="phone_no" id="phone_no" placeholder="Phone Number" value="{{ old('phone_no', $user->phone_no) }}">
          <div class="error-message" id="phoneError"></div>
        </div>

        <div>
          <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}">
          <div class="error-message" id="dobError"></div>
        </div>

        <button type="submit">Update Profile</button>
      </form>
    </div>
  </div>
</body>

<script>
  // Clear & restore input value logic
  const inputs = document.querySelectorAll('.profile-form input');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.dataset.value = this.value;
      this.value = '';
    });
    input.addEventListener('blur', function() {
      if (this.value === '') {
        this.value = this.dataset.value;
      }
    });
  });

  // ✅ Validation logic
  document.getElementById('profileForm').addEventListener('submit', function(e) {
    let valid = true;

    // Clear previous messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    const firstName = document.getElementById('first_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone_no').value.trim();
    const dob = document.getElementById('dob').value.trim();

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    const phonePattern = /^[0-9]{10}$/;

    if (firstName === '') {
      document.getElementById('firstNameError').textContent = 'First name is required.';
      valid = false;
    }

    if (email === '') {
      document.getElementById('emailError').textContent = 'Email is required.';
      valid = false;
    } else if (!emailPattern.test(email)) {
      document.getElementById('emailError').textContent = 'Enter a valid email.';
      valid = false;
    }

    if (phone === '') {
      document.getElementById('phoneError').textContent = 'Phone number is required.';
      valid = false;
    } else if (!phonePattern.test(phone)) {
      document.getElementById('phoneError').textContent = 'Enter a valid 10-digit number.';
      valid = false;
    }

    if (dob === '') {
      document.getElementById('dobError').textContent = 'Date of birth is required.';
      valid = false;
    }

    if (!valid) e.preventDefault();
  });
</script>
</html>
