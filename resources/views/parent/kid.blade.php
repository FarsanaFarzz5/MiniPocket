

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kid Management - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">





  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">


  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/addkid.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kiddetails.css') }}">

  <script src="{{ asset('assets/js/addkid.js') }}"></script>
  <script src="{{ asset('assets/js/kiddetails.js') }}"></script>
  
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
/* ===========================================================
 FIX MISALIGNMENT: Make both buttons same height, top aligned
=========================================================== */
.kid-actions {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 12px !important;
    width: 100%;
    margin-top: 10px;
}

.kid-btn {
    flex: 1 !important;
    max-width: 48% !important;
    padding: 12px 0 !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 6px !important;
    height: 46px !important; /* 🔥 Fix uneven height */
    margin: 0 !important;    /* 🔥 Remove any extra margin affecting one button */
    box-sizing: border-box !important;
}

/* Remove any margin from inner icons or text */
.kid-btn i {
    margin: 0 !important;
    padding: 0 !important;
    text-decoration: none;
}

/* POPUP OVERLAY */
.limit-popup-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.25);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 16px;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

/* POPUP BOX */
.limit-popup-box {
    width: 92%;
    max-width: 360px;
    background: #fff;
    border-radius: 22px;
    padding: 26px 22px;
    text-align: center;
    animation: popupFade 0.25s ease-out;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

@keyframes popupFade {
    from { transform: scale(0.92); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}


.limit-popup-box h2 {
    font-size: 20px;
    font-weight: 600;
    margin-top: 6px;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.limit-popup-box p {
    font-size: 14px;
    color: #555;
    line-height: 1.45;
    margin-bottom: 22px;
}

/* OK BUTTON */
.limit-save-btn {
    width: 100%;
    background: #ff8a00;
    border: none;
    padding: 12px 0;
    border-radius: 12px;
    color: #fff;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
}


/* CIRCLE */
.tick-circle {
    width: 58px;
    height: 58px;
    background: #ff8a00;
    border-radius: 50%;
    margin: 0 auto 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    animation: iconPop 0.28s ease-out;
    box-shadow: 0 4px 14px rgba(255,138,0,0.28);
}

/* THIN, CLEAN TICK */
.tick {
    width: 22px;
    height: 12px;
    border-bottom: 3px solid #fff;
    border-left: 3px solid #fff;
    transform-origin: left bottom;
    transform: rotate(-45deg) scale(0);
    opacity: 0;
}

.animateTick {
    animation: drawTick 0.35s ease-out forwards;
}


/* ICON POP */
@keyframes iconPop {
    0% { transform: scale(0.5); opacity: 0; }
    60% { transform: scale(1.15); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}

/* TICK DRAW */
@keyframes drawTick {
    0% { transform: rotate(-45deg) scale(0); opacity: 0; }
    100% { transform: rotate(-45deg) scale(1); opacity: 1; }
}

.highlight-email {
    color: #ff8a00;
    font-weight: 600;
    background: rgba(255, 138, 0, 0.12);
    padding: 4px 8px;
    border-radius: 8px;
    display: block;
    width: fit-content;
    margin: 8px auto 0 auto;
    text-align: center;
}

.success-tick {
    width: 22px;
    height: 12px;
    border-bottom: 3px solid #fff;
    border-left: 3px solid #fff;
    transform-origin: left bottom;
    transform: rotate(-45deg) scale(0);
    opacity: 0;
}

.animateTick {
    animation: drawTick 0.35s ease-out forwards;
}


</style>
</head>

<body>
  <div class="container">

     @include('sidebar.sidebar')
    <div class="inner-container">
      
     
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
            <input type="tel" name="phone_no" id="phone_no" placeholder="Mobile Number"
       maxlength="10" pattern="[0-9]*" inputmode="numeric" required>

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

            <div class="details" id="details-{{ $index }}" style="display:none;">
                <div class="kid-actions">

                    <a href="{{ route('kids.edit', $child->id) }}" class="kid-btn edit-btn">
                       <i class="ri-pencil-line"></i> Edit
                    </a>

                    <button onclick="openLimitPopup({{ $child->id }}, '{{ $child->first_name }}')"
                            class="kid-btn limit-btn">
                        <i class="ri-timer-line"></i> Limit
                    </button>

                </div>
            </div>

        @endforeach

    @else

        <!-- ⭐ Beautiful Empty Card -->
        <div class="empty-box" style="margin-top: 10px;">
            <h4 class="empty-title">Kid Details</h4>
            <p class="empty-msg">No kids added yet.</p>
        </div>

    @endif
</div>


</div>
<div id="alertToast" class="alert-toast"></div>

  <script>
    window.existingAllEmails = @json($allEmails);
</script>

<script>
// ============================================================
// 1️⃣ TAB TOGGLE — Add Kid / Kid Details
// ============================================================
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

// ============================================================
// 2️⃣ AVATAR SELECTION
// ============================================================
document.querySelectorAll(".avatar-option").forEach(option => {
    option.addEventListener("click", function () {

        document.querySelectorAll(".avatar-option").forEach(o =>
            o.classList.remove("selected")
        );

        this.classList.add("selected");
        this.querySelector("input").checked = true;

        document.getElementById("avatarError").textContent = "";
    });
});

// ============================================================
// 3️⃣ EMAIL VALIDATION (CHECK DUPLICATE EMAILS)
// existingAllEmails comes from backend: window.existingAllEmails
// ============================================================
document.getElementById("email").addEventListener("input", function () {

    const email = this.value.trim().toLowerCase();
    const errorBox = document.getElementById("alertToast");

    if (window.existingAllEmails.includes(email)) {
        errorBox.innerHTML = "❌ Email already exists!";
        errorBox.classList.add("show");
    } else {
        errorBox.classList.remove("show");
    }
});

// ============================================================
// 4️⃣ DELETE POPUP — Opens custom popup
// ============================================================



document.getElementById("").addEventListener("", function () {

});


// ============================================================
// 5️⃣ DAILY LIMIT POPUP
// ============================================================
function openLimitPopup(kidId, kidName) {
    document.getElementById("limitKidName").textContent = "Set Daily Limit for " + kidName;
    document.getElementById("limitPopup").style.display = "flex";
    document.getElementById("limitForm").action = `/kids/${kidId}/set-limit`;
}

function closeLimitPopup() {
    document.getElementById("limitPopup").style.display = "none";
}

// ============================================================
// 6️⃣ SUCCESS POPUP — Kid Added
// ============================================================
document.addEventListener("DOMContentLoaded", function() {
    @if(session('kid_added'))
        const popup = document.getElementById("kidAddedPopup");
        const tick = document.querySelector(".success-tick");


        popup.style.display = "flex";

        // SMALL DELAY so browser registers the display change
        setTimeout(() => {
            tick.classList.add("animateTick");
        }, 50);
    @endif
});


function closeKidAddedPopup() {
    document.getElementById("kidAddedPopup").style.display = "none";
}

// ============================================================
// 7️⃣ KID CARD — Expand/Collapse Details
// ============================================================
document.querySelectorAll(".kid-card").forEach(card => {
    card.addEventListener("click", function () {
        const index = this.dataset.index;
        const details = document.getElementById("details-" + index);

        // Toggle display
        details.style.display = details.style.display === "block" ? "none" : "block";
    });
});
</script>

<!-- DAILY LIMIT POPUP -->
  <div id="limitPopup" class="limit-popup-overlay" style="display:none;">
    <div class="limit-popup-box">
        <h2 id="limitKidName">Set Daily Limit</h2>

        <!-- ⭐ Add description here -->
        <p class="limit-description">
            Set a daily spending limit for your child. This helps them manage money wisely.
        </p>

        <form id="limitForm" method="POST">
            @csrf
            <input type="number" 
       name="daily_limit" 
       id="dailyLimitInput"
       placeholder="Enter Daily Limit"
       min="0"
       inputmode="numeric"
       pattern="[0-9]*"
       required />


            <div class="limit-popup-actions">
                <button type="submit" class="limit-save-btn" style="box-shadow: 0.5px">Save Limit</button>
                <button type="button" class="limit-close-btn" onclick="closeLimitPopup()" style="box-shadow: 0.5px">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- KID ADDED SUCCESS POPUP -->
<div id="kidAddedPopup" class="limit-popup-overlay" style="display:none;">
    <div class="limit-popup-box">

        <!-- Highlight Icon -->
     <div class="popup-success-icon">
   <div class="tick-circle">
    <div class="success-tick"></div>
</div>
</div>

        <h2>Kid Added Successfully</h2>

      <p class="limit-description">
    The kid account has been created.  
    Login instructions have been sent to 
    <span class="highlight-email">{{ session('kid_email') }}</span>
</p>
<button type="button"
                class="limit-save-btn"
                onclick="closeKidAddedPopup()">
            OK
</button>
    </div>
</div>
</body> 
</html>
