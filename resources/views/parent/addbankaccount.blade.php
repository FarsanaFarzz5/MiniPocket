<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $bankName }} - Add Account | Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* ===========================================================
🌟 GLOBAL RESET
=========================================================== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

html, body {
  width: 100%;
  height: 100%;
  background: #ffffff;
  -webkit-overflow-scrolling: touch;
}

body {
  color: #222;
  min-height: 100vh;
}

.container {
  width: 100%;
  max-width: 420px;
  height: 100vh; /* ✅ full visible height */
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);

  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed; /* ✅ keeps container fixed on screen */
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  overflow: hidden; /* ✅ prevents page scroll */
  z-index: 1;
}

/* ===========================================================
🧭 INNER CONTAINER (Scrolls independently)
=========================================================== */
.inner-container {
  width: 100%;
  flex: 1;
  text-align: center;
  overflow-y: auto; /* ✅ scroll only here */
  -webkit-overflow-scrolling: touch;
  padding: 0 22px 100px;
}

@supports (padding: max(0px)) {
  .inner-container {
    padding-bottom: max(100px, env(safe-area-inset-bottom));
  }
}

/* ===========================================================
🧭 PAGE HEADING
=========================================================== */
.page-header {
  text-align: center;
  margin-top: 25px;
  margin-bottom: 24px;
  animation: fadeIn 0.4s ease;
}

.page-header h1 {
  font-size: 18px;
  font-weight: 600;
  color: #2c3e50;
  letter-spacing: 0.3px;
  text-transform: capitalize;
}

/* ===========================================================
💳 CARD PREVIEW
=========================================================== */
.card-preview {
  width: 100%;
  height: 215px;
  border-radius: 18px;
  padding: 24px 26px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background: linear-gradient(145deg, {{ $cardColor }}20, #ffffff);
  border-top: 4px solid {{ $cardColor }};
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
  margin-bottom: 25px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.card-preview:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header img {
  width: 46px;
  height: 46px;
  object-fit: contain;
}

.card-header span {
  font-size: 15px;
  font-weight: 600;
  color: #111;
}

.card-number {
  font-size: 20px;
  letter-spacing: 2px;
  font-weight: 600;
  color: #000;
  text-align: left;
  
}

.card-footer {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  font-weight: 500;
  color: #333;
}

/* ===========================================================
🧾 FORM
=========================================================== */
form {
  display: flex;
  flex-direction: column;
  gap: 18px;
  text-align: left;
}

label {
  font-size: 13.8px;
  color: #555;
  font-weight: 500;
  margin-bottom: 6px;
  display: block;
  margin-left: 4px;
}

input {
  width: 100%;
  padding: 12px 14px;
  border-radius: 10px;
  border: 1.5px solid #e4e4e4;
  background: #fff;
  font-size: 15px;
  color: #222;
  transition: border-color 0.25s, box-shadow 0.25s;
}

input:focus {
  border-color: #f4731d;
  box-shadow: 0 0 0 3px rgba(244, 115, 29, 0.1);
  outline: none;
}

.inline-inputs {
  display: flex;
  gap: 10px;
}

.inline-inputs input {
  flex: 1;
}

/* ===========================================================
🔘 BUTTONS (Orange theme)
=========================================================== */
.button-group {
  display: flex;
  justify-content: flex-start;
  gap: 10px;
  margin-top: 6px;
  flex-wrap: wrap;
}

.btn {
  border: none;
  border-radius: 10px;
  padding: 12px 22px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s ease;
}

.btn:active {
  transform: translateY(1px);
}

.btn-save {
  background: linear-gradient(135deg, {{ $cardColor }}08, {{ $cardColor }}12); /* ✅ ultra-light tint */
  color:{{ $cardColor }};
  border: 1.5px solid {{ $cardColor }}40;
  
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-save:hover {
  background: linear-gradient(135deg, {{ $cardColor }}20, {{ $cardColor }}33);
  transform: translateY(-2px);
}

.btn-cancel {
  background: #fff;
  color: {{ $cardColor }};
  border: 1.5px solid {{ $cardColor }}40;
}

.btn-cancel:hover {
  background: {{ $cardColor }}10;
}


/* ===========================================================
✅ TOAST / ALERT
=========================================================== */
.alert {
  display: none;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #00c853, #2ecc71);
  color: #fff;
  padding: 10px 22px;
  border-radius: 10px;
  text-align: center;
  font-size: 14.5px;
  font-weight: 600;
  letter-spacing: 0.3px;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.25);
  z-index: 9999;
  animation: slideDown 0.4s ease forwards;
  max-width: 340px;
  width: 90%;
}

@keyframes slideDown {
  from { transform: translate(-50%, -20px); opacity: 0; }
  to { transform: translate(-50%, 0); opacity: 1; }
}

/* ===========================================================
📱 RESPONSIVE
=========================================================== */
@media (max-width: 480px) {

    html, body {
    overflow: hidden;
    height: 100%;
  }
   .container { 
    max-width: 100%; 
    left: 0; 
    transform: none; 
    height: 100%; 
    overflow: hidden; 
  }

  .inner-container { 
    padding: 0 22px 60px; 
    overflow: hidden; 
    height: 100%; 
  }
  .page-header h1 { font-size: 16px;  }
  .btn { font-size: 14px; padding: 11px 20px; }
  input { font-size: 14px; height: 48px; }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')
      @include('headerparent')

      <!-- ✅ Alert -->
      <div id="alertBox" class="alert">✅ Bank card added successfully!</div>

      <!-- ==== HEADER ==== -->
      <div class="page-header">
        <h1>Add Your Bank Card</h1>
      </div>

      <!-- ==== CARD PREVIEW ==== -->
      <div class="card-preview">
        <div class="card-header">
          <img src="{{ asset('images/' . $bankFile) }}" alt="{{ $bankName }} Logo">
          <span>{{ $bankName }}</span>
        </div>
        <div class="card-number" id="cardNumberDisplay">1234 5678 9012 3456</div>
        <div class="card-footer">
          <span id="cardHolderDisplay">
            {{ strtoupper(trim(Auth::user()->first_name . ' ' . (Auth::user()->second_name ?? ''))) }}
          </span>
          <span id="expiryDisplay">12/24</span>
        </div>
      </div>

      <!-- ==== FORM ==== -->
      <form id="bankForm" action="{{ route('parent.add.bank') }}" method="POST">
        @csrf
        <input type="hidden" name="bank_name" value="{{ $bankName }}">
        <input type="hidden" name="branch_name" value="{{ Auth::user()->first_name . ' ' . Auth::user()->second_name }}">

        <div>
          <label for="card_number">Card Number</label>
          <input type="tel" id="card_number" name="card_number" maxlength="19" inputmode="numeric" pattern="[0-9\s]*" placeholder="1234 5678 9012 3456" required>
        </div>

        <div class="inline-inputs">
          <input type="tel" id="expiry" name="expiry_date" placeholder="MM/YY" maxlength="5" inputmode="numeric" pattern="[0-9/]*" required>
          <input type="password" id="cvv" name="cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" required>
        </div>

        <div class="button-group">
          <button type="submit" class="btn btn-save">Save</button>
          <button type="button" class="btn btn-cancel" onclick="window.history.back()">Cancel</button>
        </div>
      </form>

    </div>
  </div>

  <script src="{{ asset('assets/js/addbankaccount.js') }}"></script>
</body>
</html>
