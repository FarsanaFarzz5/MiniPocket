/* **********************************************************
   🔎 Detect Transfer Type (parent / normal / gift / goal refund)
********************************************************** */

const urlParams = new URLSearchParams(window.location.search);
const transferType = urlParams.get("type"); // "parent" for kid → parent return

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
   📌 PREFILL (Gift / Goal Payment / Refund to Parent)
********************************************************** */

/* ---------- 1️⃣ Gift Payment ------------ */
const savedGiftAmount = localStorage.getItem("giftAmount");
const savedGiftReason = localStorage.getItem("giftReason");

/* ---------- 2️⃣ Goal Payment ------------ */
const savedGoalAmount = localStorage.getItem("goalAmount");
const savedGoalReason = localStorage.getItem("goalReason");
const savedGoalId = localStorage.getItem("goalId");

/* ---------- 3️⃣ Refund → Parent (Goal/Gift) ------------ */
const parentReturnAmount = localStorage.getItem("parentReturnAmount");
const parentReturnReason = localStorage.getItem("parentReturnReason");
const parentReturnGoalId = localStorage.getItem("parentReturnGoalId");  // goal
const parentReturnGiftId = localStorage.getItem("parentReturnGiftId");  // gift ✔

/* ---------- SELECT FINAL PREFILL ------------ */
let fillAmount =
  parentReturnAmount || savedGiftAmount || savedGoalAmount;

let fillReason =
  parentReturnReason || savedGiftReason || savedGoalReason;

/* ---------- Insert amount ------------ */
if (window.location.pathname !== "/kid/pay" && fillAmount) {
  amountInput.value = fillAmount;
  hiddenAmount.value = fillAmount;
  amountInput.style.width = amountInput.value.length * 24 + 40 + "px";
}

/* ---------- Insert description ------------ */
if (fillReason) {
  const reasonBox = form.querySelector('[name="description"]');
  if (reasonBox) reasonBox.value = fillReason;
}


/* **********************************************************
   🧹 Clear Prefill Storage
********************************************************** */
function clearPrefillData() {
  // Gift Payment
  localStorage.removeItem("giftAmount");
  localStorage.removeItem("giftReason");

  // Goal Payment
  localStorage.removeItem("goalAmount");
  localStorage.removeItem("goalReason");
  localStorage.removeItem("goalId");

  // Refunds (goal or gift)
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
    targetUrl = "/kid/sendtoparent";   // refund (gift/goal)
  } 
  else if (savedGiftAmount) {
    targetUrl = "/kid/sendgiftmoney";  // gift purchase
  } 
  else if (savedGoalAmount) {
    targetUrl = "/kid/sendgoalpayment";  // goal purchase
  } 
  else if (transferType === "parent") {
    targetUrl = "/kid/sendtoparent";  // manual parent transfer
  }


  /* ******************************************************
     📨 API CALL
  ****************************************************** */

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

        /* -----------------------------------------------
            Sending IDs properly
            priority order:
            1) Refund Gift
            2) Refund Goal
            3) Goal Purchase
        ------------------------------------------------ */
        gift_id: parentReturnGiftId
          ? Number(parentReturnGiftId)   // refund
          : savedGiftAmount
          ? Number(localStorage.getItem("giftId"))   // payment
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

    if (!response.ok || !data.success) {
      showToast(data.message || "Transaction failed.", "warning");
      return;
    }

    showToast(`₹${enteredAmount} processed successfully!`, "success");


    /* ******************************************************
       🎯 Success Redirection
    ****************************************************** */

    setTimeout(() => {

      // Goal purchase
      if (savedGoalAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/goals");
      }

      // Gift purchase
      if (savedGiftAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/gifts");
      }

      // Refund (goal or gift)
      if (parentReturnAmount) {
        clearPrefillData();
        return (window.location.href = "/kid/dashboard");
      }

      // Manual parent transfer
      if (transferType === "parent") {
        return (window.location.href = "/kid/dashboard");
      }

      // Normal spending
      return (window.location.href = DASHBOARD_URL);

    }, 1200);

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
