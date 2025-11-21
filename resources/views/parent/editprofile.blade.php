<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700&display=swap" rel="stylesheet">

  <!-- Layout + Sidebar -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/editprofile.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')

     @include('headerparent')

      <!-- ✅ Heading -->
      <h1>Edit Profile</h1>



     <form id="profileForm" method="POST" action="{{ route('parent.update.profile') }}" class="profile-form">
    @csrf
        <div class="row-2">
          <div class="floating-group">
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required placeholder="First Name">
          </div>

          <div class="floating-group">
            <input type="text" name="second_name" id="second_name" value="{{ old('second_name', $user->second_name) }}" placeholder="Last Name">
          </div>
        </div>

        <div class="floating-group">
          <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required placeholder="Email Address">
        </div>

        <div class="floating-group">
          <input type="tel" name="phone_no" id="phone_no" maxlength="10" value="{{ old('phone_no', $user->phone_no) }}" placeholder="Phone Number">
        </div>

        {{-- <div class="floating-group">
          <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" placeholder="Date of Birth">
        </div> --}}

        <button type="submit">Update Profile</button>
      </form>

      <!-- 🔹 Logout -->
      <div class="logout-section">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="logout-icon">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>

    </div>
  </div>

  <div id="alertToast" class="alert-toast"></div>

  <script src="{{ asset('assets/js/editprofile.js') }}"></script>
  <script>
  @if(session('success'))
      showToast("{{ session('success') }}", "success");
  @endif
</script>
</body>
</html>
