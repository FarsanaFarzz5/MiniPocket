<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Mini Pocket - Kid Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

  <style>
    /* ===== Base Reset ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    html, body {
      height: 100%;
      width: 100%;
      background: #f9f9f9;
      overflow-x: hidden;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* ===== Main Container ===== */
    .container {
      width: 100%;
      max-width: 420px;
      height: 100vh; /* fills viewport height */
      background: #fff;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    /* Allow vertical scrolling inside for long content */
    .inner-container {
      width: 100%;
      height: 100%;
      overflow-y: auto;
      padding: 24px 20px 60px;
      display: flex;
      flex-direction: column;
      align-items: center;
      scroll-behavior: smooth;
    }

    /* ===== Header ===== */
    .header {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #00c853;
    }

    .profile span {
      font-weight: 500;
      color: #222;
      font-size: 14px;
      text-transform: capitalize;
    }

    .logo img {
      height: 36px;
      object-fit: contain;
    }

    /* ===== Orange Card ===== */
    .orange-card {
      width: 100%;
      background: #ff7b00;
      border-radius: 28px;
      min-height: 190px;
      padding: 22px 24px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .orange-card::before {
      content: "";
      position: absolute;
      right: -60px;
      top: -70px;
      width: 240px;
      height: 180px;
      background: rgba(255, 255, 255, 0.18);
      border-radius: 50%;
    }

    .kid-image {
      position: absolute;
      left: 15px;
      bottom: 5px;
      width: 36%;
      max-width: 140px;
      height: auto;
      z-index: 2;
    }

    .content {
      color: #fff;
      z-index: 3;
      margin-left: auto;
      max-width: 50%;
      text-align: left;
      margin-right: 20px;
    }

    .content h3 {
      font-size: 0.95rem;
      font-weight: 400;
      margin-bottom: 4px;
    }

    .content h3 span {
      display: block;
      font-size: 1.55rem;
      font-weight: 800;
      color: #fff;
      
    }

    .balance-box {
      background: #fff;
      color: #169b45;
      border-radius: 14px;
      padding: 6px 16px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
      margin-top: 10px;
      display: inline-block;
      text-align: center;
      width: 200px;
    }

    .balance-box p {
      font-size: 0.7rem;
      color: #555;
    }

    .balance-box h2 {
      font-size: 30px;
      font-weight: 800;
      margin: 0;
    }

    /* ===== Green QR Section ===== */
    .qr-section {
      width: 100%;
      background: #23a541;
      border-radius: 24px;
      margin-top: 24px;
      padding: 12px 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .qr-left {
      flex: 0 0 28%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .qr-left img {
      width: 44px;
      height: 44px;
      object-fit: contain;
    }

    .qr-right {
      flex: 0 0 66%;
      background: #ffffff;
      border-radius: 16px;
      padding: 12px 16px;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: center;
      line-height: 1.2;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
    }

    .qr-right h4 {
      color: #23a541;
      font-size: 0.95rem;
      font-weight: 700;
      margin-bottom: 2px;
      text-align: center;
    }

    .qr-right p {
      color: #23a541;
      font-size: 0.75rem;
      font-weight: 500;
      margin: 0;
      text-align: center;
    }

    .qr-section:hover {
      transform: translateY(-2px);
      transition: all 0.3s ease;
    }

    /* ===== Footer Card ===== */
    .footer-card {
      width: 100%;
      background: #fff5dc;
      border-radius: 26px;
      margin-top: 28px;
      padding: 24px 22px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 12px;
      box-shadow: 0 8px 14px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: visible;
    }

    .footer-card img {
      width: 110px;
      height: auto;
      position: absolute;
      right: 40px;
      bottom: -10px;
      z-index: 5;
    }

    .footer-text {
      font-size: 1.05rem;
      color: #333;
      font-weight: 700;
      line-height: 1.5;
      margin-left: 0px;
      z-index: 3;
      max-width: 60%;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 768px) {
      body {
        align-items: flex-start;
        background: #fff;
      }

      .container {
        border-radius: 0;
        box-shadow: none;
        height: 100vh;
      }

      .inner-container {
        padding: 16px 14px 40px;
      }

      .orange-card {
        border-radius: 22px;
        min-height: 160px;
        padding: 18px 20px;
      }

      .kid-image {
        width: 34%;
        left: 10px;
      }

      .content h3 span {
        font-size: 1.8rem;
      }

      .qr-section {
        padding: 10px 12px;
        border-radius: 20px;
      }

      .qr-left img {
        width: 36px;
        height: 36px;
      }

      .qr-right {
        padding: 10px 14px;
      }

   .footer-card {
    padding: 22px 20px;
    border-radius: 24px;
  }

.footer-text {
    
    margin-left: 20px !important;
    font-size: 15px !important;
    /* font-family: Georgia, 'Times New Roman', Times, serif; */
    
  }

  .footer-card img {
    width: 100px;
    right: 30px;
    bottom: -8px;
  }
    }
    

    @media (max-width: 480px) {
      .profile span {
        font-size: 12px;
      }

      .qr-right h4 {
        font-size: 0.85rem;
      }

      .qr-right p {
        font-size: 0.68rem;
      }

      .orange-card {
        min-height: 140px;
      }

      .balance-box h2 {
        font-size: 30px;
      }

      .inner-container {
        padding: 14px 12px 36px;
      }


  .footer-text {
    
    margin-left: 20px;
    font-size: 15px;
    
    
  }


    }

    /* ===== Desktop Footer Correction (≥800px) ===== */
@media (min-width: 800px) {
  .footer-card {
    width: 100%;
    background: #fff5dc;
    border-radius: 26px;
    margin-top: 28px;
    padding: 22px 24px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    box-shadow: 0 8px 14px rgba(0, 0, 0, 0.08);
    position: relative;
  }

  .footer-text {
    font-size: 15px;              /* same as mobile */
    color: #333;
    font-weight: 700;
    line-height: 1.5;
    text-align: left;
    margin-left: 25px;
    max-width: 65%;
  }

  .footer-card img {
    width: 100px;
    height: auto;
    position: absolute;
    right: 30px;
    bottom: -8px;
    z-index: 5;
  }
}


    
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">
       @include('sidebar.profile')
      <!-- Header -->
      <div class="header">
        <div class="profile">
          <img id="kidProfileToggle" src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}" alt="Profile" />
          <span>{{ ucfirst($user->first_name) }}</span>
        </div>
        <div class="logo">
          <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo" />
        </div>
      </div>

      <!-- Orange Card -->
      <div class="orange-card">
        <img src="{{ asset('images/kid sitting.png') }}" class="kid-image" alt="Kid Illustration" />
        <div class="content">
          <h3>Hi,</h3>
          <h3><span>{{ ucfirst($user->first_name) }}</span></h3>
          <div class="balance-box">
            <p>Your Balance</p>
            <h2>₹{{ number_format($balance ?? 0, 0) }}</h2>
          </div>
        </div>
      </div>

      <!-- Green QR Section -->
      <div class="qr-section">
        <div class="qr-left">
          <img src="{{ asset('images/scan.png') }}" alt="Scan QR" />
        </div>
        <div class="qr-right">
          <h4>Scan QR Code</h4>
          <p>Send Money</p>
        </div>
      </div>

      <!-- Footer Card -->
      <div class="footer-card">
        <div class="footer-text">
          Little savings today,<br>big dreams tomorrow.
        </div>
        <img src="{{ asset('images/pig.png') }}" alt="Piggy Bank" />
      </div>
    </div>
  </div>
</body>
</html>
