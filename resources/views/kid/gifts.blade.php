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

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.profile')
      @include('header')
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
          <h2>₹{{ number_format($gifts->where('status', 0)->sum('saved_amount')) }}</h2>

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

@if($gift->status == 1)
   @continue   {{-- ✅ hide gift card permanently once paid --}}
@endif


          @php
            $progress = $gift->target_amount > 0 ? min(($gift->saved_amount / $gift->target_amount) * 100, 100) : 0;
            $needed = max($gift->target_amount - $gift->saved_amount, 0);
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

            @if($gift->saved_amount >= $gift->target_amount)
             <button class="pay-now-btn"
        data-id="{{ $gift->id }}"
        data-amount="{{ $gift->saved_amount }}"
        data-title="{{ $gift->title }}">
  Pay Now
</button>

            @else

            <!-- ✅ Gift Saving Form -->
            <form action="{{ route('kid.gifts.add') }}" method="POST" class="gift-form mt-3">
              @csrf

              <!-- ✅ MUST ADD THIS TO AVOID DAILY LIMIT BLOCK -->
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
                        }
                     "
                     required>

              <button type="submit" class="gift-add-btn">Add</button>
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

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", () => {
    showToast("{{ session('success') }}", "success");
});
</script>
@endif

    <div id="alertToast" class="alert-toast"></div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toast = document.getElementById("alertToast");

// ✅ Toast message
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = `alert-toast show alert-${type}`;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

// ✅ If redirected from Add Gift page, show toast
@if(session('success'))
  document.addEventListener("DOMContentLoaded", () => {
      showToast("{{ session('success') }}", "success");
  });
@endif

// ✅ Handle "Pay Now"
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
