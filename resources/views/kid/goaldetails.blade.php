<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $goal->title }} – Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Fonts & Shared Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

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
  align-items: flex-start;
  overflow: hidden;
}

/* ================= CONTAINER ================= */
.container {
  width: 100%;
  max-width: 420px;
  height: 100dvh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.inner-container {
  flex: 1;
  width: 100%;
  overflow-y: auto;
  padding: 16px 20px 90px; /* bottom space for FAB */
  position: relative;
  z-index: 1;
}


    /* 🏷 HEADER */
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

    /* 💰 GOAL INFO */
    .goal-info {
      background: linear-gradient(145deg, #ffffff 0%, #dcfce7 100%);
      border-radius: 18px;
      box-shadow: inset 0 0 0 1px rgba(16,185,129,0.15);
      padding: 16px 18px;
      margin-bottom: 20px;
    }

    .goal-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #e2e8f0;
      padding: 10px 0;
    }

    .goal-item:last-child { border: none; }

    .goal-left {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .goal-left .num {
      background: #10b981;
      color: #fff;
      font-weight: 600;
      font-size: 12px;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .goal-left .label {
      font-size: 14px;
      font-weight: 600;
      color: #065f46;
    }

    .goal-right { text-align: right; }
    .goal-right p { margin: 0; font-size: 13px; font-weight: 600; color: #047857; }
    .goal-right .target { color: #64748b; }

    /* 📊 PROGRESS */
    .progress-container { margin-top: 15px; }
    .progress-label { font-size: 13px; color: #064e3b; font-weight: 600; margin-bottom: 6px; }

    .progress-bar {
      width: 100%;
      height: 10px;
      border-radius: 6px;
      background: #e2e8f0;
      overflow: hidden;
      position: relative;
    }

    .progress-bar::after {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: calc({{ $progress }}%);
      background: linear-gradient(90deg, #10b981, #059669);
      transition: width 0.5s ease;
    }

    .progress-text {
      text-align: right;
      font-size: 12.5px;
      margin-top: 4px;
      color: #047857;
      font-weight: 600;
    }

    /* ➕ ADD AMOUNT FORM */
    .add-form {
      display: flex;
      gap: 10px;
      margin-top: 18px;
    }

.add-form input.amount-input {
 width:40%;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1.5px solid #a7f3d0;
  font-size: 13px;
  transition: all 0.3s;
  text-align: center;

}


.add-form input.amount-input:focus {
  border-color: #10b981;
  box-shadow: 0 0 0 3px rgba(16,185,129,0.2);
  outline: none;
}

    .add-form button {
      padding: 10px 16px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #23a541, #33c56c);
      color: #fff;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(16,185,129,0.3);
      transition: transform 0.2s ease;
    }

    .add-form button:hover { transform: translateY(-2px); }

/* ================================
   🌟 50-50 Side-by-Side Buttons
   (Perfect Matching Green Style)
================================ */

.goal-btn-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin: 18px 0;
}

.goal-btn {
    flex: 1;
    background: linear-gradient(135deg, #23a541, #33c56c); /* same Pay Now gradient */
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 14px 0;
    border-radius: 12px;
    font-size: 14px;
    cursor: pointer;
    text-align: center;
    box-shadow: 0 4px 12px rgba(16,185,129,0.25);
    transition: 0.25s ease;
}

.goal-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16,185,129,0.35);
}


 

    /* 🧾 SAVING HISTORY */
    .history {
      margin-top: 30px;
      background: linear-gradient(145deg, #f0fdf4, #ffffff);
      border-radius: 16px;
      padding: 16px 18px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05), inset 0 0 0 1px #d1fae5;
    }

    .history h4 {
      font-size: 15px;
      font-weight: 700;
      color: #065f46;
      text-align: center;
      margin-bottom: 14px;
    }

    .history ul { list-style: none; margin: 0; padding: 0; }

    .history li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      border-radius: 10px;
      padding: 10px 14px;
      margin-bottom: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.04);
      transition: all 0.2s ease;
    }

    .history li:hover { background: #f0fdf4; transform: translateY(-2px); }
    .history li span { font-size: 12.5px; color: #6b7280; }
    .history li strong { font-size: 13.5px; color: #047857; }
    .history .empty {
      text-align: left;
      padding-left: 12px;
      color: #9ca3af;
      font-size: 13px;
      font-weight: 500;
      padding-top: 10px;
      padding-bottom: 10px;
    }

    /* ✅ Toast / Alert Message */
.alert-toast {
  width: 75% !important;
  position: fixed;
  bottom: 22px;
  left: 50%;
  transform: translateX(-50%);
  background: #ffffff;
  color: #1e293b;
  border-radius: 10px;
  padding: 12px 20px;
  font-size: 14px;
  font-weight: 600;
  z-index: 9999;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
  opacity: 0;
  pointer-events: none;
  transition: all 0.35s ease-in-out;
}

/* ✅ Toast Visible */
.alert-toast.show {
  opacity: 1;
  transform: translateX(-50%) translateY(-10px);
  pointer-events: auto;
}

/* Success */
.alert-success {
  background: linear-gradient(135deg, #23a541, #33c56c);
  color: #fff;
}

/* Warning */
.alert-warning {
  background: linear-gradient(90deg, #f59e0b, #fbbf24);
  color: #fff;
}

/* Error */
.alert-error {
  background: linear-gradient(90deg, #dc2626, #ef4444);
  color: #fff;
}

/* ===========================
   🛒 BEST PRICE SECTION (Professional)
=========================== */

.best-price-box {
  margin-top: 22px;
}

/* CARD */
.best-card {
  background: #ffffff;
  border-radius: 16px;
  padding: 16px 18px;
  margin-bottom: 12px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.06);
  border: 1px solid #f1f5f9;
  text-align: left;
}

/* BADGE */
.best-card .tag {
  background: #2563eb10;   /* soft blue tint */
  color: #555;
  padding: 4px 10px;
  font-size: 11px;
  font-weight: 600;
  border-radius: 6px;
  margin-bottom: 8px;
  display: inline-block;
  margin-left: -6px;
}

/* ROW LAYOUT */
.product-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

/* LOGO */
.store-logo {
  width: 38px;
  height: 38px;
  object-fit: contain;
  margin-top: 2px;
}

/* TEXT COLUMN */
.info {
  flex: 1;
  display: flex;
  flex-direction: column;
  line-height: 1.25;
}

.info span {
  margin-bottom: 3px;   /* small clean spacing */
  display: block;       /* ensures stacking correctly */
}

/* STORE NAME (soft, not bold) */
.store-name {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 3px;
}

/* STOCK STATUS (softer green) */
.stock {
  font-size: 12px;
  font-weight: 500;
  color: #059669;
  margin-bottom: 2px;
}

/* DELIVERY (lighter gray) */
.delivery {
  font-size: 12px;
  color: #9ca3af;
}

/* PRICE (premium look) */
.price {
  font-size: 15px;
  font-weight: 600;
  color: #111827;
  margin-top: 2px;
  white-space: nowrap;
}


    @media(max-width:420px) {
      html, body { align-items: flex-start; }
      .container { border-radius: 0; height: 100svh; }
      .goal-item { flex-direction: column; align-items: flex-start; gap: 4px; }
      .goal-right { text-align: left; width: 100%; }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">
      <!-- ✅ Sidebar -->
      @include('sidebar.profile')

      <!-- ✅ Header -->
      @include('header')

      <!-- ✅ Goal Title -->
      <div class="headers">
        <h1>{{ $goal->title }}</h1>
      </div>

      <!-- ✅ Goal Info -->
      <div class="goal-info">
        <div class="goal-item">
          <div class="goal-left">
            <span class="num">1</span>
            <span class="label">Target Amount</span>
          </div>
          <div class="goal-right">
            <p class="target">₹{{ number_format($goal->target_amount,2) }}</p>
          </div>
        </div>

        <div class="goal-item">
          <div class="goal-left">
            <span class="num">2</span>
            <span class="label">Saved Amount</span>
          </div>
          <div class="goal-right">
            <p>₹{{ number_format($goal->saved_amount,2) }}</p>
          </div>
        </div>
      </div>

      <!-- ✅ Progress Bar -->
      <div class="progress-container">
        <p class="progress-label">Goal Progress</p>
        <div class="progress-bar"></div>
        <p class="progress-text">{{ $progress }}% completed</p>
      </div>

      <!-- ✅ Add Amount or Pay Button -->
      @if($progress < 100)
      @php
  $remaining = $goal->target_amount - $goal->saved_amount;
@endphp

        <form action="{{ route('goals.addSavings', $goal->id) }}" method="POST" class="add-form">
          @csrf
<input type="text" name="saved_amount" class="amount-input"
       placeholder="Enter amount"
       inputmode="numeric"
       pattern="[0-9]*"
       max="{{ $remaining }}"
       oninput="
          this.value = this.value.replace(/[^0-9]/g, '');
          if (this.value > {{ $remaining }}) this.value = {{ $remaining }};
       "
       required>


          <button type="submit">Add</button>
        </form>
@else

<div class="goal-btn-row">

    <button class="goal-btn"
        id="payGoalBtn"
        data-amount="{{ $goal->saved_amount }}"
        data-title="{{ $goal->title }}"
        data-goal-id="{{ $goal->id }}">
        Pay 
    </button>

    <button class="goal-btn"
        id="sendToParentBtn"
        data-amount="{{ $goal->saved_amount }}"
        data-title="{{ $goal->title }}"
        data-goal-id="{{ $goal->id }}">
        Send to parent
    </button>

</div>



@endif

<!-- 🛒 BEST PRICE SECTION -->
<div class="best-price-box">
    @foreach($bestPrices as $item)
   <div class="best-card">

    @if(isset($item['note']))
        <div class="tag">{{ $item['note'] }}</div>
    @endif

    <div class="product-row">
        <img src="{{ $item['logo'] }}" class="store-logo">

        <div class="info">
            <span class="store-name">{{ $item['store'] }}</span>
            <span class="stock">{{ $item['stock'] }}</span>
            <span class="delivery">{{ $item['delivery'] }}</span>
        </div>

        <span class="price">₹{{ number_format($item['price']) }}</span>
    </div>

</div>


    @endforeach
</div>


      <!-- ✅ Saving History -->
      <div class="history">
        <h4>Saving History</h4>
        <ul>
          @forelse($goal->savings as $saving)
            <li>
              <strong>₹{{ number_format($saving->saved_amount,2) }}</strong>
              <span>{{ $saving->created_at->format('d M, Y') }}</span>
            </li>
          @empty
            <li class="empty">No savings yet.</li>
          @endforelse
        </ul>
      </div>
    </div>
    <div id="alertToast" class="alert-toast"></div>

  </div>
 
<script>
const toast = document.getElementById("alertToast");

// ✅ Toast message (same as gift page)
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

document.getElementById("payGoalBtn")?.addEventListener("click", function () {
  const amount = this.dataset.amount;
  const title = this.dataset.title;
  const goalId = this.dataset.goalId;

  // ✅ Save Goal details to localStorage
  localStorage.setItem("goalAmount", amount);
  localStorage.setItem("goalReason", title);
  localStorage.setItem("goalId", goalId);

  showToast(` Redirecting to scanner for ${title}...`, "success");

  // ✅ Redirect same as gift
  setTimeout(() => {
    window.location.href = "/kid/scan-qr";  // ✅ FIXED redirection
  }, 1200);
});

document.getElementById("sendToParentBtn")?.addEventListener("click", function () {

  const amount = this.dataset.amount;
  const title = this.dataset.title;
  const goalId = this.dataset.goalId;

  // Save details
 localStorage.setItem("parentReturnAmount", amount);
localStorage.setItem("parentReturnReason", title);   // goal name
localStorage.setItem("parentReturnGoalId", goalId);


  showToast("Redirecting to Money Transfer...", "success");

  setTimeout(() => {
      window.location.href = "/kid/moneytransfer?type=parent";
  }, 800);
});

</script>



</body>
</html>