<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kid Management - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="format-detection" content="telephone=no,email=no,address=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- ✅ Sidebar + Layout -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
/* ===========================================================
🌟 GLOBAL RESET
=========================================================== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

html, body {
  width: 100%;
  height: 100%;
  background: #ffffff;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  overflow-x: hidden;
  -webkit-overflow-scrolling: touch;
}

body {
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: -webkit-fill-available;
  -webkit-overflow-scrolling: touch;
}

/* ===========================================================
🧱 MAIN CONTAINER (Fixed frame — Non-scrollable)
=========================================================== */
.container {
  width: 100%;
  max-width: 420px;
  height: 100dvh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  padding: 0 22px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  overflow: hidden;
  z-index: 1;
}

/* ===========================================================
🧭 INNER CONTAINER (Scrolls independently)
=========================================================== */
.inner-container {
  width: 100%;
  flex: 1;
  text-align: center;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  padding: 0 0 100px;
  scroll-behavior: smooth;
}

@supports (padding: max(0px)) {
  .inner-container {
    padding-bottom: max(100px, env(safe-area-inset-bottom));
  }
}

/* ===========================================================
🎨 PAGE HEADING
=========================================================== */
h1 {
  text-align: center;
  font-size: 17px;
  font-weight: 600;
  color: #2c3e50;
  text-transform: capitalize;
  margin: 25px 0 25px;
}

/* ===========================================================
✅ TOGGLE SWITCH (Add Kid / Kid Details)
=========================================================== */
.toggle-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
  background: #fff;
  padding: 12px 16px;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
  margin: 0 auto 24px auto;
  width: 96%;
  max-width: 400px;
}

.toggle-btn {
  flex: 1;
  text-align: center;
  padding: 10px 0;
  border-radius: 10px;
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  color: #555;
  background: #f4f4f4;
  border: 1px solid #eee;
  transition: all 0.3s ease;
}

.toggle-btn:hover {
  background: #ffe5cc;
  color: #ff7a00;
}

.toggle-btn.active {
  background: linear-gradient(135deg, #ff8a00, #ff5f00);
  color: #fff;
  border: none;
  box-shadow: 0 3px 10px rgba(255,138,0,0.3);
}

/* ===========================================================
🎨 FORM INPUTS
=========================================================== */
.kid-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 18px;
  text-align: left;
  margin-bottom: 50px;
}

.row-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.floating-group input,
.floating-group select {
  width: 100%;
  height: 50px;
  padding: 14px;
  border: 1.6px solid #e4e4e4;
  border-radius: 10px;
  font-size: 15px;
  color: #222;
  background: #fff;
  transition: border-color 0.25s, box-shadow 0.25s;
}

.floating-group input:focus,
.floating-group select:focus {
  border-color: #f4731d;
  box-shadow: 0 0 0 3px rgba(244, 115, 29, 0.1);
  outline: none;
}

/* ===========================================================
🧒 AVATAR SECTION
=========================================================== */
.avatar-row {
  display: flex;
  justify-content: center;
  gap: 34px;
  flex-wrap: wrap;
  margin-top: 10px;
}

.avatar-option {
  width: 64px;
  height: 64px;
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
}

.avatar-option.selected {
  border-color: #f4731d;
  box-shadow: 0 0 8px rgba(244, 115, 29, 0.5);
  transform: scale(1.05);
}

/* ===========================================================
✅ BUTTONS
=========================================================== */
button, .btn {
  display: block;
  width: 100%;
  padding: 14px 0;
  background: linear-gradient(135deg, #f4731d, #ff9240);
  color: #fff;
  font-size: 15px;
  font-weight: 600;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  box-shadow: 0 6px 15px rgba(244, 115, 29, 0.3);
  transition: all 0.3s ease;
}

button:hover, .btn:hover {
  background: linear-gradient(135deg, #e8680d, #f68832);
  transform: translateY(-2px);
}

/* ===========================================================
🌟 KID DETAILS LIST
=========================================================== */
.kid-card {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 14px;
  border: 1px solid #e7e7e7;
  border-radius: 10px;
  background: #fbfbfb;
  margin-bottom: 12px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.kid-card.active {
  background: #fff;
  border-color: #f4731d;
  box-shadow: 0 4px 10px rgba(244, 115, 29, 0.08);
}

.details {
  background: #fff;
  border-radius: 12px;
  padding: 16px;
  width: 100%;
  margin-bottom: 16px;
  text-align: left;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  display: none;
}

/* ===========================================================
📱 MOBILE RESPONSIVENESS
=========================================================== */
@media (max-width: 480px) {
  html, body {
    overflow: hidden;
    height: 100%;
  }
  .container {
    height: 100dvh;
    position: fixed;
  }
  .inner-container {
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
  }
}
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')
      @include('headerparent')

      <!-- ✅ Toggle -->
      <div class="toggle-wrapper">
        <a href="#addkid" class="toggle-btn active" id="btnAddKid">Add Kid</a>
        <a href="#details" class="toggle-btn" id="btnDetails">Kid Details</a>
      </div>

      <!-- ✅ Add Kid Section -->
      <section id="addKidSection">
        <h1>Kid Account</h1>
        <form id="kidForm" class="kid-form" method="POST" action="{{ route('kids.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row-2">
            <div class="floating-group">
              <input type="text" name="first_name" placeholder="Child Name" required>
            </div>
            <div class="floating-group">
              <input type="date" name="dob" placeholder="Date of Birth" required>
            </div>
          </div>
          <div class="floating-group">
            <input type="text" name="phone_no" placeholder="Mobile Number" maxlength="10" required>
          </div>
          <div class="floating-group">
            <input type="email" name="email" placeholder="Email" required>
          </div>
          <div class="floating-group">
            <select name="gender" required>
              <option value="" disabled selected hidden>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="avatar-row">
            @foreach(['avathar1.png','avathar2.png','avathar3.png','avathar4.png'] as $avatar)
              <label class="avatar-option">
                <input type="radio" name="avatar_choice" value="{{ $avatar }}" hidden>
                <img src="{{ asset('images/'.$avatar) }}" alt="Avatar">
              </label>
            @endforeach
          </div>
          <p id="avatarError" style="text-align:center;"></p>
          <button type="submit">Save</button>
        </form>
      </section>

      <!-- ✅ Kid Details Section -->
      <section id="detailsSection" style="display:none;">
        <h1>{{ $user->first_name }}’s Kids</h1>
        @if($children->count() > 0)
          @foreach($children as $index => $child)
            <div class="kid-card" data-index="{{ $index }}">
              <div class="kid-left">
                @if($child->profile_img)
                  <img src="{{ asset('storage/' . $child->profile_img) }}" alt="{{ $child->first_name }}">
                @else
                  <img src="{{ asset('images/default-profile.png') }}" alt="Profile">
                @endif
                <div class="kid-info">
                  <div class="name">{{ ucfirst($child->first_name) }}</div>
                  <div class="gender">{{ ucfirst($child->gender ?? 'N/A') }}</div>
                </div>
              </div>
              <div class="amount-box">
                <div class="amount">₹{{ $child->daily_limit ?? 0 }}</div>
                <div class="limit-label">Money Limit</div>
              </div>
            </div>

            <div class="details" id="details-{{ $index }}">
              <p><strong>Name:</strong> {{ $child->first_name }} {{ $child->second_name ?? '' }}</p>
              <p><strong>Email:</strong> {{ $child->email }}</p>
              <p><strong>Phone:</strong> {{ $child->phone_no ?? 'N/A' }}</p>
              <p><strong>Date of Birth:</strong> {{ $child->dob ?? 'N/A' }}</p>
              <p><strong>Gender:</strong> {{ ucfirst($child->gender ?? 'N/A') }}</p>
              <p class="balance-line"><strong>Balance:</strong> ₹{{ $child->balance ?? 0 }}</p>
              <form method="POST" action="{{ route('kids.set.limit', $child->id) }}">
                @csrf
                <input type="number" name="daily_limit" min="0" placeholder="Enter new limit" required class="input-box">
                <button type="submit" class="btn">Set Limit</button>
              </form>
            </div>
          @endforeach
        @else
          <p class="empty">No kids added yet.</p>
        @endif
      </section>

    </div>
  </div>

  <script>
  // Toggle AddKid / Details
  document.getElementById('btnAddKid').addEventListener('click', () => {
    document.getElementById('addKidSection').style.display = 'block';
    document.getElementById('detailsSection').style.display = 'none';
    document.getElementById('btnAddKid').classList.add('active');
    document.getElementById('btnDetails').classList.remove('active');
  });

  document.getElementById('btnDetails').addEventListener('click', () => {
    document.getElementById('addKidSection').style.display = 'none';
    document.getElementById('detailsSection').style.display = 'block';
    document.getElementById('btnDetails').classList.add('active');
    document.getElementById('btnAddKid').classList.remove('active');
  });
  </script>

  <script src="{{ asset('assets/js/addkid.js') }}"></script>
  <script src="{{ asset('assets/js/kiddetails.js') }}"></script>
</body>
</html>
