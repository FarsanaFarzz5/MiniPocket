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
  <link rel="stylesheet" href="{{ asset('assets/css/addkid.css') }}">
</head>

<body>
  
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')
      @include('headerparent')

      <!-- ✅ Toggle Switch -->
      <div class="toggle-wrapper">
        <a href="{{ route('parent.addkid') }}" 
           class="toggle-btn {{ request()->routeIs('parent.addkid') ? 'active' : '' }}">
          Add Kid
        </a>
        <a href="{{ route('parent.kiddetails') }}" 
           class="toggle-btn {{ request()->routeIs('parent.kiddetails') ? 'active' : '' }}">
          Kid Details
        </a>
      </div>

      <h1>kid Account</h1>

      <form id="kidForm" class="kid-form" method="POST" action="{{ route('kids.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row-2">
          <div class="floating-group">
            <input type="text" name="first_name" id="first_name" placeholder="Child Name" required>
          </div>

          <div class="floating-group">
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" required>
          </div>
        </div>

        <div class="floating-group">
          <input type="text" name="phone_no" id="phone_no" placeholder="Mobile Number" maxlength="10" required>
        </div>

        <div class="floating-group">
          <input type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="floating-group">
          <select name="gender" id="gender" required>
            <option value="" disabled selected hidden>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
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

    <!-- ✅ Alert Toast -->
    <div id="alertToast" class="alert-toast"></div>
  </div>

  <script src="{{ asset('assets/js/addkid.js') }}"></script>
</body>
</html>
