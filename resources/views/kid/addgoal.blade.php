<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>🎯 My Goals – Mini Pocket</title>

  <!-- ✅ Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

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
  z-index: 50;
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
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
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


/* 🌟 Goal Highlights (Instagram-style) */
.goal-highlights {
  margin-top: 10px;
  overflow-x: auto;
  white-space: nowrap;
  padding: 8px 2px 18px;
}

.highlight-wrapper {
  display: flex;
  gap: 18px;
}

.highlight {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 70px;
  text-align: center;
}

.circle {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 26px;
  background: #f1f5f9;
  color: #777;
  border: 2.5px solid transparent;
  transition: all 0.3s ease;
  
}

.add-circle {
  background: none;
  border: 1.0px dashed #23a541; /* Soft dashed green outline */
  color: #23a541;               /* Green icon */
  box-shadow: none;
  transition: all 0.3s ease;

}

.highlight p {
  font-size: 12px;
  font-weight: 600;
  margin-top: 6px;
  color: #222;
}

.highlight .status {
  font-size: 10px;
  color: #888;
  margin-top: 2px;
}

.processing {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;

  background: none !important;  /* ✅ remove grey */
  border: none !important;      /* ✅ remove grey ring */
}


/* OUTER RING — Light Yellow */
.processing::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: #FFE28A;
  border: 3px solid #FFE28A;
  box-sizing: border-box;  /* ✅ prevents shifting */
  z-index: 1;
}

/* INNER — darker yellow */
.processing::after {
  content: "";
  position: absolute;
  width: 78%;
  height: 78%;
  border-radius: 50%;
  background: #F5A623;
  box-sizing: border-box;  /* ✅ prevents shifting */
  z-index: 2;
}

/* STAR — same color as outer ring */
.processing i {
  position: relative;
  z-index: 3;
  font-size: 30px;
  color: #FFE28A;
}

/* 🥈 COMPLETE — 3-Layer Silver Coin */
.complete {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;

  background: none !important;  /* remove default grey background */
  border: none !important;      /* remove base border */
}

/* OUTER RING — Light Silver */
.complete::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: #E3E6E8;           /* light silver */
  border: 3px solid #E3E6E8;     /* same as fill for soft edge */
  box-sizing: border-box;
  z-index: 1;
}

/* INNER — Darker Silver */
.complete::after {
  content: "";
  position: absolute;
  width: 78%;
  height: 78%;
  border-radius: 50%;
  background: #C5C8CA;           /* slightly darker silver */
  box-sizing: border-box;
  z-index: 2;
}

/* STAR — same color as outer ring */
.complete i {
  position: relative;
  z-index: 3;
  font-size: 30px;
  color: #E3E6E8;               /* matches outer ring (light silver) */
}

/* 🟡 FULFILLED — Same as Processing (Light Yellow Coin) */
.fulfilled {
  width: 68px;
  height: 68px;
  border-radius: 50%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  background: none !important;
  border: none !important;
}

/* OUTER RING — Light Yellow */
.fulfilled::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: #FFE28A;
  border: 3px solid #FFE28A;
  box-sizing: border-box;
  z-index: 1;
}

/* INNER — Slightly Darker Yellow */
.fulfilled::after {
  content: "";
  position: absolute;
  width: 78%;
  height: 78%;
  border-radius: 50%;
  background: #F5A623;
  box-sizing: border-box;
  z-index: 2;
}

/* STAR — Same Color as Outer Ring */
.fulfilled i {
  position: relative;
  z-index: 3;
  font-size: 30px;
  color: #FFE28A;
}


/* Smooth scroll for highlights */
.goal-highlights::-webkit-scrollbar {
  height: 4px;
}
.goal-highlights::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.15);
  border-radius: 4px;
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

      <div class="headers"><h1>My Goals</h1></div>

      <!-- ✅ Stats -->
      <div class="stats">
        <div class="stat-card"><h3>Total</h3><p>{{ count($goals) }}</p></div>
        <div class="stat-card"><h3>Saved ₹</h3><p>{{ number_format($goals->sum('saved_amount')) }}</p></div>
        <div class="stat-card"><h3>Target ₹</h3><p>{{ number_format($goals->sum('target_amount')) }}</p></div>
      </div>



      <!-- ✅ Popup Form -->
      <div class="popup" id="goalPopup">
        <div class="popup-content">
          <button class="close-btn" onclick="closeGoalPopup()">✖</button>

          <h2>Create New Goal</h2>

          <form action="{{ route('goals.store') }}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Goal title" required>
            <input type="text" name="target_amount"
                   placeholder="Target amount"
                   inputmode="numeric"
                   pattern="[0-9]*"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   required>
            <button type="submit">Add Goal</button>
          </form>
        </div>
      </div>


<!-- 🌟 Goal Highlights -->
<div class="goal-highlights">
  <div class="highlight-wrapper">

    <!-- 🟢 First Circle: Add Goal (Opens Popup) -->
    <div class="highlight add-highlight" onclick="openGoalPopup()">
      <div class="circle add-circle">
        <i class="bi bi-plus-lg"></i>
      </div>
      <p>Add Goal</p>
    </div>



        <!-- 🟡 Example Circle: Processing -->
    <div class="highlight">
      <div class="circle processing">
        <i class="bi bi-star-fill"></i>
      </div>
      <p>Lipstick</p>
      <span class="status" style="color:#F5A623;">On Progress</span>
    </div>

    <!-- 🟡 Example Circle: Fulfilled -->
<div class="highlight">
  <div class="circle fulfilled">
    <i class="bi bi-star-fill"></i>
  </div>
  <p>Book</p>
  <span class="status" style="color:#23a541;">Completed</span>
</div>

    

    <!-- 🥈 Example Circle: Completed -->
    <div class="highlight">
      <div class="circle complete">
        <i class="bi bi-star-fill"></i>
      </div>
      <p>Cycle</p>
      <span class="status">Paid</span>
    </div>

    

  </div>
</div>



      <!-- ✅ Goal List -->
      @forelse ($goals as $index => $goal)
      <div class="goal-card" onclick="window.location.href='{{ route('goals.details', $goal->id) }}'">
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
}

// ✅ Close Popup
function closeGoalPopup() {
  document.getElementById('goalPopup').classList.remove('active');
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