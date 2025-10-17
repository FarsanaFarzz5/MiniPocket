<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Transactions - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
  /* ========== GLOBAL RESET ========== */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  html, body {
    width: 100%;
    height: 100%;
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* ✅ CONTAINER FULL-SCREEN FIX */
  .container {
    width: 100%;
    max-width: 420px;
    height: 100dvh; /* ✅ fills entire device height */
    background: #fff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow: hidden; /* keeps sidebar & overlay inside */
  }

  .inner-container {
    width: 100%;
    height: 100%;
    text-align: center;
    overflow-y: auto;
    padding: 16px 20px 40px;
    position: relative;
    z-index: 1;
  }

  /* ✅ HEADER BAR */
  .header-bar {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    margin-bottom: 10px;
  }

  .menu-icon {
    width: 26px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    margin-top: 4px;
    margin-left: 6px;
    z-index: 25;
  }

  .menu-icon div {
    width: 100%;
    height: 3px;
    background-color: #bfbfbf;
    border-radius: 2px;
    transition: all 0.3s ease;
  }

  .menu-icon:hover div:nth-child(1),
  .menu-icon:hover div:nth-child(3) {
    width: 70%;
  }

  /* ✅ Hide menu icon when sidebar opens */
.menu-icon.hide {
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

  /* ✅ LOGO */
  .logo-section {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 6px;
    margin-bottom: 10px;
  }

  .logo-section img {
    width: 65px;
    height: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .logo-section img:hover {
    transform: scale(1.05);
  }

  /* ✅ TITLE */
  h1 {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 18px;
  }

/* ✅ COMPACT ORANGE BALANCE CARD */
.balance-card {
  background: linear-gradient(135deg, #ff9500, #ff5e00); /* 🟠 Orange gradient */
  color: #fff;
  border-radius: 14px;
  padding: 14px 18px; /* 🔸 reduced padding */
  width: 100%;
  text-align: center;
  box-shadow: 0 4px 14px rgba(255, 149, 0, 0.3);
  margin-bottom: 18px; /* tighter spacing */
  position: relative;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.balance-card::after {
  content: "";
  position: absolute;
  width: 100px;
  height: 100px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 50%;
  top: -20px;
  right: -30px;
}

.balance-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(255, 149, 0, 0.4);
}

/* Text styles inside card */
.balance-card h3 {
  font-size: 13px; /* smaller heading */
  font-weight: 500;
  opacity: 0.9;
}

.balance-card p {
  font-size: 22px; /* reduced number size */
  font-weight: 700;
  margin-top: 2px;
}


  /* ✅ TRANSACTIONS */
  .transactions {
    display: flex;
    flex-direction: column;
    gap: 14px;
    width: 100%;
    padding-bottom: 20px;
  }

  .transaction {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 14px;
    padding: 12px 15px;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
  }

  .transaction:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .icon-box {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-size: 20px;
  }

  .credit .icon-box {
    background: linear-gradient(135deg, #00e676, #00c853);
  }

  .debit .icon-box {
    background: linear-gradient(135deg, #ff5252, #e53935);
  }

  .info {
    flex: 1;
    text-align: left;
    margin-left: 10px;
  }

  .info h4 {
    font-size: 14px;
    font-weight: 500;
    color: #1e293b;
  }

  .info span {
    font-size: 12px;
    color: #64748b;
  }

  .amount {
    font-size: 15px;
    font-weight: 700;
  }

  .amount.credit { color: #00c853; }
  .amount.debit { color: #e53935; }

  /* ✅ SIDEBAR INSIDE CONTAINER */
  #kidSidebarMenu {
    position: absolute;
    top: 0;
    left: 0;
    width: 220px;
    height: 100%;
    background: #ffffff;
    box-shadow: 3px 0 10px rgba(0,0,0,0.05);
    transform: translateX(-100%);
    transition: transform 0.35s ease;
    z-index: 20;
  }

  #kidSidebarMenu.open {
    transform: translateX(0);
  }

  /* ✅ Overlay INSIDE Container */
  #sidebarOverlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.35);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 15;
  }

  #sidebarOverlay.show {
    opacity: 1;
    visibility: visible;
  }
  

  @media (max-width: 480px) {
    .container {
      border-radius: 0;
      box-shadow: none;
      max-width: 100%;
      height: 100dvh;
    }
    .logo-section img { width: 58px; }
    h1 { font-size: 14px; margin-bottom: 14px; }
    .balance-card p { font-size: 24px; }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- ✅ Hamburger Menu -->
      <div class="header-bar">
        <div id="kidMenuToggle" class="menu-icon">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>

      <!-- ✅ Sidebar -->
      @include('sidebar.profile')

      <!-- ✅ Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <h1>My Transactions</h1>

      <!-- ✅ Balance Card -->
      <div class="balance-card">
        <h3>Available Balance</h3>
        <p>₹{{ number_format($balance, 2) }}</p>
      </div>

      <!-- ✅ Transactions -->
      <div class="transactions">
        @if($transactions->count() > 0)
          @foreach($transactions as $txn)
            <div class="transaction {{ $txn->type === 'credit' ? 'credit' : 'debit' }}">
              <div class="icon-box">
                @if($txn->type === 'credit') ↑ @else ↓ @endif
              </div>
              <div class="info">
                <h4>{{ $txn->type === 'credit' ? 'Received from Parent' : 'Spent for Needs' }}</h4>
                <span>{{ $txn->created_at->format('d M Y, h:i A') }}</span>
              </div>
              <div class="amount {{ $txn->type === 'credit' ? 'credit' : 'debit' }}">
                {{ $txn->type === 'credit' ? '+' : '-' }}₹{{ number_format($txn->amount, 2) }}
              </div>
            </div>
          @endforeach
        @else
          <div class="no-transactions">No transactions found.</div>
        @endif
      </div>
    </div>

    <!-- ✅ Overlay inside container -->
    <div id="sidebarOverlay"></div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const kidMenuToggle = document.getElementById('kidMenuToggle');
  const kidSidebarMenu = document.getElementById('kidSidebarMenu');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  if (kidMenuToggle && kidSidebarMenu && sidebarOverlay) {
    kidMenuToggle.addEventListener('click', () => {
      const isOpen = kidSidebarMenu.classList.toggle('open');
      sidebarOverlay.classList.toggle('show');
      
      // ✅ Hide the 3 lines when sidebar opens
      if (isOpen) {
        kidMenuToggle.classList.add('hide');
      } else {
        kidMenuToggle.classList.remove('hide');
      }
    });

    sidebarOverlay.addEventListener('click', () => {
      kidSidebarMenu.classList.remove('open');
      sidebarOverlay.classList.remove('show');
      kidMenuToggle.classList.remove('hide');
    });
  }
});
</script>
</body>
</html>
