
const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const form = document.querySelector("form");
const toast = document.getElementById("alertToast");

const DASHBOARD_URL = "{{ route('kid.dashboard') }}";
const SEND_URL = "{{ route('kid.send.money') }}";
const DAILY_LIMIT = Number("{{ $user->daily_limit ?? 0 }}") || 0;
let SPENT_TODAY = Number("{{ $user->spent_today ?? 0 }}") || 0;
let REMAINING_LIMIT = DAILY_LIMIT - SPENT_TODAY;

// ✅ Toast message (visible 1s before fade)
function showToast(msg, type="success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500); // stays for ~1s before fade
}

// ✅ Redirect with small delay
function redirect(message) {
  showToast(message, "error");
  setTimeout(() => window.location.href = DASHBOARD_URL, 1500);
}

// ✅ Logic
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const enteredAmount = parseFloat(amountInput.value);
  hiddenAmount.value = enteredAmount;
  const description = form.querySelector('[name="description"]').value;

  if (isNaN(enteredAmount) || enteredAmount <= 0) {
    showToast("⚠️ Please enter a valid amount.", "warning");
    return;
  }
  if (REMAINING_LIMIT <= 0) {
    redirect("🚫 Daily limit finished. Redirecting...");
    return;
  }
  if (enteredAmount > REMAINING_LIMIT) {
    showToast(`⚠️ Only ₹${REMAINING_LIMIT} left for today.`, "warning");
    return;
  }

  try {
    const response = await fetch(SEND_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
      },
      body: JSON.stringify({ amount: enteredAmount, description }),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok || !data.success) {
      const backendLimit = Number(data.remaining_limit ?? REMAINING_LIMIT);
      if (backendLimit <= 0) redirect("🚫 Daily limit finished. Redirecting...");
      else showToast("⚠️ Transaction failed. Try again.", "warning");
      return;
    }

    showToast(`✅ ₹${enteredAmount} paid successfully!`, "success");
    SPENT_TODAY += enteredAmount;
    REMAINING_LIMIT = DAILY_LIMIT - SPENT_TODAY;

    setTimeout(() => {
      showToast("✅ Redirecting to dashboard...", "success");
      setTimeout(() => window.location.href = DASHBOARD_URL, 1500);
    }, 1800);

  } catch (err) {
    console.error(err);
    redirect("🚫 Network error. Redirecting...");
  }
});

// 🔢 Input validation
function validateAmountInput(input) {
  input.value = input.value.replace(/[^0-9]/g, "");
  const num = parseFloat(input.value || 0);
  if (num > 100000) input.value = "100000";
}

// 🪄 Auto-width
amountInput.addEventListener("input", () => {
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
});
