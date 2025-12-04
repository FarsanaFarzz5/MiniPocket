document.addEventListener("DOMContentLoaded", () => {

  const avatarOptions = document.querySelectorAll(".avatar-option");
  const profileInput = document.getElementById("profile_img");

  /* ============================================================
      ✅ AVATAR SELECTION
  ============================================================ */
  avatarOptions.forEach(option => {
    option.addEventListener("click", function () {
      avatarOptions.forEach(opt => opt.classList.remove("selected"));
      this.classList.add("selected");
      this.querySelector("input").checked = true;

      if (profileInput) profileInput.value = "";
    });
  });

  /* ============================================================
      ✅ CLEAR AVATAR IF CUSTOM IMAGE CHOSEN
  ============================================================ */
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

  /* ============================================================
      ✅ AUTO SCROLL FOR MOBILE
  ============================================================ */
  document.querySelectorAll("input, select").forEach(input => {
    input.addEventListener("focus", () => {
      setTimeout(() =>
        input.scrollIntoView({ behavior: "smooth", block: "center" }), 300);
    });
  });

  /* ============================================================
      ✅ MAIN FORM VALIDATION
  ============================================================ */
  document.getElementById("kidForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("first_name").value.trim();
    const dob = document.getElementById("dob").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone_no").value.trim();
    const gender = document.getElementById("gender").value;
    const avatarSelected = document.querySelector('input[name="avatar_choice"]:checked');
    const profileSelected = profileInput && profileInput.files.length > 0;

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,4}$/;
    const phonePattern = /^[0-9]{10}$/;

    const minDOB = new Date("2020-01-01");
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const selectedDate = new Date(dob);

    /* -------------------- NAME -------------------- */
/* -------------------- NAME -------------------- */
if (!name.trim())
  return showToast("warning", "Please enter child's name.");

const namePattern = /^[A-Za-z ]+$/;

if (!namePattern.test(name))
  return showToast("warning", "Name should contain only alphabets and spaces.");


    /* -------------------- DATE OF BIRTH -------------------- */
   /* -------------------- DATE OF BIRTH -------------------- */
if (!dob)
  return showToast("warning", "Please select date of birth.");

const cutoff = new Date("2020-01-01");

if (selectedDate >= cutoff)
  return showToast("warning", "Date of birth must be before the year 2020.");

if (selectedDate >= today)
  return showToast("warning", "DOB cannot be today or a future date.");


    /* -------------------- EMAIL -------------------- */
    if (!email)
      return showToast("warning", "Please enter email address.");
    if (!emailPattern.test(email))
      return showToast("warning", "Invalid email format.");

    /* -------------------- UNIQUE EMAIL CHECK (FRONTEND ONLY) -------------------- */
    if (window.existingAllEmails.includes(email)) {
      return showToast("warning", "This email is already registered.");
    }

    /* -------------------- PHONE -------------------- */
    if (!phone)
      return showToast("warning", "Please enter mobile number.");
    if (!phonePattern.test(phone))
      return showToast("warning", "Mobile number must be exactly 10 digits.");

    /* -------------------- GENDER -------------------- */
    if (!gender)
      return showToast("warning", "Please select gender.");

    /* -------------------- AVATAR / IMAGE -------------------- */
    if (!avatarSelected && !profileSelected)
      return showToast("warning", "Please select an avatar or upload an image.");

    /* -------------------- IMAGE FORMAT -------------------- */
    if (profileSelected) {
      const file = profileInput.files[0];
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

      if (!allowedTypes.includes(file.type))
        return showToast("warning", "Only JPG, PNG, GIF images are allowed.");

      if (file.size > 2 * 1024 * 1024)
        return showToast("warning", "Image size must be less than 2 MB.");
    }

    setTimeout(() => this.submit(), 1200);
  });
});

/* ============================================================
      ✅ TOAST FUNCTION
============================================================ */
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
