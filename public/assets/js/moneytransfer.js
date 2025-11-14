const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const form = document.querySelector("form");
const toast = document.getElementById("alertToast");

// ✅ Toast
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

// ✅ Redirect to dashboard on error
function redirect(message) {
  showToast(message, "error");
  setTimeout(() => window.location.href = DASHBOARD_URL, 1500);
}

/* **********************************************************
   ✅ PREFILL — Gift Payment / Goal Payment data (localStorage)
********************************************************** */

// From Gift page
const savedGiftAmount = localStorage.getItem("giftAmount");
const savedGiftReason = localStorage.getItem("giftReason");

// From Goal page
const savedGoalAmount = localStorage.getItem("goalAmount");
const savedGoalReason = localStorage.getItem("goalReason");
const savedGoalId     = localStorage.getItem("goalId");

// ✅ Decide which amount is being paid
const fillAmount = savedGiftAmount || savedGoalAmount;
const fillReason = savedGiftReason || savedGoalReason;

// ❗ Prevent overwrite on QR page
if (window.location.pathname !== "/kid/pay" && fillAmount) {
  amountInput.value = fillAmount;
  hiddenAmount.value = fillAmount;
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
}

// ✅ Autofill description for Gift / Goal
if (fillReason) {
  const reasonBox = form.querySelector('[name="description"]');
  if (reasonBox) reasonBox.value = fillReason;
}

function clearPrefillData() {
    localStorage.removeItem("giftAmount");
    localStorage.removeItem("giftReason");
    localStorage.removeItem("goalAmount");
    localStorage.removeItem("goalReason");
    localStorage.removeItem("goalId");
}

/* **********************************************************
   ✅ FORM SUBMIT — Scan QR ➝ Final Payment API call
********************************************************** */

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const enteredAmount = parseFloat(amountInput.value);
  hiddenAmount.value = enteredAmount;
  const description = form.querySelector('[name="description"]').value;

  if (isNaN(enteredAmount) || enteredAmount <= 0) {
    showToast(" Please enter a valid amount.", "warning");
    return;
  }

  // ✅ Determine backend endpoint
  let targetUrl = SEND_URL;          // Normal spending
  if (savedGiftAmount) targetUrl = "/kid/sendgiftmoney";
  if (savedGoalAmount) targetUrl = "/kid/sendgoalpayment";

  try {
    const response = await fetch(targetUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": CSRF_TOKEN,
      },
      body: JSON.stringify({
        amount: enteredAmount,
        description: description,
        goal_id: savedGoalId ?? null, // ✅ goal id included only for goal payment
      }),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok || !data.success) {
      showToast(data.message || "Transaction failed.", "warning");
      return;
    }

    showToast(`✅ ₹${enteredAmount} spent successfully!`, "success");

setTimeout(() => {
  /* 🎁 After GIFT PAYMENT */
  if (savedGiftAmount) {
    localStorage.removeItem("giftAmount");
    localStorage.removeItem("giftReason");

    showToast("Gift paid successfully", "success");
    return setTimeout(() => window.location.href = "/kid/gifts", 1200);
  }

  /* 🎯 After GOAL PAYMENT */
  if (savedGoalAmount) {
    localStorage.removeItem("goalAmount");
    localStorage.removeItem("goalReason");
    localStorage.removeItem("goalId");

    showToast("Goal paid successfully", "success");
    return setTimeout(() => window.location.href = "/kid/goals", 1200);
  }

  /* ✅ NORMAL PAYMENT (NO gift / NO goal) */
  return setTimeout(() => {
    window.location.href = DASHBOARD_URL;  // ← Kiddashboard redirect
  }, 1200);

}, 1200);


  } catch (err) {
    console.error(err);
    redirect("Network error. Redirecting...");
  }
});

/* **********************************************************
   ✅ Input Validation — numeric only
********************************************************** */

function validateAmountInput(input) {
  input.value = input.value.replace(/[^0-9]/g, "");
  const num = parseFloat(input.value || 0);
  if (num > 100000) input.value = "100000";
}

// Resize input automatically
amountInput.addEventListener("input", () => {
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
});
