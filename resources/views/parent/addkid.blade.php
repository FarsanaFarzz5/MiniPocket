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
  <link rel="stylesheet" href="{{asset('assets/css/addkid.css')}}">
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
          <input type="text" name="phone_no" id="phone_no" placeholder="Mobile Number" maxlength="10">
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

<script src="{{ asset('assets/js/addkid.js') }}"></script>

</body>
</html>
