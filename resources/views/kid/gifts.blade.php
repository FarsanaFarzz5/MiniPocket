<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Gift Savings - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- ✅ Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/gifts.css') }}">
</head>

<style>
/* ======================================
   🛒 PERFECT MATCH – BEST PRICE SECTION
====================================== */

.best-price-box {
  margin-top: 20px;
  padding: 0 2px;
}

.best-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 14px 16px;
  margin-bottom: 14px;
  border: 1px solid #f4f4f4;
  box-shadow: 0px 2px 12px rgba(0,0,0,0.04);
  transition: 0.2s ease-in-out;
}

.best-card:hover {
  transform: translateY(-2px);
  box-shadow: 0px 4px 18px rgba(0,0,0,0.08);
}

.best-card .tag {
  background: rgba(16, 185, 129, 0.12);
  color: #059669;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 6px;
  margin-bottom: 10px;
  display: inline-block;
}

.product-row {
  display: flex;
  align-items: center;
  gap: 12px;
}

.store-logo {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  padding: 5px;
  background: #fff;
}

.info {
  flex: 1;
  display: flex;
  flex-direction: column;
  line-height: 1.25;
}

.info span {
  margin-bottom: 5px;
}


.store-name {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
}

.stock {
  font-size: 12px;
  font-weight: 600;
  color: #10b981;
}

.delivery {
  font-size: 12px;
  color: #9ca3af;
}

.price {
  font-size: 16px;
  font-weight: 700;
  color: #111827;
  white-space: nowrap;
}

@media (max-width: 430px) {
  .store-logo { width: 40px; height: 40px; }
  .price { font-size: 15px; }
}
</style>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.profile')
      @include('header')

      <!-- Toggle Tabs -->
<div class="toggle-tabs">
  <a href="{{ route('kid.goals') }}" class="tab">Goals</a>
  <a href="{{ route('kid.gifts') }}" class="tab active">Gifts</a>
</div>

      <!-- Hero -->
      <div class="hero">
        <img src="{{ asset('images/gift-box.png') }}" class="gift-box">
        <h2>My Gift Savings</h2>
        <div class="coin"></div><div class="coin"></div><div class="coin"></div>
      </div>

      <!-- Summary -->
      <div class="summary-wrapper">
        <div class="summary-card">
          <h4>Total Saved</h4>
          <h2>₹{{ number_format($gifts->where('status', 0)->sum('saved_amount')) }}</h2>
        </div>

        <div class="target-card">
          @php
            $totalTarget = $gifts->sum('target_amount');
            $totalSaved  = $gifts->sum('saved_amount');
            $remaining   = max($totalTarget - $totalSaved, 0);
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
    $needed   = max($gift->target_amount - $gift->saved_amount, 0);
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

    <div class="progress-line">
      <span style="width: {{ $progress }}%;"></span>
    </div>

    <div class="target-info d-flex justify-content-between mb-0">
      <span>Saved: ₹{{ number_format($gift->saved_amount, 2) }}</span>
      <span>Target: ₹{{ number_format($needed, 2) }}</span>
    </div>

    <!-- CONDITION PART FIXED -->
    @if($gift->saved_amount >= $gift->target_amount)

      <button class="pay-now-btn"
        data-id="{{ $gift->id }}"
        data-amount="{{ $gift->saved_amount }}"
        data-title="{{ $gift->title }}">
        Pay Now
      </button>

    @else

      <!-- Saving Form -->
      <form action="{{ route('kid.gifts.add') }}" method="POST" class="gift-form mt-3">
        @csrf
        <input type="hidden" name="source" value="gift_saving">
        <input type="hidden" name="gift_id" value="{{ $gift->id }}">

        <input type="text" name="amount" class="gift-input"
          placeholder="Save amount"
          inputmode="numeric"
          pattern="[0-9]*"
          max="{{ $needed }}"
          oninput="
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value !== '' && parseInt(this.value) > {{ $needed }}) {
                this.value = {{ $needed }};
            }"
          required>

        <button type="submit" class="gift-add-btn">Add</button>
      </form>

    @endif

    <!-- ⭐ ALWAYS SHOW BEST PRICE (FIXED) -->
    <div class="best-price-box">
      @foreach($gift->bestPrices as $item)
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

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", () => {
    showToast("{{ session('success') }}", "success");
});
</script>
@endif

    <div id="alertToast" class="alert-toast"></div>

  </div>

<script>
const toast = document.getElementById("alertToast");

function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = `alert-toast show alert-${type}`;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

// Pay Now Action
document.querySelectorAll(".pay-now-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    const amount = btn.dataset.amount;
    const title = btn.dataset.title;

    localStorage.setItem("giftAmount", amount);
    localStorage.setItem("giftReason", title);

    showToast(`Redirecting to scanner for ${title}...`, "success");

    setTimeout(() => {
      window.location.href = '/kid/scan-qr';
    }, 1200);
  });
});
</script>

</body>
</html>
