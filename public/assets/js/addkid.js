document.addEventListener("DOMContentLoaded", () => {
  const avatarOptions = document.querySelectorAll(".avatar-option");
  const profileInput = document.getElementById("profile_img"); // image upload input

  /* ✅ Avatar selection highlight */
  avatarOptions.forEach(option => {
    option.addEventListener("click", function () {
      avatarOptions.forEach(opt => opt.classList.remove("selected"));
      this.classList.add("selected");
      this.querySelector("input").checked = true;

      // Clear file input if avatar is selected
      if (profileInput) profileInput.value = "";
    });
  });

  /* ✅ Clear avatar if custom image chosen */
  if (profileInput) {
    profileInput.addEventListener("change", () => {
      if (profileInput.files.length > 0) {
        avatarOptions.forEach(opt => {
          opt.classList.remove("selected");
          opt.querySelector("input").checked = false;
        });
      }
    });
  }

  /* ✅ Auto scroll input to center when keyboard appears */
  document.querySelectorAll("input, select").forEach(input => {
    input.addEventListener("focus", () => {
      setTimeout(() => input.scrollIntoView({ behavior: "smooth", block: "center" }), 300);
    });
  });

  /* ✅ Form validation */
  document.getElementById("kidForm").addEventListener("submit", function (e) {
    e.preventDefault();
    document.querySelectorAll(".error-text").forEach(el => el.textContent = "");

    const name = document.getElementById("first_name").value.trim();
    const dob = document.getElementById("dob").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone_no").value.trim();
    const gender = document.getElementById("gender").value;
    const avatarSelected = document.querySelector('input[name="avatar_choice"]:checked');
    const profileSelected = profileInput && profileInput.files.length > 0;

    const namePattern = /^[A-Za-z_][A-Za-z_]*$/;
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    const phonePattern = /^[0-9]{10}$/;
    const today = new Date(); today.setHours(0, 0, 0, 0);
    const selectedDate = new Date(dob);

    let valid = true;

    if (!name || !namePattern.test(name)) valid = false;
    if (!dob || selectedDate >= today) valid = false;
    if (!email || !emailPattern.test(email)) valid = false;
    if (!phone || !phonePattern.test(phone)) valid = false;
    if (!gender) valid = false;

    // Avatar or image required
    if (!avatarSelected && !profileSelected) valid = false;

    // Additional check for selected file (image)
    if (profileSelected) {
      const file = profileInput.files[0];
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
      if (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024)
        valid = false;
    }

    // 🚫 Validation failed
    if (!valid) {
      showToast("warning", " Please correct errors and try again.");
      return;
    }

    // ✅ Success toast
    showToast("success", " Kid added successfully!");

    setTimeout(() => this.submit(), 1200);
  });
});



/* ===========================================================
✅ TOAST FUNCTION (Unified & Smooth)
=========================================================== */
function showToast(type, message) {
  const toast = document.getElementById("alertToast");
  if (!toast) return;

  toast.className = `alert-toast alert-${type}`;
  toast.textContent = message;

  requestAnimationFrame(() => {
    toast.classList.add("show");
  });

  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000);
}
