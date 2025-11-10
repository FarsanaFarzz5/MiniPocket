const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const form = document.querySelector("form");
const toast = document.getElementById("alertToast");

// ✅ Toast message
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

// ✅ Redirect with delay
function redirect(message) {
  showToast(message, "error");
  setTimeout(() => window.location.href = DASHBOARD_URL, 1500);
}

// ✅ Form submission
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const enteredAmount = parseFloat(amountInput.value);
  hiddenAmount.value = enteredAmount;
  const description = form.querySelector('[name="description"]').value;

  if (isNaN(enteredAmount) || enteredAmount <= 0) {
    showToast("⚠️ Please enter a valid amount.", "warning");
    return;
  }

  try {
    const response = await fetch(SEND_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": CSRF_TOKEN,
      },
      body: JSON.stringify({ amount: enteredAmount, description }),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok || !data.success) {
      showToast(data.message || "⚠️ Transaction failed.", "warning");
      return;
    }

    showToast(`✅ ₹${enteredAmount} spent successfully!`, "success");
    setTimeout(() => {
      showToast("Redirecting to dashboard...", "success");
      setTimeout(() => window.location.href = DASHBOARD_URL, 1500);
    }, 1800);

  } catch (err) {
    console.error(err);
    redirect("🚫 Network error. Redirecting...");
  }
});

// ✅ Input validation
function validateAmountInput(input) {
  input.value = input.value.replace(/[^0-9]/g, "");
  const num = parseFloat(input.value || 0);
  if (num > 100000) input.value = "100000";
}

amountInput.addEventListener("input", () => {
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
});
