/* **********************************************************
   🔎 Detect Transfer Type (parent / normal / gift / goal refund)
********************************************************** */

const urlParams = new URLSearchParams(window.location.search);
const transferType = urlParams.get("type");

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
   📌 PREFILL LOGIC
********************************************************** */

let savedGiftAmount = localStorage.getItem("giftAmount");
let savedGiftReason = localStorage.getItem("giftReason");
let savedGiftId = localStorage.getItem("giftId");

let savedGoalAmount = localStorage.getItem("goalAmount");
let savedGoalReason = localStorage.getItem("goalReason");
let savedGoalId = localStorage.getItem("goalId");

let parentReturnAmount = localStorage.getItem("parentReturnAmount");
let parentReturnReason = localStorage.getItem("parentReturnReason");
let parentReturnGoalId = localStorage.getItem("parentReturnGoalId");
let parentReturnGiftId = localStorage.getItem("parentReturnGiftId");

let fillAmount =
  parentReturnAmount || savedGiftAmount || savedGoalAmount;

let fillReason =
  parentReturnReason || savedGiftReason || savedGoalReason;

if (window.location.pathname !== "/kid/pay" && fillAmount) {
  amountInput.value = fillAmount;
  hiddenAmount.value = fillAmount;
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
}

if (fillReason) {
  const reasonBox = form.querySelector('[name="description"]');
  if (reasonBox) reasonBox.value = fillReason;
}

/* **********************************************************
   🧹 Clear all temp values
********************************************************** */
function clearPrefillData() {
  localStorage.removeItem("giftAmount");
  localStorage.removeItem("giftReason");
  localStorage.removeItem("giftId");

  localStorage.removeItem("goalAmount");
  localStorage.removeItem("goalReason");
  localStorage.removeItem("goalId");

  localStorage.removeItem("parentReturnAmount");
  localStorage.removeItem("parentReturnReason");
  localStorage.removeItem("parentReturnGoalId");
  localStorage.removeItem("parentReturnGiftId");
}

/* **********************************************************
   🚀 FORM SUBMIT — Final API Trigger
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
     🔗 Decide BACKEND ENDPOINT
  ****************************************************** */

  let targetUrl = SEND_URL; // default normal spending

  if (parentReturnAmount) {
    targetUrl = "/kid/sendtoparent";
  } 
  else if (savedGiftAmount) {
    targetUrl = "/kid/sendgiftmoney";
  } 
  else if (savedGoalAmount) {
    targetUrl = "/kid/sendgoalpayment";
  } 
  else if (transferType === "parent") {
    targetUrl = "/kid/sendtoparent";
  }

  /* ******************************************************
     📨 API CALL
  ****************************************************** */

  try {
    const response = await fetch(targetUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": CSRF_TOKEN,
      },
      body: JSON.stringify({
        amount: enteredAmount,
        description: description,

        gift_id: parentReturnGiftId
          ? Number(parentReturnGiftId)
          : savedGiftAmount
          ? Number(savedGiftId)
          : null,

        goal_id: parentReturnGiftId
          ? null
          : parentReturnGoalId
          ? Number(parentReturnGoalId)
          : savedGoalId
          ? Number(savedGoalId)
          : null,
      }),
    });

    const data = await response.json().catch(() => ({}));

    // IMPORTANT: check only data.success
    if (!data.success) {
      showToast(data.message || "Transaction failed.", "warning");
      return;
    }

    /* ******************************************************
       🎉 SUCCESS MESSAGE
    ****************************************************** */
    showToast(`₹${enteredAmount} processed successfully!`, "success");

    setTimeout(() => {
      /* Hide paid gift cards */
      const paidGiftId = localStorage.getItem("giftIdPaid");
      if (paidGiftId) {
        const card = document.getElementById("gift-card-" + paidGiftId);
        if (card) card.style.display = "none";
        localStorage.removeItem("giftIdPaid");
      }

      const returnGiftId = localStorage.getItem("parentReturnGiftId");
      if (returnGiftId) {
        const card = document.getElementById("gift-card-" + returnGiftId);
        if (card) card.style.display = "none";
        localStorage.removeItem("parentReturnGiftId");
      }
    }, 400);

    /* ******************************************************
       🎯 SUCCESS REDIRECT LOGIC
    ****************************************************** */

    setTimeout(() => {
      if (savedGoalAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/goals");
      }

      if (savedGiftAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/gifts");
      }

      if (parentReturnAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/dashboard");
      }

      if (transferType === "parent") {
        return (window.location.href = "/kid/dashboard");
      }

      return (window.location.href = DASHBOARD_URL);

    }, 1000);

  } catch (err) {
    console.error(err);
    redirect("Network error. Redirecting...");
  }
});

/* **********************************************************
   🔢 Input Validation & Auto Resize
********************************************************** */

function validateAmountInput(input) {
  input.value = input.value.replace(/[^0-9]/g, "");
  const num = parseFloat(input.value || 0);
  if (num > 100000) input.value = "100000";
}

amountInput.addEventListener("input", () => {
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
});
