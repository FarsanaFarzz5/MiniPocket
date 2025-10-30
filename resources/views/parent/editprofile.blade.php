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
  <link rel="stylesheet" href="{{ asset('assets/css/editprofile.css') }}">


</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')

      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <h1>Edit Profile</h1>
<form id="profileForm" method="POST" action="{{ route('parent.update.profile') }}" class="profile-form" novalidate>

  @csrf

  <div class="row-2">
    <div class="floating-group">
      <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required>
      <label for="first_name">First Name</label>
    </div>

    <div class="floating-group">
      <input type="text" name="second_name" id="second_name" value="{{ old('second_name', $user->second_name) }}">
      <label for="second_name">Last Name</label>
    </div>
  </div>

  <div class="floating-group">
    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
    <label for="email">Email Address</label>
  </div>

  <div class="floating-group">
    <input type="tel" name="phone_no" id="phone_no" maxlength="10" value="{{ old('phone_no', $user->phone_no) }}">
    <label for="phone_no">Phone Number</label>
  </div>

  <div class="floating-group">
    <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}">
    <label for="dob">Date of Birth</label>
  </div>

  <button type="submit">Update Profile</button>

 
</form>

 
    </div>
  </div>
<div id="alertToast" class="alert-toast"></div>
<script src="{{ asset('assets/js/editprofile.js') }}"></script>

</body>
</html>
