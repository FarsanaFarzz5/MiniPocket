<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $bankName }} - Add Account | Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    * {margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif;}

html, body {
  width: 100%;
  height: 100%;
  background: #eef3fb;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

/* ✅ Fix viewport height correctly across mobile browsers */
body {
  display: flex;
  justify-content: center;
  align-items: stretch;
  min-height: 100vh;
  min-height: 100dvh; /* fallback for modern browsers */
  -webkit-overflow-scrolling: touch;
}

/* ✅ Perfect mobile-fit container */
.container {
  width: 100%;
  max-width: 420px;
  min-height: 100vh;
  min-height: 100dvh;
  background: #fff;
  box-shadow: 0 6px 25px rgba(0,0,0,0.08);
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  overflow-y: auto;
  overflow-x: hidden;
  padding-bottom: env(safe-area-inset-bottom);
  border-radius: 0;
  position: relative;
  animation: fadeIn 0.4s ease;
}


    .inner-content {
      width: 100%;
      padding: 34px 26px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 26px;
    }

    /* ==== HEADING ==== */
    .page-header {
      text-align: center;
      animation: fadeIn 0.6s ease;
    }

    .page-header h1 {
      font-family: 'Nunito', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: #1e1e1e;
      margin-bottom: 6px;
    }

    .page-header p {
      font-size: 13px;
      color: #777;
    }

    /* ==== CARD PREVIEW ==== */
    .card-preview {
      width: 100%;
      height: 200px;
      border-radius: 16px;
      padding: 24px 26px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: linear-gradient(145deg, {{ $cardColor }}15, #ffffff);
      border-top: 4px solid {{ $cardColor }};
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      transition: 0.3s ease;
    }

    .card-preview:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.10);
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
      font-weight: 500;
      color: #111;
    }

    .card-number {
      font-size: 20px;
      letter-spacing: 2px;
      font-weight: 600;
      color: #000;
      margin-top: 10px;
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      font-weight: 500;
      color: #333;
    }

    /* ==== FORM ==== */
    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    label {
      font-size: 13.5px;
      color: #555;
      font-weight: 500;
    }

    input {
      width: 100%;
      padding: 11px 14px;
      border-radius: 8px;
      border: 1px solid #dcdcdc;
      background: #fafafa;
      font-size: 16px; /* ✅ Prevent zoom */
      color: #222;
      transition: all 0.25s ease;
    }

    input:focus {
      border-color: #1976d2;
      box-shadow: 0 0 0 3px rgba(25,118,210,0.1);
      background: #fff;
      outline: none;
    }

    .inline-inputs {
      display: flex;
      gap: 10px;
    }
    .inline-inputs input { flex: 1; }

    /* ==== BUTTONS ==== */
    .button-group {
      display: flex;
      justify-content: flex-start;
      gap: 10px;
      margin-top: 10px;
    }

    .btn {
      border: none;
      border-radius: 6px;
      padding: 10px 22px;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: 0.25s ease;
    }

    .btn-save {
      background: #1976d2;
      color: #fff;
    }

    .btn-save:hover { background: #1259a7; }

    .btn-cancel {
      background: #fff;
      color: #1976d2;
      border: 1.5px solid #1976d2;
    }

    .btn-cancel:hover { background: #e3f2fd; }

 /* ========================= SUCCESS ALERT ========================= */
.alert {
  display: none;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #4caf50, #2e7d32);
  color: #fff;
  padding: 8px 20px;
  border-radius: 10px;
  text-align: center;
  font-size: 14.5px;
  font-weight: 600;
  letter-spacing: 0.3px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  z-index: 9999;
  animation: slideDown 0.4s ease forwards;
  max-width: 340px;
  width: 90%;
}

/* ✅ Success icon animation */
.alert::before {
  margin-right: 8px;
  font-size: 16px;
}

/* ✅ Fade-in + slide-down animation */
@keyframes slideDown {
  from {
    transform: translate(-50%, -20px);
    opacity: 0;
  }
  to {
    transform: translate(-50%, 0);
    opacity: 1;
  }
}

/* ✅ Fade-out animation */
@keyframes slideUp {
  from {
    opacity: 1;
    transform: translate(-50%, 0);
  }
  to {
    opacity: 0;
    transform: translate(-50%, -20px);
  }
}

  </style>
</head>

<body>
  <div class="container">
    <div class="inner-content">

      <!-- ✅ Alert -->
      <div id="alertBox" class="alert">✅ Bank card added successfully!</div>

      <!-- ==== HEADER ==== -->
      <div class="page-header">
        <h1>Add Your Bank Card</h1>
        <p>Provide your card details to link your account securely</p>
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
          <input type="password" id="cvv" name="cvv" placeholder="cvv" maxlength="3" inputmode="numeric" pattern="[0-9]*" required>

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
