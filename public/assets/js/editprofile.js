/* ===========================================================
  Toast Function
=========================================================== */
function showToast(message, type = "success") {
  const toast = document.getElementById("alertToast");
  toast.innerText = message;
  toast.className = "alert-toast";
  void toast.offsetWidth;
  toast.classList.add("show", `alert-${type}`);
  setTimeout(() => toast.classList.remove("show"), 3800);
}

/* ===========================================================
  Validation
=========================================================== */
document.getElementById("profileForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const firstName = document.getElementById("first_name").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone_no").value.trim();
  const originalEmail = document.getElementById("originalEmail").value.trim();

  const namePattern = /^[A-Za-z_][A-Za-z_]*$/;
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  const phonePattern = /^[0-9]{10}$/;

  if (!firstName || !namePattern.test(firstName)) {
    showToast("Please enter a valid first name.", "warning");
    return;
  }

  if (!email || !emailPattern.test(email)) {
    showToast("Please enter a valid email address.", "warning");
    return;
  }

  if (!phone || !phonePattern.test(phone)) {
    showToast("Please enter a valid 10-digit phone number.", "warning");
    return;
  }

  /* ===========================================================
     FRONTEND EMAIL CHECK
     (No backend → we can only compare with original)
  ============================================================ */
if (email.trim().toLowerCase() === originalEmail.trim().toLowerCase()) {
    showToast("Email already exists.", "warning");
    return;
}

  // Submit form finally
  this.submit();
});
