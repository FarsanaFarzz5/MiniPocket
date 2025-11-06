<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Kid - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kidedit.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- ✅ Sidebar -->
      @include('sidebar.profile')

      <!-- ✅ Header -->
      @include('header')

      <!-- ✅ Page Title -->
      <h1>Edit Kid Profile</h1>

      <form class="kid-form" method="POST" action="{{ route('kid.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Profile Picture -->
        <div class="profile-preview" onclick="openFilePicker(event)">
          <img id="profileImage"
               src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}"
               alt="Profile Image">
          <div class="edit-icon" onclick="openFilePicker(event)">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 24 24">
              <path d="M12 9a3 3 0 100 6 3 3 0 000-6zm9-3h-3.17l-.83-1.5A2 2 0 0015.17 4H8.83a2 2 0 00-1.83 1.5L6.17 6H3a2 2 0 00-2 2v10a2 2 0 002 2h18a2 2 0 002-2V8a2 2 0 00-2-2zm0 12H3V8h18v10z"/>
            </svg>
          </div>
          <input type="file" name="profile_img" id="profile_img" accept="image/*" onchange="previewImage(event)">
        </div>

        <!-- Full Name -->
        <div class="field">
          <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" readonly placeholder=" ">
          <label>Full Name</label>
        </div>

        <!-- Phone Number -->
        <div class="field">
          <input type="tel" name="phone_no" value="{{ old('phone_no', $user->phone_no) }}" readonly placeholder=" ">
          <label>Phone Number</label>
        </div>

        <!-- Date of Birth -->
        <div class="field">
          <input type="date" name="dob" value="{{ old('dob', $user->dob) }}" readonly placeholder=" ">
          <label>Date of Birth</label>
        </div>

        <!-- Gender -->
        <div class="field">
          <select name="gender" disabled>
            <option value="male" {{ old('gender', $user->gender)=='male'?'selected':'' }}>Male</option>
            <option value="female" {{ old('gender', $user->gender)=='female'?'selected':'' }}>Female</option>
            <option value="other" {{ old('gender', $user->gender)=='other'?'selected':'' }}>Other</option>
          </select>
          <label>Gender</label>
        </div>

        <!-- Submit Button -->
        <button id="updateBtn" type="submit">Update Profile Picture</button>
      </form>

      <!-- 🔹 Logout Section -->
      <div class="logout-section">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="logout-icon">
      
          <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>

    </div>

    <!-- ✅ Sidebar Overlay -->
    <div id="sidebarOverlay"></div>
  </div>

  <script src="{{ asset('assets/js/kidedit.js') }}"></script>
</body>
</html>
