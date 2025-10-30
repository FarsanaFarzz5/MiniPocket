
  let selectedUrl = '';

  // ✅ When a bank is clicked
  function confirmPrimary(url) {
    selectedUrl = url;
    document.getElementById("popup").style.display = "flex";
  }

  // ✅ Close popup function
  function closePopup() {
    document.getElementById("popup").style.display = "none";
    selectedUrl = '';
  }

  // ✅ Handle "YES" button
  document.getElementById("yesBtn").addEventListener("click", () => {
    if (selectedUrl) window.location.href = selectedUrl;
  });

  // ✅ Handle "NO" button
  document.getElementById("noBtn").addEventListener("click", () => {
    // Close popup
    closePopup();

    // 🔹 Remove active highlight & "Primary Account" tag visually
    document.querySelectorAll(".bank-card").forEach(card => {
      card.classList.remove("active");
      const tag = card.querySelector(".status-tag");
      if (tag) tag.remove();
    });

    // 🔹 Optional: Clear session in backend
    fetch("{{ route('parent.clear.bank.session') }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json",
      }
    });
  });

  // ✅ Add bank toggle functionality
  const grid = document.getElementById("bankGrid");
  const addBtn = document.querySelector(".add-bank-shortcut");

  function toggleBankGrid() {
    const isVisible = window.getComputedStyle(grid).display !== "none";
    grid.style.display = isVisible ? "none" : "grid";
    addBtn.setAttribute("data-active", isVisible ? "false" : "true");
  }

  // ✅ Redirect to add specific bank page
  function goToAddBank(bankName) {
    const encoded = encodeURIComponent(bankName);
    window.location.href = `/parent/bankaccounts/add/${encoded}`;
  }

  // ✅ Initial setup
  document.addEventListener("DOMContentLoaded", () => {
    grid.style.display = "none";
    addBtn.setAttribute("data-active", "false");
  });
