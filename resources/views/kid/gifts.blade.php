<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Gift Savings - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- ✅ ADD THIS LINE -->
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
           @php
  $needed = max($gift->target_amount - $gift->saved_amount, 0);
@endphp

<div class="target-info d-flex justify-content-between mb-0">
  <span>Saved: ₹{{ number_format($gift->saved_amount, 2) }}</span>
  <span>Target: ₹{{ number_format($needed, 2) }}</span>
</div>


            @if($gift->saved_amount >= $gift->target_amount)
              <button class="pay-now-btn">Pay Now</button>
            @else
<form action="{{ route('kid.gifts.add') }}" method="POST" class="gift-form mt-3">
  @csrf
  <input type="hidden" name="gift_id" value="{{ $gift->id }}">

@php
   $remaining = $gift->target_amount - $gift->saved_amount;
@endphp

<input type="text" name="amount" class="gift-input"
       placeholder="Save amount"
       inputmode="numeric"
       pattern="[0-9]*"
       max="{{ $remaining }}"
       oninput="
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value !== '' && parseInt(this.value) > {{ $remaining }}) {
                this.value = {{ $remaining }};
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
      showToast("success", "{{ session('success') }}");
  });
</script>
@endif

    <!-- ✅ Toast Alert -->
<div id="alertToast" class="alert-toast"></div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
/* ✅ Toast function */
function showToast(type, message) {
  const toast = document.getElementById("alertToast");
  toast.className = `alert-toast alert-${type}`;
  toast.textContent = message;

  requestAnimationFrame(() => {
    toast.classList.add("show");
  });

  setTimeout(() => {
    toast.classList.remove("show");
  }, 2800);
}


    document.querySelectorAll('.pay-now-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        window.location.href = "{{ route('kid.scanqr') }}";
      });
    });

    document.querySelectorAll("input[type=number]").forEach(input => {
    input.addEventListener("wheel", e => e.preventDefault());
});
  </script>
</body>
</html>