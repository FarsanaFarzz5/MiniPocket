<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Kid - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">

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
    min-height: 100vh; /* ✅ allow scroll when keyboard opens */
    overflow-y: auto;  /* ✅ enable scrolling */
  }

  .container {
    width: 100%;
    max-width: 420px;
    min-height: 100vh;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 16px 20px 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }

  .inner-container {
    width: 100%;
    text-align: center;
  }

  /* ✅ Hamburger Header */
  .header-bar {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    margin-bottom: 10px;
  }

  .menu-icon {
    width: 26px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    margin-top: 4px;
    margin-left: 6px;
  }

  .menu-icon div {
    width: 100%;
    height: 3px;
    background-color: #bfbfbf;
    border-radius: 2px;
    transition: all 0.3s ease;
  }

  .menu-icon:hover div:nth-child(1) { width: 70%; }
  .menu-icon:hover div:nth-child(3) { width: 70%; }

  /* Logo */
  .logo-section {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 6px;
    margin-bottom: 10px;
  }
  .logo-section img { width: 65px; transition: transform 0.3s ease; }
  .logo-section img:hover { transform: scale(1.05); }

  h1 {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 16px;
  }

  /* Profile image */
  .profile-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
  }

  .profile-preview img {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    border: 2px solid #4caf50;
    object-fit: cover;
    cursor: pointer;
    transition: 0.3s ease;
  }
  .profile-preview img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(76,175,80,0.3);
  }
  input[type="file"] { display: none; }

  /* ✅ Form layout and spacing */
  .kid-form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 16px;
    text-align: left;
  }

  .kid-form input,
  .kid-form select {
    width: 100%;
    height: 44px;
    padding: 0 12px;
    border: 1px solid #e7e7e7;
    border-radius: 8px;
    font-size: 13px;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .kid-form input:focus,
  .kid-form select:focus {
    border-color: #4caf50;
    outline: none;
    box-shadow: 0 0 0 3px rgba(76,175,80,.15);
  }

  /* ✅ Fixed Left Alignment for Date Field */
  input[type="date"] {
    text-align: left !important;
    text-align-last: left !important;
    direction: ltr !important;
    -webkit-appearance: none;
    appearance: none;
    color: #222;
    font-size: 13px;
    padding-left: 10px;
  }

  input[type="date"]::-webkit-datetime-edit,
  input[type="date"]::-webkit-datetime-edit-text,
  input[type="date"]::-webkit-datetime-edit-month-field,
  input[type="date"]::-webkit-datetime-edit-day-field,
  input[type="date"]::-webkit-datetime-edit-year-field {
    text-align: left !important;
    padding-left: 5px;
  }

  button {
    width: 100%;
    padding: 10px 0;
    background: #4caf50;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
    box-shadow: 0 3px 8px rgba(76,175,80,0.3);
    transition: all 0.3s ease;
  }

  button:hover {
    background: #43a047;
    transform: translateY(-2px);
  }

  /* Sidebar inside container */
#kidSidebarMenu {
  position: absolute;
  top: 0;
  left: -240px;
  width: 220px;
  height: 100%;
  background: #ffffff;
  box-shadow: 3px 0 12px rgba(0,0,0,0.08);
  transition: left 0.3s ease;
  z-index: 20; /* above content */
}

#kidSidebarMenu.open {
  left: 0;
}

/* Overlay stays inside the container */
#sidebarOverlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.35);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 15;
}

#sidebarOverlay.show {
  opacity: 1;
  visibility: visible;
}

  @media (max-width: 480px) {
    .container { max-width: 100%; box-shadow: none; border-radius: 0; }
    h1 { font-size: 14px; margin-bottom: 12px; }
    .profile-preview img { width: 78px; height: 78px; }
    button { font-size: 13px; padding: 9px 0; }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- ✅ Hamburger Menu Icon -->
      <div class="header-bar">
        <div id="kidMenuToggle" class="menu-icon">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>

       @include('sidebar.profile')

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Title -->
      <h1>Edit Kid Profile</h1>

      <!-- Form -->
      <form class="kid-form" method="POST" action="{{ route('kid.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Profile Preview -->
        <div class="profile-preview">
          <img id="profileImage"
               src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}"
               alt="Profile Image"
               onclick="document.getElementById('profile_img').click()">
          <input type="file" name="profile_img" id="profile_img" accept="image/*" onchange="previewImage(event)">
        </div>

        <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" required>
        <input type="tel" name="phone_no" placeholder="Phone Number" value="{{ old('phone_no', $user->phone_no) }}">
        <input type="date" name="dob" value="{{ old('dob', $user->dob) }}">
        <select name="gender" style="color: #222">
          <option value="" disabled {{ !$user->gender ? 'selected' : '' }}>Select Gender</option>
          <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
          <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
          <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
        </select>

        <button type="submit">Update Profile</button>
      </form>
    </div>
  </div>


  <script>
  // Profile Image Preview
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
      document.getElementById('profileImage').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  // Sidebar Toggle
  document.addEventListener('DOMContentLoaded', function() {
    const kidMenuToggle = document.getElementById('kidMenuToggle');
    const kidSidebarMenu = document.getElementById('kidSidebarMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (kidMenuToggle && kidSidebarMenu && sidebarOverlay) {
      kidMenuToggle.addEventListener('click', () => {
        kidSidebarMenu.classList.toggle('open');
        sidebarOverlay.classList.toggle('show');
      });

      sidebarOverlay.addEventListener('click', () => {
        kidSidebarMenu.classList.remove('open');
        sidebarOverlay.classList.remove('show');
      });
    }
  });
  </script>
</body>
</html>
