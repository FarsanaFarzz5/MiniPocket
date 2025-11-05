<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Kid Goals – Mini Pocket</title>

  <!-- ✅ Google Fonts & Bootstrap Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- ✅ Sidebar CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
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

  /* ✅ Hamburger icon */
  .header-bar {
    position:absolute;
    top:16px;
    left:14px;
    z-index:25;
  }

  .menu-icon {
    width:26px;
    height:20px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    cursor:pointer;
  }

  .menu-icon div {
    width:100%;
    height:3px;
    background-color:#bfbfbf;
    border-radius:2px;
    transition:all 0.3s ease;
  }

  .menu-icon.hide {
    opacity:0;
    pointer-events:none;
  }

  /* ✅ Sidebar */
  #kidSidebarMenu {
    position:absolute;
    top:0;
    left:0;
    width:220px;
    height:100%;
    background:#ffffff;
    box-shadow:3px 0 10px rgba(0,0,0,0.05);
    transform:translateX(-100%);
    transition:transform 0.35s ease;
    z-index:20;
  }

  #kidSidebarMenu.open {
    transform:translateX(0);
  }

  #sidebarOverlay {
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.35);
    opacity:0;
    visibility:hidden;
    transition:all 0.3s ease;
    z-index:15;
  }

  #sidebarOverlay.show {
    opacity:1;
    visibility:visible;
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
    background: linear-gradient(135deg, #23a541, #33c56c);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
  }

  /* =======================================================
     🎯 STATS OVERVIEW
  ======================================================= */
  /* =======================================================
     🎯 STATS OVERVIEW (Styled like Goal Cards)
  ======================================================= */
  .stats {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    margin-bottom: 26px;
  }

  .stat-card {
    flex: 1;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    padding: 14px 10px;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
    cursor: pointer;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
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

  /* =======================================================
     ➕ ADD GOAL BUTTON (Styled like Goal Card)
  ======================================================= */
  .add-goal-btn {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, #23a541, #33c56c);
    color: #fff;
    font-weight: 600;
    text-align: center;
    padding: 14px 0;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    font-size: 14px;
    margin-bottom: 25px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .add-goal-btn:hover {
    transform: translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
    background: linear-gradient(90deg, #059669, #10b981);
    color: #fff;
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
    z-index:50;
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
    font-weight:510;
    color:#333;
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
    <!-- ✅ Sidebar include -->
    @include('sidebar.profile')

    <!-- ✅ Overlay -->
    <div id="sidebarOverlay"></div>

  

    <!-- ✅ Page Header -->
    <div class="header">
      <h1>My Goals</h1>
    </div>

    <!-- ✅ Stats -->
    <div class="stats">
      <div class="stat-card"><h3>Total</h3><p>{{ count($goals) }}</p></div>
      <div class="stat-card"><h3>Saved ₹</h3><p>{{ number_format($goals->sum('saved_amount')) }}</p></div>
      <div class="stat-card"><h3>Target ₹</h3><p>{{ number_format($goals->sum('target_amount')) }}</p></div>
    </div>

    <!-- ✅ Add Goal Button -->
    <button class="add-goal-btn" onclick="togglePopup()">Add Goal</button>

    <!-- ✅ Popup -->
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

    <!-- ✅ Goal Cards -->
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

  document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('kidMenuToggle');
    const sidebar = document.getElementById('kidSidebarMenu');
    const overlay = document.getElementById('sidebarOverlay');

    if (menuToggle && sidebar && overlay) {
      menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
        this.classList.toggle('hide');
      });

      overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        menuToggle.classList.remove('hide');
      });
    }
  });
  </script>
</body>
</html>
