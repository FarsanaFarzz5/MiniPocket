document.addEventListener("DOMContentLoaded", () => {
  const avatarOptions = document.querySelectorAll(".avatar-option");
  const profileInput = document.getElementById("profile_img"); // make sure you have <input type="file" id="profile_img">

  // ✅ Avatar selection highlight
  avatarOptions.forEach(option => {
    option.addEventListener("click", function() {
      avatarOptions.forEach(opt => opt.classList.remove("selected"));
      this.classList.add("selected");
      this.querySelector("input").checked = true;
      if (profileInput) profileInput.value = ""; // clear file input if avatar picked
    });
  });

  // ✅ Clear avatar if file chosen
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

  // ✅ Smooth scroll on focus
  document.querySelectorAll("input, select").forEach(input => {
    input.addEventListener("focus", () => {
      setTimeout(() => input.scrollIntoView({ behavior: "smooth", block: "center" }), 300);
    });
  });

  // ✅ Validation
  document.getElementById("kidForm").addEventListener("submit", function(e) {
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

    // Name
    if (!name || !namePattern.test(name)) valid = false;
    // DOB
    if (!dob || selectedDate >= today) valid = false;
    // Email
    if (!email || !emailPattern.test(email)) valid = false;
    // Phone
    if (!phone || !phonePattern.test(phone)) valid = false;
    // Gender
    if (!gender) valid = false;
    // ✅ Avatar or Profile Image required
    if (!avatarSelected && !profileSelected) valid = false;
    // ✅ File validation (if selected)
    if (profileSelected) {
      const file = profileInput.files[0];
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
      if (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024) valid = false;
    }

    // ✅ Show single toast message
    if (!valid) {
      showToast('⚠️ Please correct the errors before submitting.', 'warning');
      return;
    }

    // ✅ Success
    showToast('✅ Kid added successfully!', 'success');
    setTimeout(() => this.submit(), 1200);
  });
});

/* ✅ Toast */
function showToast(message, type = "success") {
  let toast = document.getElementById("alertToast");
  if (!toast) {
    toast = document.createElement("div");
    toast.id = "alertToast";
    document.body.appendChild(toast);
  }
  toast.className = `alert-toast show alert-${type}`;
  toast.innerText = message;
  setTimeout(() => toast.classList.remove("show"), 2700);
}
