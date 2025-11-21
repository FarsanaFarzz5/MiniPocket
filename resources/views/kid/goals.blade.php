<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>🎯 My Goals – Mini Pocket</title>

  <!-- ✅ Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- ✅ Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- ✅ Font Awesome (AWARD ICON FIXED) -->
<!-- ✅ Font Awesome Latest Working CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- ✅ Your custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

  <!-- ================================
        🌟 YOUR PAGE CSS STARTS HERE
  ================================= -->
  <style>

/* ===== Base Reset ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* ===== Base Fix ===== */
html, body {
  height: 100%;
  width: 100%;
  background: #f9f9f9;
  overflow: hidden;           /* ✅ Prevent outer scroll */
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

/* ✅ Container stays fixed in center */
.container {
  width: 100%;
  max-width: 420px;
  height: 100dvh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  position: relative;
  margin: 0 auto;
}

/* ✅ Scrollable inner section */
.inner-container {
  flex: 1;
  width: 100%;
  overflow-y: auto;
  padding: 16px 20px 70px;
  position: relative;
  z-index: 1;
  scroll-behavior: smooth;
}

/* Optional soft scrollbar */
.inner-container::-webkit-scrollbar {
  width: 6px;
}
.inner-container::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.15);
  border-radius: 4px;
}

/* 🎯 HEADER */
.headers {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 22px;
}

.headers h1 {
  font-size: 18px;
  font-weight: 700;
  background: linear-gradient(135deg, #23a541, #33c56c);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* 📊 STATS CARDS */
.stats {
  display: flex;
  gap: 12px;
  justify-content: space-between;
  margin-bottom: 24px;
}

.stat-card {
  flex: 1;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  border: 1px solid #e2e8f0;
  padding: 14px 10px;
  text-align: center;
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.stat-card h3 {
  font-size: 13px;
  font-weight: 600;
  color: #000;
  margin-bottom: 6px;
}

.stat-card p {
  font-size: 14px;
  font-weight: 600;
  color: #000;
}

/* ➕ ADD GOAL BUTTON */
.add-goal-btn {
  display: block;
  width: 100%;
  background: linear-gradient(135deg, #23a541, #33c56c);
  color: #fff;
  font-weight: 600;
  text-align: center;
  padding: 14px 0;
  border: none;
  border-radius: 16px;
  font-size: 14px;
  margin-bottom: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.add-goal-btn:hover {
  transform: translateY(-2px);
  background: linear-gradient(90deg, #059669, #10b981);
}

/* 🧩 POPUP FORM */
.popup {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  display: none;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.4);
  z-index: 9999;
}

.popup.active { display: flex; }

.popup-content {
  background: #fff;
  border-radius: 20px;
  width: 90%;
  max-width: 360px;
  padding: 22px 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  animation: slideUp 0.4s ease forwards;
  position: relative;
  z-index: 10000;
}

body.popup-open .inner-container,
body.popup-open .container {
  pointer-events: none;
  user-select: none;
}

body.popup-open #goalPopup,
body.popup-open #goalPopup * {
  pointer-events: auto !important;
}


@keyframes slideUp {
  from { transform: translateY(50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.popup-content h2 {
  font-size: 16px;
  font-weight: 600;
  color: #065f46;
  text-align: center;
  margin-bottom: 14px;
}

.popup-content input {
  width: 100%;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1.5px solid #a7f3d0;
  font-size: 13px;
  margin-bottom: 10px;
}

.popup-content button[type="submit"] {
  width: 100%;
  background: linear-gradient(135deg, #23a541, #33c56c);
  border: none;
  color: #fff;
  font-weight: 600;
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
}

.close-btn {
  position: absolute;
  top: 8px;
  right: 12px;
  background: none;
  border: none;
  font-size: 22px;
  color: #888;
  cursor: pointer;
}

/* 🏷 GOAL LIST CARD */
.goal-card {
  background: #fff;
  border-radius: 16px;
  padding: 14px 16px;
  margin-bottom: 18px;
  border: 1px solid #e2e8f0;
  transition: all 0.2s ease;
  cursor: pointer;
}

.goal-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.goal-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.goal-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.goal-left .num { font-weight: 500; width: 20px; text-align: right; }
.goal-left .title { font-size: 14px; font-weight: 600; color: #333; }
.goal-right p { font-size: 13px; color: #065f46; margin: 0; }
.goal-right .target { color: #94a3b8; font-size: 12px; }

.empty {
  text-align: center;
  color: #94a3b8;
  font-size: 14px;
  margin-top: 20px;
}

/* ✅ Toast Alert Message */
.alert-toast {
  width: 85%;
  max-width: 360px;
  position: fixed;
  bottom: 80px; /* ⬇️ default resting position */
  left: 50%;
  transform: translateX(-30%) translateY(10px); /* starts slightly below */
  padding: 12px 18px;
  background: #333;
  color: #fff;
  font-size: 14px;
  font-weight: 500;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.5s ease, transform 0.5s ease;
  z-index: 9999;
}

/* ✅ When Toast Appears */
.alert-toast.show {
  opacity: 1;
  visibility: visible;
  transform: translateX(-50%) translateY(0); /* slides up smoothly */
}

/* ✅ Success Style */
.alert-success {
  background: linear-gradient(135deg, #22c55e, #16a34a);
}

/* ❌ Error Style */
.alert-error {
  background: linear-gradient(135deg, #ef4444, #dc2626);
}


/* 🌟 Goal Highlights (Horizontal Scroll Bar) */
.goal-highlights {
  margin-top: 10px;
  overflow-x: auto;
  white-space: nowrap;
  padding: 8px 2px 18px;
}

.goal-highlights::-webkit-scrollbar {
  height: 4px;
}

.goal-highlights::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.15);
  border-radius: 4px;
}

/* Wrapper */
.highlight-wrapper {
  display: flex;
  gap: 17px;
}

/* Individual Highlight Item */
.highlight {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 80px;
  text-align: center;
  cursor: pointer;
}

/* ➕ Add Goal Circle */
.add-circle {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  border: 1px dashed #23a541;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 28px;
  color: #23a541;
}

.goal-gold {
  position: relative;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(180deg, #FFE8B0 0%, #F4A52D 100%);
  border: 3px solid #F4C879;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.goal-gold::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: radial-gradient(circle at center,
             rgba(255,255,255,0.45),
             transparent 60%);
  z-index: 1;
}

.goal-gold i {
  position: relative;
  z-index: 5;
  color: #ffffff !important;
  font-size: 26px;
}

/* Silver */
.goal-silver {
  position: relative;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(180deg, #E3E6E8 0%, #C5C8CA 100%);
  border: 3px solid #D5D5D5;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.goal-silver::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: radial-gradient(circle at center,
             rgba(255,255,255,0.45),
             transparent 60%);
  z-index: 1;
}

.goal-silver i {
  position: relative;
  z-index: 5;
  color: #ffffff !important;
  font-size: px;
}

/* -----------------------------
   🟤 Perfect Bronze (Matches Gold & Silver)
-------------------------------- */
/* ---------------------------------
   🟤 Subtle Bronze (Soft + Premium)
----------------------------------*/
.goal-bronze {
  position: relative;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(180deg, #F2E1C6 0%, #C9A27A 100%);
  border: 3px solid #E6D3B8;  /* soft border */
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

/* same shine */
.goal-bronze::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: radial-gradient(circle at center,
      rgba(255, 255, 255, 0.40),
      transparent 60%);
  z-index: 1;
}

/* icon */
.goal-bronze i {
  position: relative;
  z-index: 5;
  color: #ffffff !important;
  font-size: 30px;
}


/* Text Under Circle */
.highlight p {
  font-size: 12px;
  font-weight: 600;
  margin-top: 6px;
}

/* Status Text */
.highlight .status {
  font-size: 10px;
  margin-top: 3px;
  font-weight: 600;
}



/* Smooth scroll for highlights */
.goal-highlights::-webkit-scrollbar {
  height: 4px;
}
.goal-highlights::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.15);
  border-radius: 4px;
}


/* ---------------------------------
   ⭐ Updated Goal Highlight Icons
----------------------------------*/

/* Gold Circle (On Progress + Completed) */
.goal-gold {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(180deg, #FFE8B0 0%, #F4A52D 100%);
  border: 3px solid #F4C879;
  display: flex;
  justify-content: center;
  align-items: center;
}

.goal-gold i {
  font-size: 30px;
  color: #ffffff;
}

/* Silver Circle (Paid) */
.goal-silver {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  background: linear-gradient(180deg, #E3E6E8 0%, #C5C8CA 100%);
  border: 3px solid #D5D5D5;
  display: flex;
  justify-content: center;
  align-items: center;
}

.goal-silver i {
  font-size: 30px;
  color: #ffffff;
}

/* Toggle Switch */
.switch {
  position: relative;
  display: inline-block;
  width: 46px;
  height: 24px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 24px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background: #23a541;
}

input:checked + .slider:before {
  transform: translateX(22px);
}

.toggle-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 10px 0 15px 0;
}

.toggle-label {
  font-size: 13px;
  font-weight: 600;
  color: #065f46;
  margin: 5px;
}

.upload-label {
  font-size: 12px;
  color: #666;
  margin: 6px 0;
  display: block;
}

/* ============================================================
   💚 PERFECT GREEN THEME TOGGLE TABS
   Matches your entire design system
==============================================================*/

.toggle-tabs {
  width: 100%;
  display: flex;
  justify-content: center;
  gap: 12px;
  margin: 10px 0 25px;
}

.toggle-tabs .tab {
  padding: 10px 45px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  background: #f2f2f2;
  color: #2c3e50;
  border: 1.6px solid #dcdcdc;
  text-decoration: none;
  transition: 0.25s ease-in-out;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* 💚 Active tab (Green) */
.toggle-tabs .tab.active {
  background: linear-gradient(135deg, #23a541, #33c56c);
  border-color: #23a541;
  color: white;
  box-shadow: 0 3px 8px rgba(76,175,80,0.30);
}

/* Hover effect */
.toggle-tabs .tab:hover {
  transform: translateY(-2px);
}

.football-highlight {
  background: #F7FCF9 !important;   /* ultra soft white+green tint */
  border: 1px solid #E3F2EA !important; /* very subtle green border */
  
}

.football-highlight .num {
  color: #0F8A4A !important; /* soft deep green */
  font-weight: 600;
}

.football-highlight .title {
  color: #0F8A4A !important; /* premium dark mint green */
  font-weight: 600;
}

.football-highlight .goal-right p strong {
  color: #0E7A41 !important; /* richer green for amount */
  font-weight: 700;
}

.football-highlight .goal-right .target {
  color: #6FAF8C !important; /* subtle mint grey */
  font-weight: 500;
}

.football-highlight .goal-item {
  padding: 4px 2px; /* more breathable layout */
}


@media (max-width: 420px) {
  html, body { align-items: flex-start; }
  .container { height: 100svh; }
}



  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.profile')
      @include('header')

      <!-- Toggle Tabs -->
<div class="toggle-tabs">
  <a href="{{ route('kid.goals') }}" class="tab active">Goals</a>
  <a href="{{ route('kid.gifts') }}" class="tab">Gifts</a>
</div>

      <div class="headers"><h1>My Goals</h1></div>

      @php
    // after refund/reset, totals should become 0 automatically
    $savedTotal  = $goals->sum('saved_amount');
    $targetTotal = $goals->sum('target_amount');
@endphp


      <!-- ✅ Stats -->
<div class="stats">
  <div class="stat-card">
    <h3>Total</h3>
    <p>{{ count($goals) }}</p>  <!-- Only active goals -->
  </div>
  <div class="stat-card">
    <h3>Saved ₹</h3>
    <p>{{ number_format($goals->sum('saved_amount')) }}</p>
  </div>
  <div class="stat-card">
    <h3>Target ₹</h3>
    <p>{{ number_format($goals->sum('target_amount')) }}</p>
  </div>
</div>




<!-- ✅ Popup Form -->
<div class="popup" id="goalPopup">
  <div class="popup-content">
    <button class="close-btn" onclick="closeGoalPopup()">✖</button>

    <h2>Create New Goal</h2>

    <form action="{{ route('goals.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <input type="text" name="title" placeholder="Goal title" required>

      <input type="text" name="target_amount"
             placeholder="Target amount (₹)"
             inputmode="numeric"
             pattern="[0-9]*"
             oninput="this.value = this.value.replace(/[^0-9]/g, '')"
             required>

     

      <!-- ⭐ Hide from Parent Toggle -->
      <div class="toggle-row">
        <label class="toggle-label">Hide from Parent</label>
        <label class="switch">
          <input type="checkbox" name="is_hidden" value="1">
          <span class="slider round"></span>
        </label>
      </div>

      <button type="submit">Add Goal</button>
    </form>
  </div>
</div>


<!-- 🌟 Goal Highlights Section -->
<div class="goal-highlights">
  <div class="highlight-wrapper">

    <!-- Add Goal -->
    <div class="highlight add-highlight" onclick="openGoalPopup()">
      <div class="add-circle">
        <i class="bi bi-plus-lg"></i>
      </div>
      <p>Add Goal</p>
    </div>

    <!-- ⭐ Active Goals (Now SILVER for status 0 & 1) -->
    @foreach ($goals->where('is_locked', 0) as $goal)


      <div class="highlight"
     @if($goal->is_locked == 1)
         onclick="return false"
     @else
         onclick="window.location.href='{{ route('goals.details', $goal->id) }}'"
     @endif>


    @if ($goal->status == 0)
        <div class="goal-silver">
            <i class="fa-solid fa-award"></i>
        </div>
        <p>{{ $goal->title }}</p>
        <span class="status" style="color:#23a541;">On Progress</span>

    @elseif ($goal->status == 1)
        <div class="goal-bronze">
            <i class="fa-solid fa-award"></i>
        </div>
        <p>{{ $goal->title }}</p>
        <span class="status" style="color:#23a541;">Completed</span>
    @endif
</div>

    @endforeach

    <!-- ⭐ Paid Goals (Now GOLD for status 2) -->
    @foreach ($paidGoals as $goal)
      <div class="highlight">

        <div class="goal-gold">
          <i class="fa-solid fa-award"></i>
        </div>

        <p>{{ $goal->title }}</p>
        <span class="status" style="color:#23a541;">Paid</span>
      </div>
    @endforeach

  </div>
</div>

<!-- ✅ Goal List -->


@php
    $sortedGoals = $goals->sortByDesc('status')->values();
    $visibleGoals = $sortedGoals->where('is_locked', 0);
@endphp

@forelse ($visibleGoals as $index => $goal)

    <div class="goal-card"
         @if($goal->is_locked == 1) onclick="return false"
         @else onclick="window.location.href='{{ route('goals.details', $goal->id) }}'"
         @endif>

        <div class="goal-item">
            <div class="goal-left">
                <span class="num">{{ $index + 1 }}.</span>
                <span class="title">{{ $goal->title }}</span>
            </div>

            <div class="goal-right">
                <p><strong>₹{{ number_format($goal->saved_amount,2) }}</strong></p>
                <p class="target">Target ₹{{ number_format($goal->target_amount,2) }}</p>
            </div>
        </div>

    </div>

@empty
    <p class="empty">No goals found.</p>
@endforelse



    </div>
    <div id="alertToast" class="alert-toast"></div>
  </div>

<script>

// ✅ Open Popup
function openGoalPopup() {
  document.getElementById('goalPopup').classList.add('active');
  document.body.classList.add('popup-open');  // 🔥 Disable background
}

// ✅ Close Popup
function closeGoalPopup() {
  document.getElementById('goalPopup').classList.remove('active');
  document.body.classList.remove('popup-open'); // 🔥 Re-enable background
}


// ✅ Toast function
const toast = document.getElementById("alertToast");

function showToast(message, type = "success") {
  toast.innerText = message;
  toast.className = `alert-toast show alert-${type}`;

  setTimeout(() => {
    toast.classList.remove("show");
  }, 2500);
}

// ✅ Show success alert after adding goal
@if (session('success'))
  document.addEventListener("DOMContentLoaded", () => {
    showToast("{{ session('success') }}", "success");
  });
@endif

// ✅ Show error alert (optional)
@if (session('error'))
  document.addEventListener("DOMContentLoaded", () => {
    showToast("{{ session('error') }}", "error");
  });
@endif

</script>

</body>
</html>