<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>Add New Gift</title>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/addgift.css') }}">

  <style>
    /* ✅ Toast Alert Message */
    .alert-toast {
      position: fixed;
      bottom: 85px;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px 18px;
      background: #333;
      color: #fff;
      font-size: 14px;
      font-weight: 500;
      border-radius: 10px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s ease-in-out;
      z-index: 9999;
    }
    .alert-toast.show {
      opacity: 1;
      visibility: visible;
      bottom: 100px;
    }
    .alert-success {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #fff;
    }
    .alert-error {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="gift-container">
    <div class="gift-header">
      <i class="bi bi-gift-fill"></i> Add New Gift
    </div>

    <div class="gift-form-card">
      <form action="{{ route('kid.gifts.store') }}" method="POST">
        @csrf

        <!-- Gift Title -->
        <label for="gift-title">Gift Title</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-box2-heart"></i></span>
          <input type="text" id="gift-title" name="title" class="form-control" placeholder="e.g. Headphones" required>
        </div>

        <!-- ✅ Numeric keypad + only digits allowed -->
        <label for="gift-amount">Target Amount (₹)</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>

          <input type="text" id="gift-amount" name="target_amount"
                 class="form-control"
                 placeholder="Enter amount"
                 inputmode="numeric"
                 pattern="[0-9]*"
                 oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                 required>
        </div>

        <!-- Buttons -->
        <div class="btn-row">
          <button type="submit" class="btn-save">Save Gift</button>

          <!-- ✅ No double click issue -->
          <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('kid.gifts') }}'">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ✅ Alert Toast -->
  <div id="alertToast" class="alert-toast"></div>

  <script>
    // ✅ Only scroll input into view when keyboard opens on mobile
    document.querySelectorAll("input").forEach(input => {
      input.addEventListener("focus", () => {
        setTimeout(() => input.scrollIntoView({ behavior: "smooth", block: "center" }), 300);
      });
    });

    // ✅ Toast message function
    const toast = document.getElementById("alertToast");
    function showToast(msg, type = "success") {
      toast.innerText = msg;
      toast.className = `alert-toast show alert-${type}`;
      setTimeout(() => toast.classList.remove("show"), 2500);
    }

    // ✅ If success message passed from backend
    @if(session('success'))
      showToast("{{ session('success') }}", "success");
    @endif

    @if(session('error'))
      showToast("{{ session('error') }}", "error");
    @endif
  </script>

</body>
</html>
