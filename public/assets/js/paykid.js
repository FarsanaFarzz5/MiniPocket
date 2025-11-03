const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const limitNote = document.getElementById("limitNote");
const successMsg = document.getElementById("successMsg");
const form = document.querySelector("form");

// ===============================
// ✅ Handle Form Submission
// ===============================
form.addEventListener("submit", (e) => {
  e.preventDefault();

  const amount = parseFloat(amountInput.value.trim()) || 0;

  // ✅ Check for invalid, empty, or zero amount
  if (isNaN(amount) || amount <= 0) {
    limitNote.textContent = "⚠️ Please enter a valid amount greater than ₹0";
    limitNote.style.display = "block";
    limitNote.style.color = "#d32f2f";
    return; // stop submission
  }

  // ✅ Check for max limit
  if (amount > 100000) {
    limitNote.textContent = "⚠️ Maximum limit is ₹1,00,000";
    limitNote.style.display = "block";
    limitNote.style.color = "#d32f2f";
    return; // stop submission
  }

  // ✅ Amount is valid — proceed
  limitNote.style.display = "none";
  hiddenAmount.value = amount;

  successMsg.style.opacity = "1";
  setTimeout(() => {
    successMsg.style.opacity = "0";
    form.submit(); // continue actual submission after showing message
  }, 1500);
});

// ===============================
// ✅ Handle Input Events
// ===============================
amountInput.addEventListener("input", () => {
  // Remove leading zeros (e.g. 00005 → 5)
  if (/^0\d+/.test(amountInput.value)) {
    amountInput.value = amountInput.value.replace(/^0+/, "");
  }

  // Prevent negative numbers
  if (parseFloat(amountInput.value) < 0) {
    amountInput.value = "0";
  }

  // Smooth input width resizing
  amountInput.style.width = (amountInput.value.length * 22 + 50) + "px";

  const value = parseFloat(amountInput.value) || 0;

  // Cap the value at ₹1,00,000
  if (value > 100000) {
    amountInput.value = 100000;
    limitNote.textContent = "⚠️ Maximum limit is ₹1,00,000";
    limitNote.style.display = "block";
    limitNote.style.color = "#d32f2f";
  } 
  // Hide note for valid range
  else if (value > 0) {
    limitNote.style.display = "none";
  }
});
