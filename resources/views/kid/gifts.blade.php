<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🎁 My Gift Savings</title>

  <!-- ✅ Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ===== Base Layout (from Kid Dashboard) ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    html, body {
      height: 100%;
      width: 100%;
      background: #f9f9f9;
      overflow-x: hidden;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      width: 100%;
      max-width: 420px;
      height: 100dvh;
      background: #fff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      overflow: hidden;
      position: relative;
    }

    .inner-container {
      width: 100%;
      height: 100%;
      overflow-y: auto;
      padding: 16px 10px 40px;
      text-align: center;
      position: relative;
      z-index: 1;
      scroll-behavior: smooth;
    }

    /* ===== Falling Coins (Inside Hero) ===== */
.coin {
  position: absolute;
  top: -20px;
  width: 15px;
  height: 15px;
  background: radial-gradient(circle at 30% 30%, #ffd700, #ffb347 70%);
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
  animation: fall 4s linear infinite;
  z-index: 2;
  opacity: 0.9;
}

/* Position each coin differently */
.coin:nth-child(3) { left: 25%; animation-delay: 0s; }
.coin:nth-child(4) { left: 55%; animation-delay: 1s; }
.coin:nth-child(5) { left: 80%; animation-delay: 2s; }

@keyframes fall {
  0% {
    transform: translateY(-10px) rotate(0deg) scale(1);
    opacity: 0;
  }
  10% { opacity: 1; }
  50% {
    transform: translateY(80px) rotate(180deg) scale(1.05);
  }
  90% { opacity: 1; }
  100% {
    transform: translateY(130px) rotate(360deg) scale(0.9);
    opacity: 0;
  }
}

    
    /* ===== Header ===== */
    .gift-header {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 15px;
    }

    .gift-header .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .gift-header .profile img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 2px solid #23a541;
      object-fit: cover;
    }

    .gift-header .profile span {
      font-size: 14px;
      font-weight: 500;
      color: #222;
      text-transform: capitalize;
    }

    .gift-header .logo img {
      height: 28px;
      object-fit: contain;
      transform: translateX(-6px);
    }

    /* ===== Hero (Orange Banner) ===== */
    .hero {
      position: relative;
      background: linear-gradient(145deg, #ffb347 0%, #ff8a00 80%);
      border-radius: 22px;
      margin: 0.5rem 0 1.5rem;
      padding: 1.8rem 1rem;
      text-align: center;
      color: #fff;
      box-shadow: 0 10px 25px rgba(255,140,0,0.25);
      overflow: hidden;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.25), transparent 70%);
    }

    .hero::after {
      content: "";
      position: absolute;
      top: 0;
      left: -80%;
      width: 60%;
      height: 100%;
      background: linear-gradient(120deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.05) 60%, transparent 100%);
      transform: skewX(-25deg);
      animation: shineMove 5s infinite;
    }

    @keyframes shineMove {
      0% { left: -80%; }
      50% { left: 120%; }
      100% { left: 120%; }
    }

    .hero h2 {
      position: relative;
      font-weight: 700;
      font-size: 1.35rem;
      z-index: 3;
      margin: 0;
      letter-spacing: 0.4px;
      right:12px;
    }

    .gift-box {
      position: absolute;
      top: 6px;
      right: 25px;
      width: 70px;
      animation: floatGift 3s ease-in-out infinite;
      z-index: 3;
    }

    @keyframes floatGift {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    /* ===== Summary Cards ===== */
    .summary-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      margin-bottom: 1.8rem;
      gap: 14px;
    }

    .summary-card,
    .target-card {
      flex: 1;
      border-radius: 18px;
      padding: 1.2rem 0.8rem;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .summary-card h4,
    .target-card h4 {
      font-weight: 600;
      font-size: 0.85rem;
      margin-bottom: 6px;
      letter-spacing: 0.3px;
    }

    .summary-card h2,
    .target-card .amount {
      font-size: 1.45rem;
      font-weight: 700;
      margin: 0;
    }

    .summary-card {
      background: #f8fff8;
      border: 1px solid #d6f5dc;
      box-shadow: 0 6px 14px rgba(35,165,65,0.08);
    }

    .summary-card h4 { color: #4d784d; }
    .summary-card h2 { color: #23a541; }

    .target-card {
      background: #fff9f3;
      border: 1px solid #ffe5c2;
      box-shadow: 0 6px 14px rgba(255,165,0,0.08);
    }

    .target-card h4 { color: #ff8a00; }
    .target-card .amount { color: #ff8a00; }

    /* ===== Gift Cards ===== */
    .gift-section {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .gift-card {
      background: #ffffff;
      border: 1px solid #f2e1cc;
      border-radius: 18px;
      padding: 1.4rem 1.2rem 1.6rem;
      box-shadow: 0 4px 18px rgba(255, 138, 0, 0.08);
      transition: all 0.3s ease;
      position: relative;
    }

    .gift-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(255, 138, 0, 0.15);
    }

    .gift-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.8rem;
    }

    .gift-header h5 {
      font-size: 1rem;
      font-weight: 600;
      color: #ff7a00;
    }

    .goal-status {
      font-size: 0.78rem;
      font-weight: 600;
      border-radius: 30px;
      padding: 5px 14px;
      color: #fff;
      min-width: 92px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .goal-status.completed {
      background: linear-gradient(135deg, #23a541, #33c56c);
    }

    .goal-status.progress {
      background: linear-gradient(135deg, #ffb347, #ff8a00);
      height: 28px;
    }

    .progress-line {
      width: 100%;
      height: 10px;
      background: #eee;
      border-radius: 10px;
      overflow: hidden;
      margin: 0.6rem 0 0.8rem;
    }

    .progress-line span {
      height: 100%;
      display: block;
      background: linear-gradient(90deg, #ffb347, #ff8a00);
      border-radius: 10px;
    }

    .target-info {
      font-size: 0.85rem;
      color: #333;
      font-weight: 500;
      margin: 0.6rem 0 0.8rem;
      text-align: left;
    }

    .pay-now-btn {
      display: block;
      width: 100%;
      background: linear-gradient(135deg, #23a541, #33c56c);
      color: #fff;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 10px 0;
      border: none;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(35,165,65,0.25);
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .pay-now-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(35,165,65,0.35);
    }

    .fab {
      position: fixed;
      bottom: 75px;
      right: calc(50% - 180px);
      background: linear-gradient(145deg, #ffb347, #ff8a00);
      color: #fff;
      font-size: 1.6rem;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 18px rgba(255,138,0,0.4);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 100;
    }

    .fab:hover {
      transform: scale(1.1);
      box-shadow: 0 10px 25px rgba(255,138,0,0.5);
    }

    
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">
      @include('sidebar.profile')

      <div class="gift-header">
        <div class="profile">
          <img id="kidProfileToggle" src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}" alt="Profile" />
          <span>{{ ucfirst($user->first_name) }}</span>
        </div>
        <div class="logo">
          <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo" />
        </div>
      </div>

      <!-- Hero -->
     <!-- Hero -->
<div class="hero">
  <img src="{{ asset('images/gift-box.png') }}" alt="Gift Box" class="gift-box">
  <h2>My Gift Savings</h2>

  <!-- 🪙 Floating Coins -->
  <div class="coin"></div>
  <div class="coin"></div>
  <div class="coin"></div>
</div>


      <!-- Summary -->
      <div class="summary-wrapper">
        <div class="summary-card">
          <h4>Total Saved</h4>
          <h2>₹{{ number_format($gifts->sum('saved_amount') ?? 0) }}</h2>
        </div>

        <div class="target-card">
          @php
            $totalTarget = $gifts->sum('target_amount');
            $totalSaved = $gifts->sum('saved_amount');
            $remaining = max($totalTarget - $totalSaved, 0);
          @endphp
          <h4>Pending Target</h4>
          <div class="amount">₹{{ number_format($remaining) }}</div>
        </div>
      </div>

      <!-- Gift List -->
      <section class="gift-section">
        @forelse($gifts as $gift)
          @php
            $progress = $gift->target_amount > 0 ? min(($gift->saved_amount / $gift->target_amount) * 100, 100) : 0;
          @endphp

          <div class="gift-card">
            <div class="gift-header">
              <h5>{{ ucfirst($gift->title) }}</h5>
              @if($gift->saved_amount >= $gift->target_amount)
                <div class="goal-status completed">Completed</div>
              @else
                <div class="goal-status progress">In Progress</div>
              @endif
            </div>

            <div class="progress-line"><span style="width: {{ $progress }}%;"></span></div>
            <p class="target-info mb-0">Target: ₹{{ number_format($gift->target_amount, 2) }}</p>

            @if($gift->saved_amount >= $gift->target_amount)
              <button class="pay-now-btn">Pay Now</button>
            @else
              <form action="{{ route('kid.gifts.add') }}" method="POST" class="d-flex align-items-center mt-3">
                @csrf
                <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                <input type="number" name="amount" class="form-control me-2"
                  placeholder="Save amount" min="1"
                  max="{{ $gift->target_amount - $gift->saved_amount }}"
                  required
                  style="width: 140px;font-size: 0.85rem;border-radius:10px;height:40px;">
                <button type="submit" class="btn btn-success btn-sm" style="border-radius: 15px; height: 38px; width: 70px;">Add</button>
              </form>
            @endif
          </div>
        @empty
          <div class="text-center text-muted fs-6 p-3">
            <p>No gifts added yet. Start your savings adventure!</p>
          </div>
        @endforelse
      </section>
    </div>

    <!-- Add Button -->
    <div class="fab" onclick="window.location.href='{{ route('kid.gifts.add') }}'">
      <i class="bi bi-plus-lg"></i>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.pay-now-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        window.location.href = "{{ route('kid.scanqr') }}";
      });
    });
  </script>
</body>
</html>
