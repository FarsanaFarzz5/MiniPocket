<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank Accounts - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- ✅ Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bankaccounts.css') }}">
</head>

<body>
  <div class="container">
    <!-- 🧭 Sidebar -->
    @include('sidebar.sidebar')

    <!-- ✅ Logo and Heading -->
    <div class="logo-section">
      <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
    </div>

    <div class="page-header">
      <div class="header-inline" style="justify-content: center;">
        <h1>Payment Methods</h1>
      </div>
    </div>

    <!-- 💳 Bank List -->
    <div class="bank-list">
      @forelse($accounts as $account)
        @php
          $bankMap = [
              'hdfc bank' => 'hdfc.png',
              'canara bank' => 'canara.png',
              'sbi bank' => 'sbi.png',
              'axis bank' => 'axis.png',
              'icici bank' => 'icici.png',
              'kotak bank' => 'kotak.png'
          ];
          $key = strtolower(trim($account->bank_name));
          $bankFile = $bankMap[$key] ?? 'kotak.png';
        @endphp

        <div class="bank-card {{ session('active_bank_account') == $account->id ? 'active' : '' }}"
             onclick="confirmPrimary('{{ route('parent.select.bank', $account->id) }}')">
          <div class="bank-left">
            <img src="{{ asset('images/' . $bankFile) }}" alt="{{ $account->bank_name }}">
            <div class="bank-info">
              <h4>{{ $account->bank_name }}</h4>
              <p class="card-mask">
                Card No: <span>•••• {{ substr($account->card_number, -4) }}</span>
              </p>
            </div>
          </div>

          @if(session('active_bank_account') == $account->id)
            <span class="status-tag">Primary Account</span>
          @endif
        </div>
      @empty
        <p style="text-align:center; color:#999;">No bank accounts added yet.</p>
      @endforelse
    </div>

    <!-- ➕ Add Bank Shortcut -->
    <div class="add-bank-shortcut" onclick="toggleBankGrid()">
      <i class="fa-solid fa-building-columns"></i> Add Bank Account
    </div>

    <!-- 🏦 Bank Options Grid -->
    <div id="bankGrid">
      <div class="bank-option" onclick="goToAddBank('HDFC Bank')">
        <img src="{{ asset('images/hdfc.png') }}" alt="HDFC Bank">
        <span>HDFC Bank</span>
      </div>

      <div class="bank-option" onclick="goToAddBank('ICICI Bank')">
        <img src="{{ asset('images/icici.png') }}" alt="ICICI Bank">
        <span>ICICI Bank</span>
      </div>

      <div class="bank-option" onclick="goToAddBank('Canara Bank')">
        <img src="{{ asset('images/canara.png') }}" alt="Canara Bank">
        <span>Canara Bank</span>
      </div>

      <div class="bank-option" onclick="goToAddBank('Axis Bank')">
        <img src="{{ asset('images/axis.png') }}" alt="Axis Bank">
        <span>Axis Bank</span>
      </div>

      <div class="bank-option" onclick="goToAddBank('SBI Bank')">
        <img src="{{ asset('images/sbi.png') }}" alt="SBI Bank">
        <span>SBI Bank</span>
      </div>

      <div class="bank-option" onclick="goToAddBank('Kotak Bank')">
        <img src="{{ asset('images/kotak.png') }}" alt="Kotak Bank">
        <span>Kotak Bank</span>
      </div>
    </div>

    <!-- 🧾 Hidden Add Form -->
    <form id="addForm" action="{{ route('parent.add.bank') }}" method="POST" style="display:none;">
      @csrf
      <input type="hidden" id="bank_name" name="bank_name" required>
      <input type="hidden" name="account_number" value="0000000000">
      <input type="hidden" name="ifsc_code" value="XXXX000000">
      <input type="hidden" name="branch_name" value="Main Branch">
    </form>
  </div>

  <!-- ⚙️ Popup -->
  <div class="popup-overlay" id="popup">
    <div class="popup-box">
      <h3>Set this as your Primary Account?</h3>
      <div class="popup-btns">
        <button class="yes-btn" id="yesBtn">Yes</button>
        <button class="no-btn" id="noBtn">No</button>
      </div>
    </div>
  </div>

  <!-- ✅ JavaScript -->
  <script>
    // ======================================================
    // ✅ Bank Accounts Page JavaScript
    // ======================================================

    let selectedUrl = '';

    // ✅ When a bank is clicked — show confirmation popup
    function confirmPrimary(url) {
      selectedUrl = url;
      document.getElementById("popup").style.display = "flex";
    }

    // ✅ Close popup function
    function closePopup() {
      document.getElementById("popup").style.display = "none";
      selectedUrl = '';
    }

    // ✅ Handle "YES" button — set selected as primary
    document.getElementById("yesBtn").addEventListener("click", () => {
      if (selectedUrl) {
        window.location.href = selectedUrl;
      }
    });

    // ✅ Handle "NO" button — cancel selection & clear active visuals
    document.getElementById("noBtn").addEventListener("click", () => {
      closePopup();

      // 🔹 Remove highlight & primary tag visually
      document.querySelectorAll(".bank-card").forEach(card => {
        card.classList.remove("active");
        const tag = card.querySelector(".status-tag");
        if (tag) tag.remove();
      });

      // 🔹 Optional: Clear active bank session in backend
      fetch("{{ route('parent.clear.bank.session') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
          "Accept": "application/json",
        }
      });
    });

    // ======================================================
    // ✅ Add Bank Grid Toggle
    // ======================================================

    const grid = document.getElementById("bankGrid");
    const addBtn = document.querySelector(".add-bank-shortcut");

    function toggleBankGrid() {
      const isVisible = window.getComputedStyle(grid).display !== "none";
      grid.style.display = isVisible ? "none" : "grid";
      addBtn.setAttribute("data-active", isVisible ? "false" : "true");
    }

    // ======================================================
    // ✅ Go To Add Bank Page
    // ======================================================

    function goToAddBank(bankName) {
      const encoded = encodeURIComponent(bankName);
      window.location.href = `/parent/bankaccounts/add/${encoded}`;
    }

    // ======================================================
    // ✅ Initialize on Page Load
    // ======================================================

    document.addEventListener("DOMContentLoaded", () => {
      if (grid) grid.style.display = "none";
      if (addBtn) addBtn.setAttribute("data-active", "false");
    });
  </script>
</body>
</html>
