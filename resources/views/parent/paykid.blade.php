<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pay {{ ucfirst($kid->first_name) }} - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/paykid.css') }}">
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

<script src="{{ asset('assets/js/paykid.js') }}"></script>

</body>
</html>
