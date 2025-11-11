const urlParams = new URLSearchParams(window.location.search);
const giftId = urlParams.get("gift_id");
const price = urlParams.get("price");
const item = urlParams.get("item");

const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const form = document.querySelector("form");
const toast = document.getElementById("alertToast");

// ✅ Pre-fill if gift data is passed from QR
if (giftId && price) {
  amountInput.value = price;
  hiddenAmount.value = price;

  const descInput = form.querySelector('[name="description"]');
  if (descInput && item) descInput.value = `Payment for gift: ${item}`;
}

// ✅ Toast message
function showToast(msg, type = "success") {
  toast.innerText = msg;
  toast.className = "alert-toast show alert-" + type;
  setTimeout(() => toast.classList.remove("show"), 2500);
}

const SEND_URL = "{{ route('kid.send.gift.money') }}";
const CSRF_TOKEN = "{{ csrf_token() }}";

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

    showToast(`✅ ₹${enteredAmount} gift payment successful!`, "success");
    setTimeout(() => (window.location.href = "{{ route('kid.dashboard') }}"), 1500);

  } catch (err) {
    console.error(err);
    showToast("🚫 Network error. Please try again.", "error");
  }
});
