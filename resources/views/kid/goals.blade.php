<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Kid Goals – Mini Pocket</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* =======================================================
   🌿 GLOBAL THEME — Consistent with Kid Dashboard & Edit Kid
======================================================= */
* {margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif;}

html, body {
  width:100%;
  height:100%;
  background:#fff;
  display:flex;
  justify-content:center;
  align-items:flex-start;
  overflow-x:hidden;
}

.container {
  width:100%;
  max-width:420px;
  min-height:100vh;
  background:#ffffff;
  border-radius:24px;
  box-shadow:0 8px 24px rgba(0,0,0,0.06);
  padding:24px 20px 80px;
  position:relative;
  overflow-y:auto;
}

/* =======================================================
   💚 HEADER
======================================================= */
.header {
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:24px;
}
.header h1 {
  font-size:18px;
  font-weight:700;
  color:#064e3b;
  background:linear-gradient(90deg,#059669,#10b981);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

/* =======================================================
   🎯 STATS OVERVIEW
======================================================= */
.stats {
  display:flex;
  gap:10px;
  justify-content:space-between;
  margin-bottom:26px;
}
.stat-card {
  flex:1;
  background:linear-gradient(90deg,#059669,#10b981);
  border-radius:16px;
  padding:10px 12px;
  text-align:center;
  box-shadow:inset 0 0 0 1px rgba(16,185,129,0.15);
  color:#fff;
}
.stat-card h3 {
  font-size:13px;
  font-weight:600;
  margin-bottom:4px;
}
.stat-card p {
  font-size:13px;
  font-weight:600;
}

/* =======================================================
   ➕ ADD GOAL BUTTON
======================================================= */
.add-goal-btn {
  display:block;
  width:100%;
  background:linear-gradient(90deg,#059669,#10b981);
  color:#fff;
  font-weight:600;
  text-align:center;
  padding:12px 0;
  border:none;
  border-radius:12px;
  font-size:14px;
  margin-bottom:25px;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(16,185,129,0.3);
  transition:transform 0.3s, box-shadow 0.3s;
}
.add-goal-btn:hover {
  transform:translateY(-2px);
  box-shadow:0 6px 16px rgba(16,185,129,0.4);
}

/* =======================================================
   🧩 POPUP GOAL FORM
======================================================= */
.popup {
  position:fixed;
  top:0; left:0;
  width:100%; height:100%;
  display:none;
  justify-content:center;
  align-items:center;
  background:rgba(0,0,0,0.4);
  z-index:10;
}
.popup.active {display:flex;}
.popup-content {
  background:#ffffff;
  border-radius:20px;
  width:90%;
  max-width:360px;
  padding:22px 20px;
  box-shadow:0 8px 25px rgba(0,0,0,0.15);
  animation:slideUp 0.4s ease forwards;
  position:relative;
}
@keyframes slideUp {
  from {transform:translateY(50px); opacity:0;}
  to {transform:translateY(0); opacity:1;}
}
.popup-content h2 {
  font-size:16px;
  font-weight:600;
  color:#065f46;
  text-align:center;
  margin-bottom:14px;
}
.popup-content input[type="text"],
.popup-content input[type="number"],
.popup-content input[type="file"] {
  width:100%;
  padding:10px 12px;
  border-radius:10px;
  border:1.5px solid #a7f3d0;
  font-size:13px;
  margin-bottom:10px;
  transition:0.3s;
}
.popup-content input:focus {
  border-color:#10b981;
  box-shadow:0 0 0 3px rgba(16,185,129,0.2);
}
.popup-content button[type="submit"] {
  width:100%;
  background:linear-gradient(90deg,#059669,#10b981);
  border:none;
  color:#fff;
  font-weight:600;
  border-radius:10px;
  padding:10px;
  font-size:14px;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(16,185,129,0.3);
  transition:transform 0.2s ease;
}
.popup-content button[type="submit"]:hover {
  transform:translateY(-2px);
}
.close-btn {
  position:absolute;
  top:8px; right:12px;
  background:none;
  border:none;
  font-size:22px;
  color:#888;
  cursor:pointer;
}

/* =======================================================
   🏷 GOAL LIST CARD
======================================================= */
.goal-card {
  background:#ffffff;
  border-radius:16px;
  box-shadow:0 4px 10px rgba(0,0,0,0.05);
  padding:14px 16px;
  margin-bottom:18px;
  transition:transform 0.2s ease, box-shadow 0.3s ease;
  cursor:pointer;
  border:1px solid #e2e8f0;
}
.goal-card:hover {
  transform:translateY(-2px);
  box-shadow:0 6px 16px rgba(0,0,0,0.08);
}
.goal-item {
  display:flex;
  justify-content:space-between;
  align-items:center;
}
.goal-left {
  display:flex;
  align-items:center;
  gap:10px;
}
.goal-left span.num {
  font-weight:600;
  color:#059669;
  width:20px;
  text-align:right;
}
.goal-left .title {
  font-size:14px;
  color:#333;
  font-weight:600;
}
.goal-right {
  text-align:right;
}
.goal-right p {
  font-size:13px;
  margin:0;
  color:#065f46;
}
.goal-right .target {
  color:#94a3b8;
  font-size:12px;
}
.empty {
  text-align:center;
  color:#94a3b8;
  font-size:14px;
  margin-top:20px;
}
</style>
</head>

<body>
<div class="container">
  <div class="header">
    <h1>My Goals</h1>
  </div>

  <div class="stats">
    <div class="stat-card"><h3>Total</h3><p>{{ count($goals) }}</p></div>
    <div class="stat-card"><h3>Saved ₹</h3><p>{{ number_format($goals->sum('saved_amount')) }}</p></div>
    <div class="stat-card"><h3>Target ₹</h3><p>{{ number_format($goals->sum('target_amount')) }}</p></div>
  </div>

  <button class="add-goal-btn" onclick="togglePopup()"> Add Goal</button>

  <!-- Popup -->
  <div class="popup" id="goalPopup">
    <div class="popup-content">
      <button class="close-btn" onclick="togglePopup()">✖</button>
      <h2>Create New Goal</h2>
      <form action="{{ route('goals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Goal title" required>
        <input type="number" name="target_amount" placeholder="Target amount" min="1" required>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Add Goal</button>
      </form>
    </div>
  </div>

  <!-- ✅ GOAL CARDS -->
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

<script>
function togglePopup() {
  document.getElementById('goalPopup').classList.toggle('active');
}
</script>
</body>
</html>
