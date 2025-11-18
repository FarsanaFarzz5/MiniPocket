/* **********************************************************
   🔎 Detect Transfer Type (parent / normal / gift / goal)
********************************************************** */

const urlParams = new URLSearchParams(window.location.search);
const transferType = urlParams.get("type"); // ← "parent" when kid → parent transfer

const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const form = document.querySelector("form");
const toast = document.getElementById("alertToast");

/* **********************************************************
   🔔 Toast
********************************************************** */
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

function redirect(message) {
  showToast(message, "error");
  setTimeout(() => (window.location.href = DASHBOARD_URL), 1500);
}

/* **********************************************************
   📌 PREFILL (Gift / Goal)
********************************************************** */

// Gift
const savedGiftAmount = localStorage.getItem("giftAmount");
const savedGiftReason = localStorage.getItem("giftReason");

// Goal
const savedGoalAmount = localStorage.getItem("goalAmount");
const savedGoalReason = localStorage.getItem("goalReason");
const savedGoalId = localStorage.getItem("goalId");

// Decide fill values
const fillAmount = savedGiftAmount || savedGoalAmount;
const fillReason = savedGiftReason || savedGoalReason;

// Insert prefill amount (NOT on scan page)
if (window.location.pathname !== "/kid/pay" && fillAmount) {
  amountInput.value = fillAmount;
  hiddenAmount.value = fillAmount;
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
}

// Insert description
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
   🚀 FORM SUBMIT — Final Payment API
********************************************************** */
form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const enteredAmount = parseFloat(amountInput.value);
  hiddenAmount.value = enteredAmount;

  const description = form.querySelector('[name="description"]').value;

  if (isNaN(enteredAmount) || enteredAmount <= 0) {
    showToast("Please enter a valid amount.", "warning");
    return;
  }

  /* ******************************************************
     🔗 DECIDE BACKEND ENDPOINT
  ****************************************************** */

  let targetUrl = SEND_URL; // normal spending

  if (transferType === "parent") {
    targetUrl = "/kid/sendtoparent"; // ⬅ money to parent
  }

  if (savedGiftAmount) {
    targetUrl = "/kid/sendgiftmoney";
  }

  if (savedGoalAmount) {
    targetUrl = "/kid/sendgoalpayment";
  }

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
        goal_id: savedGoalId ?? null,
      }),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok || !data.success) {
      showToast(data.message || "Transaction failed.", "warning");
      return;
    }

    showToast(`₹${enteredAmount} spent successfully!`, "success");

    /* ******************************************************
       🎯 SUCCESS REDIRECTIONS
    ****************************************************** */
    setTimeout(() => {
      /* 🎁 Gift payment */
      if (savedGiftAmount) {
        clearPrefillData();
        showToast("Gift paid successfully!", "success");
        return setTimeout(() => (window.location.href = "/kid/gifts"), 1200);
      }

      /* 🎯 Goal payment */
      if (savedGoalAmount) {
        clearPrefillData();
        showToast("Goal payment successful!", "success");
        return setTimeout(() => (window.location.href = "/kid/goals"), 1200);
      }

      /* 👨‍👧 Kid → Parent transfer */
      if (transferType === "parent") {
        showToast("Money sent to parent successfully!", "success");
        return setTimeout(() => (window.location.href = "/kid/dashboard"), 1200);
      }

      /* 💸 Normal spending */
      return setTimeout(() => {
        window.location.href = DASHBOARD_URL;
      }, 1200);
    }, 1200);
  } catch (err) {
    console.error(err);
    redirect("Network error. Redirecting...");
  }
});

/* **********************************************************
   🔢 Input Validation
********************************************************** */

function validateAmountInput(input) {
  input.value = input.value.replace(/[^0-9]/g, "");
  const num = parseFloat(input.value || 0);
  if (num > 100000) input.value = "100000";
}

// Auto-resize
amountInput.addEventListener("input", () => {
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
});
