const amountInput = document.getElementById("amountInput");
const hiddenAmount = document.getElementById("hiddenAmount");
const limitNote = document.getElementById("limitNote");
const successMsg = document.getElementById("successMsg");
const form = document.querySelector("form");

// ===============================
// 🚀 FIX STARTS HERE
// STOP FORM FROM RELOADING PAGE
// ===============================
form.addEventListener("submit", function(e) {
    e.preventDefault(); 

    if (!setAmountBeforeSubmit()) return;

    // show alert
    showAlert("Money sent successfully!", "success");

    const formData = new FormData(form);

    // send form WITHOUT reload
    fetch(form.action, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // redirect AFTER alert
            setTimeout(() => {
                window.location.href = "/parent";
            }, 1000);
        }
    });
});

// ===============================
// ALERT BOX
// ===============================
function showAlert(message, type = "success") {
    successMsg.innerText = message;
    successMsg.style.background = type === "success" ? "#00c853" : "#d32f2f";
    successMsg.style.opacity = 1;

    // Redirect immediately after 1 second
    setTimeout(() => {
        window.location.href = "/parent";
    }, 1000);
}

// ===============================
// VALIDATION
// ===============================
function setAmountBeforeSubmit() {
    const amount = parseFloat(amountInput.value.trim()) || 0;

    if (amount <= 0) {
        limitNote.textContent = "⚠️ Please enter a valid amount greater than ₹0";
        limitNote.style.display = "block";
        limitNote.style.color = "#d32f2f";
        return false;
    }

    if (amount > 100000) {
        limitNote.textContent = "⚠️ Maximum limit is ₹1,00,000";
        limitNote.style.display = "block";
        limitNote.style.color = "#d32f2f";
        return false;
    }

    hiddenAmount.value = amount;
    return true;
}

// ===============================
// INPUT EVENTS
// ===============================
amountInput.addEventListener("input", () => {

    if (/^0\d+/.test(amountInput.value)) {
        amountInput.value = amountInput.value.replace(/^0+/, "");
    }

    if (parseFloat(amountInput.value) < 0) {
        amountInput.value = "0";
    }

    amountInput.style.width = (amountInput.value.length * 22 + 50) + "px";

    const value = parseFloat(amountInput.value) || 0;

    if (value > 100000) {
        amountInput.value = 100000;
        limitNote.textContent = "⚠️ Maximum limit is ₹1,00,000";
        limitNote.style.display = "block";
        limitNote.style.color = "#d32f2f";
    } else if (value > 0) {
        limitNote.style.display = "none";
    }
});
