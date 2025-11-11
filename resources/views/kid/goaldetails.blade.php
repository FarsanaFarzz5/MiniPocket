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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
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

    /* ✅ Corrected Main Container Layout */
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
      border-radius: 0;
    }

    .inner-container {
      width: 100%;
      height: 100%;
      overflow-y: auto;
      padding: 16px 20px 70px;
      text-align: center;
      position: relative;
      z-index: 1;
      scroll-behavior: smooth;
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
  flex: 1;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1.5px solid #a7f3d0;
  font-size: 13px;
  transition: all 0.3s;
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

    /* 💳 PAY NOW BUTTON */
    .pay-btn {
      display: block;
      width: 100%;
       background: linear-gradient(135deg, #23a541, #33c56c);
      color: #fff;
      font-weight: 600;
      text-align: center;
      padding: 12px 0;
      border-radius: 12px;
      font-size: 14px;
      margin-top: 18px;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(16,185,129,0.3);
      transition: transform 0.2s, box-shadow 0.3s;
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


    @media(max-width:420px) {
      html, body { align-items: flex-start; }
      .container { border-radius: 0; height: 100svh; }
      .goal-item { flex-direction: column; align-items: flex-start; gap: 4px; }
      .goal-right { text-align: left; width: 100%; }
      .add-form { flex-direction: column; }
      .add-form button { width: 100%; }
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
       placeholder="Enter amount to add"
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
<button class="pay-btn"
        id="payGoalBtn"
        data-amount="{{ $goal->saved_amount }}"
        data-title="{{ $goal->title }}"
        data-goal-id="{{ $goal->id }}">
    Pay Now 
</button>
@endif



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
</script>



</body>
</html>
