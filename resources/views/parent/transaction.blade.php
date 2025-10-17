<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parent Transactions - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Layout & Sidebar -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

  body {
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100dvh;
    overflow: hidden;
  }

  .container {
    width: 100%;
    max-width: 420px;
    height: 100dvh;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    padding: 20px 24px 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow-y: auto;
  }

  .inner-container {
    width: 100%;
    text-align: center;
  }

  /* Logo */
  .logo-section {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 8px;
    margin-bottom: 10px;
  }
  .logo-section img {
    width: 70px;
    height: auto;
    display: block;
    filter: brightness(1.1) saturate(1.1);
    transition: transform 0.3s ease;
  }
  .logo-section img:hover { transform: scale(1.05); }

  /* Title */
  h1 {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 18px;
  }

  /* Transactions */
  .transaction-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    text-align: left;
  }

  .transaction-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafafa;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 12px 14px;
    transition: all 0.3s ease;
  }
  .transaction-card:hover {
    background: #f5fff6;
    border-color: #b8e6b8;
    transform: translateY(-2px);
  }

  .left {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .left img {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4caf50;
  }
  .details h4 {
    font-size: 14px;
    color: #333;
    font-weight: 600;
  }
  .details p {
    font-size: 12px;
    color: #777;
    line-height: 1.4;
  }

  .right { text-align: right; }
  .right h4 {
    color: #23a541;
    font-size: 15px;
    font-weight: 600;
  }
  .right span {
    font-size: 12px;
    color: #888;
    display: block;
  }
  .type {
    font-size: 11.5px;
    color: #ff7b00;
    font-weight: 600;
    margin-top: 2px;
  }

  .no-data {
    text-align: center;
    color: #999;
    margin-top: 30px;
    font-size: 14px;
  }

  @media (max-width: 480px) {
    body { align-items: flex-start; }
    .container { max-width: 100%; height: 100dvh; border-radius: 0; box-shadow: none; }
    h1 { font-size: 15px; }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- ✅ Sidebar -->
      @include('sidebar.sidebar')

      <!-- ✅ Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <!-- ✅ Title -->
      <h1>Transaction History</h1>

      <!-- ✅ Transactions -->
      @if($transactions->isEmpty())
        <p class="no-data">No transactions found yet.</p>
      @else
        <div class="transaction-list">
          @foreach($transactions as $txn)
            <div class="transaction-card">
              <div class="left">
                <img src="{{ $txn->kid && $txn->kid->profile_img ? asset('storage/'.$txn->kid->profile_img) : asset('images/default-avatar.png') }}" alt="Kid Avatar">
                <div class="details">
                  <h4>{{ ucfirst($txn->kid->first_name ?? 'Unknown Kid') }}</h4>
                  <p>{{ $txn->description ?? 'Sent money to kid' }}</p>
                </div>
              </div>
              <div class="right">
                <h4>₹{{ number_format($txn->amount, 2) }}</h4>
                <span>{{ $txn->created_at->format('d M Y') }}</span>
                <span class="type">Debit</span>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</body>
</html>
