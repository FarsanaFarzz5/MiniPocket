/* ===========================================================
✅ Toast Function
=========================================================== */
function showToast(message, type = "success") {
  const toast = document.getElementById("alertToast");
  toast.innerText = message;
  toast.className = "alert-toast";   // reset previous state
  void toast.offsetWidth;            // 🔥 force reflow for animation restart
  toast.classList.add("show", `alert-${type}`);
  setTimeout(() => toast.classList.remove("show"), 2800);
}

/* ===========================================================
✅ Format date as YYYY-MM-DD
=========================================================== */
function toYMD(d) {
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, "0");
  const day = String(d.getDate()).padStart(2, "0");
  return `${y}-${m}-${day}`;
}

/* ===========================================================
✅ Allow DOB only from 1900–01–01 to 2015–12–31
=========================================================== */
document.addEventListener("DOMContentLoaded", () => {
  const dobInput = document.getElementById("dob");
  if (dobInput) {
    const minDate = new Date("1900-01-01");
    const maxDate = new Date("2015-12-31");
    dobInput.dataset.min = toYMD(minDate);  // store manually
    dobInput.dataset.max = toYMD(maxDate);
  }
});

/* ===========================================================
✅ Form Validation (custom toast only)
=========================================================== */
document.getElementById("profileForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const firstName = document.getElementById("first_name").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone_no").value.trim();
  const dobInput = document.getElementById("dob");
  const dob = dobInput.value.trim();

  const namePattern = /^[A-Za-z_][A-Za-z_]*$/;
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  const phonePattern = /^[0-9]{10}$/;

  // ✅ Validate First Name
  if (!firstName || !namePattern.test(firstName)) {
    showToast("Please enter a valid first name.", "warning");
    return;
  }

  // ✅ Validate Email
  if (!email || !emailPattern.test(email)) {
    showToast("Please enter a valid email address.", "warning");
    return;
  }

  // ✅ Validate Phone
  if (!phone || !phonePattern.test(phone)) {
    showToast("Please enter a valid 10-digit phone number.", "warning");
    return;
  }

  // ✅ Validate DOB (custom range)
  if (!dob) {
    showToast("Please select your date of birth.", "warning");
    return;
  }

  const selected = new Date(dob);
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const maxAllowed = new Date("2015-12-31");
  const minAllowed = new Date("1900-01-01");

  if (selected >= today) {
    showToast("Date of birth cannot be today or in the future.", "warning");
    return;
  }
  if (selected > maxAllowed) {
    showToast("Date of birth cannot be after 2015.", "warning");
    return;
  }
  if (selected < minAllowed || isNaN(selected.getTime())) {
    showToast("Please select a valid date of birth (1900–2015).", "warning");
    return;
  }

  // ✅ Success Toast
  showToast("Profile updated successfully!", "success");
  setTimeout(() => this.submit(), 1200);
});
