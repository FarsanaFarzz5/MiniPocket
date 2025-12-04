<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Kid - Mini Pocket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Sidebar + Header -->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">

<style>
/* ===========================================================
🧱 MAIN CONTAINER (Fixed frame — Non-scrollable)
=========================================================== */
html, body {
  width: 100%;
  height: 100%;
  background: #ffffff;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  overflow-x: hidden;
  -webkit-overflow-scrolling: touch;
}

body {
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: -webkit-fill-available;
  -webkit-overflow-scrolling: touch;
}


.container {
  width: 100%;
  max-width: 420px;
  height: 100vh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  padding: 0px 22px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  overflow: hidden;
  z-index: 1;
}

/* ===========================================================
🧭 INNER CONTAINER (Scrolls independently)
=========================================================== */
.inner-container {
  width: 100%;
  flex: 1;
  text-align: center;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  padding: 0 0 100px;  /* ✅ Same bottom spacing */
}

/* iPhone safe-area fix */
@supports (padding: max(0px)) {
  .inner-container {
    padding-bottom: max(100px, env(safe-area-inset-bottom));
  }
}

/* ===========================================================
🎨 PAGE HEADING
=========================================================== */
h1 {
  width: 100%;
  text-align: center;
  font-size: 17px;
  font-weight: 600;
  color: #2c3e50;
  text-transform: capitalize;
  letter-spacing: 0.2px;
  margin-bottom: 25px;
  margin-top: 45px;   /* ✅ SAME AS EDIT PROFILE */
}
/* ===========================================================
📑 FORM STRUCTURE
=========================================================== */
.kid-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 18px;
  text-align: left;
  margin-bottom: 50px;
}

/* ===========================================================
🌟 FLOATING INPUTS
=========================================================== */
.floating-group {
  position: relative;
  width: 100%;
}

.floating-group input,
.floating-group select {
  width: 100%;
  height: 54px;
  padding: 14px;
  border: 1.6px solid #e4e4e4;
  border-radius: 10px;
  font-size: 15px;
  color: #222;
  background: #fff;
  transition: all 0.25s ease;
}

.floating-group input:focus,
.floating-group select:focus {
  border-color: #f4731d;
  box-shadow: 0 0 0 3px rgba(244, 115, 29, 0.1);
  outline: none;
}

/* Floating Label */
.floating-group label {
  position: absolute;
  left: 14px;
  top: 20px;
  font-size: 15px;
  color: #999;
  background: #fff;
  padding: 0 4px;
  transition: all 0.2s ease;
  pointer-events: none;
}

.floating-group input:focus + label,
.floating-group input:not(:placeholder-shown) + label,
.floating-group select:focus + label,
.floating-group select:not([value=""]) + label {
  top: -8px;
  left: 12px;
  font-size: 12px;
  color: #f4731d;
}

/* ===========================================================
📅 DATE INPUT FIXES
=========================================================== */
.floating-group input[type="date"] {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  color: transparent;
  text-align: left;
  text-align-last: left;
}

.floating-group input[type="date"]:focus,
.floating-group input[type="date"]:valid {
  color: #222;
}

.floating-group input[type="date"]::before {
  content: attr(placeholder);
  color: #999;
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
}

.floating-group input[type="date"]:focus::before,
.floating-group input[type="date"]:valid::before {
  content: "";
}

.floating-group input[type="date"]::-webkit-calendar-picker-indicator {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  width: 22px;
  height: 22px;
  background: transparent;
  cursor: pointer;
  opacity: 0.6;
}

/* ===========================================================
🔽 SELECT DROPDOWN ARROW
=========================================================== */
.floating-group select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg fill='%23999' height='22' viewBox='0 0 24 24' width='22' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 20px;
}




/* ===========================================================
📱 MOBILE RESPONSIVE FIXES
=========================================================== */
@media (max-width: 480px) {
  html, body {
    position: fixed;
    top: 0; bottom: 0; left: 0; right: 0;
    overflow: hidden !important;
    touch-action: none;
  }

  .container {
    height: 100dvh;
    overflow: hidden;
  }

  .inner-container {
    overflow-y: auto !important;
    padding-top: 0px; /* avoid double spacing */
  }

  h1 {
    font-size: 15px;
    margin-top: 45px;    /* ✅ SAME TOP SPACING ON MOBILE */
    margin-bottom: 20px;
  }
  
}

/* ===========================================================
🟧 BUTTON ROW (Update + Delete)
=========================================================== */
.button-row {
    display: flex;
    width: 100%;
    gap: 12px;
    margin-top: 10px;
}

.button-row button {
    flex: 1;
    height: 54px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

/* Update Kid */
.btn-update {
    background: linear-gradient(135deg, #f4731d, #ff9240);
    color: white;
}

/* Delete Kid */
.btn-delete {
    background: #ff4d4d;
    color: white;
}

/* Perfect compact alert card */
.swal-popup {
    width: 370px !important;        /* ↓ reduce width */
    max-width: 85% !important;  
    border-radius: 18px !important;
    padding: 22px 20px !important;  /* balanced padding */
    box-sizing: border-box !important;
}

.swal-title {
    font-size: 20px !important;
    font-weight: 600 !important;
    font-family: 'Poppins', sans-serif;
}

.swal-text {
    font-size: 14px !important;
    font-family: 'Poppins', sans-serif;
}

.swal-confirm {
    border-radius: 10px !important;
    padding: 10px 22px !important;
    font-family: 'Poppins', sans-serif;
    font-size: 14px !important;
}

.swal-cancel {
    border-radius: 10px !important;
    padding: 10px 22px !important;
    font-family: 'Poppins', sans-serif;
    font-size: 14px !important;
}
/* Small custom warning icon */
.swal-custom-icon {
    width: 42px;
    height: 42px;
    border: 2px solid #f6a341;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 10px auto;
    font-size: 22px;
    color: #f6a341;
    font-family: 'Poppins', sans-serif;
}

/* Title styling */
.swal-custom-title {
    font-size: 17px;
    font-weight: 600;
    margin: 0;
    margin-bottom: 6px;
    font-family: 'Poppins', sans-serif;
}

/* Text styling */
.swal-custom-text {
    font-size: 13px;
    margin: 0;
    margin-bottom: 12px;
    line-height: 1.35;
    font-family: 'Poppins', sans-serif;
}

/* SweetAlert buttons EXACT same style as Limit Popup buttons */
.swal2-actions {
    display: flex !important;
    gap: 12px !important;
    width: 100% !important;
    justify-content: center !important;
    margin-top: 20px !important;
}

/* YES DELETE = ORANGE BUTTON */
.swal-confirm {
    flex: 1 !important;
    background: #ff8a00 !important;
    color: #fff !important;
    padding: 12px 0 !important;
    border-radius: 12px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    border: none !important;
    height: 46px !important; /* EXACT SAME HEIGHT */
    box-shadow: 0 4px 14px rgba(255,138,0,0.25) !important;
}

/* CANCEL = GREY BUTTON */
.swal-cancel {
    flex: 1 !important;
    background: #ffffff !important;
    color: #555 !important;
    padding: 12px 0 !important;
    border-radius: 12px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    height: 46px !important;
    border: 2px solid #ffc680 !important;  /* 🔥 light orange border */
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    box-shadow: none !important;
}


/* Remove built-in SweetAlert margins */
.swal2-styled {
    margin: 0 !important;
}

/* Email Error Toast */
.alert-toast {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%) translateY(120%);
  padding: 14px 20px;
  width: 90%;
  max-width: 360px;
  background: linear-gradient(135deg, #ff4d4d, #ff6f6f);
  color: white;
  font-size: 14px;
  font-weight: 500;
  border-radius: 12px;
  text-align: center;
  opacity: 0;
  transition: all 0.4s ease;
  z-index: 9999;
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.alert-toast.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}


</style>

</head>

<body>

<div class="container">

    @include('headerparent')
    @include('sidebar.sidebar')

    <div class="inner-container">

        <h1>Edit Kid</h1>

        <form method="POST" action="{{ route('kids.update', $kid->id) }}" class="kid-form">
            @csrf

            <!-- Kid Name -->
            <div class="floating-group">
                <input type="text" name="first_name" value="{{ $kid->first_name }}" placeholder=" " required>
                <label>Kid Name</label>
            </div>

            <!-- Email -->
            <div class="floating-group">
                <input type="email" name="email" value="{{ $kid->email }}" placeholder=" " required>
                <label>Email Address</label>
            </div>

            <!-- Date of Birth -->
            <div class="floating-group">
                <input type="date" name="dob" value="{{ $kid->dob }}" placeholder=" " required>
                <label>Date of Birth</label>
            </div>

            <!-- Gender -->
            <div class="floating-group">
                <select name="gender" value="{{ $kid->gender }}" required>
                    <option value="male" {{ $kid->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $kid->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $kid->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                <label>Gender</label>
            </div>

            <!-- Button Row -->
<div class="button-row">
    <button type="submit" class="btn-update">Update Kid</button>
    <button type="button" id="deleteKidBtn" class="btn-delete">Delete Kid</button>
</div>




        </form>

    </div>
</div>

<div id="alertToast" class="alert-toast"></div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>


document.getElementById('deleteKidBtn').addEventListener('click', function () {

    Swal.fire({
        html: `
            <div class="swal-custom-icon">
                <span>!</span>
            </div>
            <h2 class="swal-custom-title">Delete Kid?</h2>
            <p class="swal-custom-text">
                Are you sure you want to delete this kid?
                This action cannot be undone.
            </p>
        `,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'swal-popup',
            confirmButton: 'swal-confirm',
            cancelButton: 'swal-cancel'
        }
    }).then((result) => {

        if (result.isConfirmed) {
            axios.delete("{{ route('parent.kid.delete', $kid->id) }}")
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        text: response.data.message,
                        confirmButtonColor: '#f4731d'
                    }).then(() => {
                        window.location.href = "{{ route('parent.kid.management') }}";
                    });

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        text: 'Failed to delete kid. Please try again.',
                        confirmButtonColor: '#ff4d4d'
                    });
                });
        }
    });

});

document.addEventListener("DOMContentLoaded", function() {
    @if ($errors->has('email'))
        let toast = document.getElementById("alertToast");
        toast.innerHTML = "❌ {{ $errors->first('email') }}";
        toast.classList.add("show");
        setTimeout(() => {
            toast.classList.remove("show");
        }, 2500);
    @endif
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
