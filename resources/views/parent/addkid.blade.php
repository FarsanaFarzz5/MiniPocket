<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Kid - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Layout & Sidebar -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
  /* ✅ Base Reset */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  /* ✅ BODY (same as Edit Profile) */
  body {
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100%;
    min-height: -webkit-fill-available;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
  }

  /* ✅ CONTAINER */
  .container {
    width: 100%;
    max-width: 420px;
    min-height: 100vh;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    padding: 20px 24px 20px !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow-y: auto;
    z-index: 1;
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
  }

  /* ✅ Form */
  .kid-form {
    width: 100%;
    display: grid;
    gap: 14px;
    text-align: left;
    margin-bottom: -8px;
  }

  .kid-form .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .kid-form input,
  .kid-form select {
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

  .kid-form input::placeholder {
    color: #bfbfbf;
  }

  .kid-form input:focus,
  .kid-form select:focus {
    border-color: #f4731d;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(244,115,29,.15);
  }

  /* ✅ Make select field text and placeholder consistent with inputs */
.kid-form select {
  width: 100%;
  height: 48px;
  padding: 0 14px;
  border: 1px solid #e7e7e7;
  border-radius: 10px;
  font-size: 14px;
  background-color: #fff;
  color: #222; /* normal text color */
  transition: border-color 0.2s, box-shadow 0.2s;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,<svg width='12' height='8' xmlns='http://www.w3.org/2000/svg'><path d='M1 1l5 5 5-5' stroke='%238c8c8c' stroke-width='2' fill='none' stroke-linecap='round'/></svg>");
  background-repeat: no-repeat;
  background-position: right 14px center;
  background-size: 12px 8px;
}

/* ✅ Make placeholder (Select Gender) look gray like input placeholders */
.kid-form select:invalid {
  color: #bfbfbf; /* same as placeholder color */
}

/* ✅ When user selects a gender, text becomes dark */
.kid-form select:valid {
  color: #222;
}

/* ✅ Focus styling same as input */
.kid-form select:focus {
  border-color: #f4731d;
  box-shadow: 0 0 0 3px rgba(244,115,29,.15);
  outline: none;
}
  /* ✅ Date Wrapper */
  .date-wrapper {
    position: relative;
    width: 100%;
  }

  .date-wrapper input[type="date"] {
    width: 100%;
    height: 48px;
    padding: 0 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    font-size: 14px;
    background-color: #fff;
    color: transparent;
    appearance: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .date-wrapper .date-placeholder {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #bfbfbf;
    font-size: 14px;
    pointer-events: none;
    transition: 0.2s ease;
  }

  .date-wrapper input[type="date"]:focus + .date-placeholder,
  .date-wrapper input[type="date"]:valid + .date-placeholder {
    opacity: 0;
    visibility: hidden;
  }

  .date-wrapper input[type="date"]:focus {
    border-color: #f4731d;
    box-shadow: 0 0 0 3px rgba(244,115,29,.15);
    color: #222;
  }

  .date-wrapper input[type="date"]:valid {
    color: #222;
  }

  /* ✅ Avatar Section */
  .avatar-row {
    display: flex;
    justify-content: center;
    gap: 36px;
    flex-wrap: wrap;
  }

  .avatar-option {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid #e5e5e5;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .avatar-option img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .avatar-option.selected {
    border-color: #f4731d;
    box-shadow: 0 0 8px rgba(244,115,29,0.5);
    transform: scale(1.05);
  }

  /* ✅ Button */
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
    margin: 15px auto 0;
    box-shadow: 0 5px 10px rgba(244,115,29,0.3);
    transition: all 0.3s ease;
  }

  button:hover {
    background: #e25f00;
    transform: translateY(-2px);
  }

  .error-text {
    color: #d93025;
    font-size: 13px;
    margin-top: 4px;
    margin-left: 5px;
  }

  #avatarError {
    display: none;
  }

  /* ✅ Responsive */
  @media (max-width: 480px) {
    body { align-items: flex-start; }
    .container {
      max-width: 100%;
      border-radius: 0;
      box-shadow: none;
      padding-bottom: 80px;
    }
    h1 { font-size: 15px; }
    .avatar-option { width: 50px; height: 50px; }
    button { font-size: 14px; padding: 11px 0; border-radius: 8px; }
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

      <h1>Add Kid Account</h1>

      <form id="kidForm" class="kid-form" method="POST" action="{{ route('kids.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row-2">
          <div>
            <input type="text" name="first_name" id="first_name" placeholder="Child Name" required>
            <p class="error-text" id="nameError"></p>
          </div>
          <div class="date-wrapper">
            <input type="date" name="dob" id="dob" required onfocus="this.showPicker && this.showPicker()">
            <span class="date-placeholder">Date of Birth</span>
            <p class="error-text" id="dobError"></p>
          </div>
        </div>

        <div>
          <input type="text" name="phone_no" id="phone_no" placeholder="Mobile Number">
          <p class="error-text" id="phoneError"></p>
        </div>

        <div>
          <input type="email" name="email" id="email" placeholder="Email" required>
          <p class="error-text" id="emailError"></p>
        </div>

        <div>
          <select name="gender" id="gender" required>
            <option value="" disabled selected hidden>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <p class="error-text" id="genderError"></p>
        </div>

        <div class="avatar-row" id="avatarRow">
          @foreach(['avathar1.png','avathar2.png','avathar3.png','avathar4.png'] as $avatar)
            <label class="avatar-option">
              <input type="radio" name="avatar_choice" value="{{ $avatar }}" hidden>
              <img src="{{ asset('images/'.$avatar) }}" alt="Avatar">
            </label>
          @endforeach
        </div>
        <p class="error-text" id="avatarError" style="text-align:center;"></p>

        <button type="submit">Save</button>
      </form>
    </div>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const avatarOptions = document.querySelectorAll(".avatar-option");
    avatarOptions.forEach(option => {
      option.addEventListener("click", function() {
        avatarOptions.forEach(opt => opt.classList.remove("selected"));
        this.classList.add("selected");
        this.querySelector("input").checked = true;
      });
    });

    // ✅ Auto-scroll focused input into view (fixes keyboard overlap)
    const inputs = document.querySelectorAll("input, select");
    inputs.forEach(input => {
      input.addEventListener("focus", () => {
        setTimeout(() => {
          input.scrollIntoView({ behavior: "smooth", block: "center" });
        }, 300);
      });
    });

    // ✅ Validation
    document.getElementById("kidForm").addEventListener("submit", function(e) {
      let valid = true;
      document.querySelectorAll(".error-text").forEach(el => el.textContent = "");

      const name = document.getElementById("first_name").value.trim();
      const dob = document.getElementById("dob").value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = document.getElementById("phone_no").value.trim();
      const gender = document.getElementById("gender").value;
      const avatarSelected = document.querySelector('input[name="avatar_choice"]:checked');

      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      const phonePattern = /^[0-9]{10}$/;

      if (name === "") {
        document.getElementById("nameError").textContent = "Child name is required.";
        valid = false;
      }

      if (dob === "") {
        document.getElementById("dobError").textContent = "Date of birth is required.";
        valid = false;
      }

      if (email === "") {
        document.getElementById("emailError").textContent = "Email is required.";
        valid = false;
      } else if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent = "Enter a valid email address.";
        valid = false;
      }

      if (phone !== "" && !phonePattern.test(phone)) {
        document.getElementById("phoneError").textContent = "Enter a valid 10-digit number.";
        valid = false;
      }

      if (!gender) {
        document.getElementById("genderError").textContent = "Please select gender.";
        valid = false;
      }

      if (!avatarSelected) {
        document.getElementById("avatarError").textContent = "Please select an avatar.";
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  });
  </script>
</body>
</html>
