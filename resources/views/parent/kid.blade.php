<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kid Management - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/addkid.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kiddetails.css') }}">
  
  <style>
    /* Keep both sections stacked but toggle hidden */
    #addKidSection, #kidDetailsSection {
      display: none;
      width: 100%;
    }
    #addKidSection.active, #kidDetailsSection.active {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">
      
      @include('sidebar.sidebar')
      @include('headerparent')

      <!-- ✅ Toggle Buttons -->
      <div class="toggle-wrapper">
        <button id="toggleAddKid" class="toggle-btn active">Add Kid</button>
        <button id="toggleKidDetails" class="toggle-btn">Kid Details</button>
      </div>

      <!-- ✅ ADD KID SECTION -->
      <div id="addKidSection" class="active">
        <h1>Kid Account</h1>
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

      <!-- ✅ KID DETAILS SECTION -->
      <div id="kidDetailsSection">
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
      </div>
    </div>

    <!-- ✅ Alert Toast -->
    <div id="alertToast" class="alert-toast"></div>
  </div>

  <!-- ✅ Scripts -->
  <script src="{{ asset('assets/js/addkid.js') }}"></script>
  <script src="{{ asset('assets/js/kiddetails.js') }}"></script>

  <script>
    // Toggle between Add Kid and Kid Details (no reload)
    const addBtn = document.getElementById('toggleAddKid');
    const detailBtn = document.getElementById('toggleKidDetails');
    const addSection = document.getElementById('addKidSection');
    const detailSection = document.getElementById('kidDetailsSection');

    addBtn.addEventListener('click', () => {
      addBtn.classList.add('active');
      detailBtn.classList.remove('active');
      addSection.classList.add('active');
      detailSection.classList.remove('active');
    });

    detailBtn.addEventListener('click', () => {
      detailBtn.classList.add('active');
      addBtn.classList.remove('active');
      detailSection.classList.add('active');
      addSection.classList.remove('active');
    });
  </script>
</body>
</html>
