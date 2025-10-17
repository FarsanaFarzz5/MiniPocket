<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pay {{ ucfirst($kid->first_name) }} - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@700;800&display=swap" rel="stylesheet">

  <style>
  /* ========================= GLOBAL RESET ========================= */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  html, body {
    width: 100%;
    height: 100%;
    background: #f2f2f2;
    overflow: hidden; /* remove scrollbars */
  }

  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100dvh; /* ✅ ensures full screen height */
  }

  /* ========================= CONTAINER ========================= */
  .container {
    width: 100%;
    max-width: 420px;
    height: 100dvh; /* ✅ full viewport height */
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 28px 26px 45px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start; /* keep layout same */
  }

  .inner-container {
    width: 100%;
    text-align: center;
  }

  /* ========================= HEADER ========================= */
  .header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .back-arrow {
    display: flex;
    align-items: center;
    color: #2c3e50;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .back-arrow svg {
    width: 20px;
    height: 20px;
    fill: #00c853;
    margin-right: 6px;
    transition: transform 0.2s ease;
  }

  .back-arrow:hover svg {
    transform: translateX(-3px);
  }

  /* ========================= LOGO ========================= */
  .logo-section {
    display: flex;
    justify-content: center;
    margin: 10px 0 16px;
  }

  .logo-section img {
    width: 75px;
    transition: transform 0.3s ease;
    filter: brightness(1.1) saturate(1.1);
  }

  .logo-section img:hover {
    transform: scale(1.05);
  }

  /* ========================= PAGE TITLE ========================= */
  h1 {
    font-size: 17px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 18px;
  }

  /* ========================= KID INFO BOX ========================= */
  .kid-info-box {
    background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    margin-bottom: 20px;
    transition: all 0.3s ease;
  }

  .kid-info-box img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #00c853;
    box-shadow: 0 0 6px rgba(0,200,83,0.25);
    object-fit: cover;
  }

  .kid-details {
    text-align: left;
  }

  .kid-details span:first-child {
    display: block;
    font-size: 14.5px;
    font-weight: 600;
    color: #2c3e50;
  }

  .kid-details span:last-child {
    font-size: 12.5px;
    color: #8c8c8c;
  }

  /* ========================= AMOUNT ========================= */
  .amount-wrapper {
    margin: 32px 0 20px;
  }

  .amount-field {
    font-family: 'Nunito', sans-serif;
    font-size: 44px !important;
    font-weight: 800;
    color: #00c853;
    display: flex;
    justify-content: center;
    align-items: baseline;
    gap: 4px;
    transform: translateX(25px);
  }

  .amount-field input {
    background: none;
    border: none;
    outline: none;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    color: inherit;
    width: 80px;
    text-align: left;
    transition: width 0.3s ease;
    appearance: textfield;
  }

  .amount-field input::-webkit-inner-spin-button,
  .amount-field input::-webkit-outer-spin-button {
    -webkit-appearance: none;
  }

  .limit-note {
    text-align: center;
    color: #d32f2f;
    font-size: 13px;
    margin-top: 6px;
    display: none;
  }

  /* ========================= BUTTON ========================= */
  form {
    margin-top: 24px;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 0;
    background: linear-gradient(135deg, #f4731d 0%, #f68c40 100%);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(244,115,29,0.35);
    transition: all 0.3s ease;
  }

  .btn:hover {
    background: linear-gradient(135deg, #e25f00 0%, #f4731d 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(244,115,29,0.4);
  }

  .btn:active {
    transform: scale(0.98);
  }

  .icon {
    width: 20px;
    height: 20px;
    fill: #fff;
  }

  /* ========================= RESPONSIVE ========================= */
  @media (max-width: 430px) {
    .container { padding: 18px; }
    h1 { font-size: 15.5px; }
    .amount-field { font-size: 36px; }
    .btn { font-size: 14px; padding: 12px 0; }
    .logo-section img { width: 65px; }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">
      <!-- Back -->
      <div class="header">
        <a href="{{ route('parent.sendmoney.page') }}" class="back-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg> Back
        </a>
      </div>

      <!-- Logo -->
      <div class="logo-section" style="transform: translateX(-6px);">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Title -->
      <h1 style="transform: translateX(-4px);">Pay {{ ucfirst($kid->first_name) }}</h1>

      <!-- Kid Info -->
      @php
        use Illuminate\Support\Str;
        $img = asset('images/default-profile.png');
        if (!empty($kid->profile_img)) {
          if (Str::startsWith($kid->profile_img, 'profile_images/')) $img = asset('storage/'.$kid->profile_img);
          elseif (Str::startsWith($kid->profile_img, 'storage/')) $img = asset($kid->profile_img);
          elseif (Str::startsWith($kid->profile_img, ['http', 'https'])) $img = $kid->profile_img;
          else $img = asset($kid->profile_img);
        }
      @endphp

      <div class="kid-info-box">
        <img src="{{ $img }}" alt="{{ $kid->first_name }}">
        <div class="kid-details">
          <span>{{ ucfirst($kid->first_name) }}</span>
          <span>{{ ucfirst($kid->gender) }}</span>
        </div>
      </div>

      <!-- Amount -->
      <div class="amount-wrapper">
        <div class="amount-field">
          ₹
          <input type="number" id="amountInput" name="amount" value="0" min="0" max="100000"
                 onfocus="if(this.value=='0') this.value='';"
                 onblur="if(this.value=='') this.value='0';">
        </div>
      </div>

      <p id="limitNote" class="limit-note">⚠️ Maximum limit is ₹1,00,000</p>

      <!-- Button -->
      <form method="POST" action="{{ route('parent.send.money') }}" onsubmit="return setAmountBeforeSubmit()">
        @csrf
        <input type="hidden" name="kid_id" value="{{ $kid->id }}">
        <input type="hidden" name="amount" id="hiddenAmount" value="0">
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

  <!-- Add this just before </body> -->
<div id="successMsg" style="
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  background: #00c853;
  color: #fff;
  padding: 12px 22px;
  border-radius: 30px;
  font-weight: 500;
  font-size: 14px;
  opacity: 0;
  transition: opacity 0.6s ease;
  z-index: 999;
">Amount Paid Successfully ✅</div>

  <script>
    const amountInput = document.getElementById("amountInput");
    const hiddenAmount = document.getElementById("hiddenAmount");
    const limitNote = document.getElementById("limitNote");

  const successMsg = document.getElementById("successMsg");
  const form = document.querySelector("form");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    successMsg.style.opacity = "1";
    setTimeout(() => {
      successMsg.style.opacity = "0";
      form.submit(); // continue actual submission after showing message
    }, 1500);
  });
  
    function setAmountBeforeSubmit() {
      const amount = parseInt(amountInput.value) || 0;
      if (amount > 100000) {
        limitNote.style.display = "block";
        return false;
      }
      hiddenAmount.value = amount;
      return true;
    }

    amountInput.addEventListener("input", () => {
      amountInput.style.width = (amountInput.value.length * 22 + 50) + "px";
      if (parseInt(amountInput.value) > 100000) {
        amountInput.value = 100000;
        limitNote.style.display = "block";
      } else {
        limitNote.style.display = "none";
      }
    });

    
  </script>
</body>
</html>
