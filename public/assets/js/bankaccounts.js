
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
