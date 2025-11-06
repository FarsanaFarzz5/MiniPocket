<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pay Now - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@700;800&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/moneytransfer.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- Back Button -->
      <div class="header">
        <a href="{{ url()->previous() }}" class="back-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg>
          Back
        </a>
      </div>

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Title -->
      <h1>Send Money</h1>

      <!-- Amount Field -->
      <div class="amount-wrapper">
        <div class="amount-field">
          ₹
          <input type="text" id="amountInput" name="amount" value="0"
            inputmode="decimal" pattern="[0-9]*"
            onfocus="if(this.value=='0')this.value='';"
            onblur="if(this.value=='')this.value='0';"
            oninput="validateAmountInput(this)" maxlength="6">
        </div>
      </div>

      <!-- Optional Reason -->
      <form method="POST" action="{{ route('kid.send.money') }}">
        @csrf
        <input type="hidden" name="amount" id="hiddenAmount" value="0">
        <input type="text" name="description" placeholder="Reason (optional)" class="reason-box">

        <!-- Proceed Button -->
        <button type="submit" class="btn">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24">
            <path fill="#fff" d="M12 1L3 5v6c0 5.25 3.438 10.063 9 12 5.563-1.938 9-6.75 9-12V5l-9-4zM12 21c-4.625-1.688-7.5-5.75-7.5-10V6.3L12 3.35 19.5 6.3V11c0 4.25-2.875 8.313-7.5 10z"/>
            <path fill="#fff" d="M10.5 13.5l-2-2L7.1 12.9 10.5 16.3 16.9 9.9 15.5 8.5z"/>
          </svg>
          Proceed Securely
        </button>
      </form>
    </div>
  </div>

  <!-- ✅ Toast -->
  <div id="alertToast" class="alert-toast"></div>

  <script src="{{ asset('assets/js/moneytransfer.js') }}"></script>
</body>
</html>
