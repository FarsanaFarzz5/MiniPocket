<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parent Dashboard - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
    /* =========================
       💳 TRANSACTION SECTION
    ========================= */
    .transaction-section {
      width: 100%;
      margin-top: 25px;
      background: transparent;
      padding: 0 8px;
        margin-bottom: 0 !important;
       padding-bottom: 0 !important;
    }

    .transaction-section h3 {
      font-size: 15px;
      font-weight: 600;
      color: #333;
      margin-bottom: 10px;
      text-align: left;
    }

    .transaction-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      width: 100%;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 14px 14px 8px;
        margin-bottom: 0 !important;
  padding-bottom: 8px !important;
    }

    .transaction-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }

    .transaction-item:last-child {
      border-bottom: none;
    }

    .transaction-item .left {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .transaction-item .left span:first-child {
      font-size: 14px;
      font-weight: 600;
      color: #333;
    }

    .transaction-item .left span:last-child {
      font-size: 12px;
      color: #777;
    }

    .transaction-item .right {
      text-align: right;
    }

    .transaction-item .right span:first-child {
      font-size: 14px;
      font-weight: 600;
      color: #23a541;
    }

    .transaction-item .right span:last-child {
      font-size: 12px;
      color: #999;
      display: block;
    }

    .no-data {
      text-align: center;
      color: #aaa;
      font-size: 13px;
      margin-top: 10px;
    }

    .all-transactions {
      text-align: center;
      margin-top: 18px;
        margin-bottom: 0 !important;
  padding-bottom: 0 !important;
    }

    .all-transactions button {
      width: 100%;
      background: #f4f4f4;
      border: none;
      color: #333;
      font-size: 14px;
      font-weight: 600;
      padding: 12px 0;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 3px 6px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    .all-transactions button:hover {
      background: #e6e6e6;
      transform: translateY(-1px);
    }

    /* Remove bottom line only after 3rd transaction */
.transaction-list .transaction-item:nth-child(2) {
  border-bottom: none;
}


  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- 🧭 Topbar -->
      <div class="topbar">
        @include('sidebar.sidebar')
        <div class="logo-section">
          <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
        </div>
      </div>

      <!-- 👨‍👩‍👧 Parent Info -->
      <div class="content-section">
        <div class="parent-card">
          <img src="{{ asset('images/parents.png') }}" alt="Parent Icon">
          <div class="parent-info">
            <div class="name">{{ ucfirst($user->first_name) }} {{ ucfirst($user->second_name ?? '') }}</div>
            <div class="detail"><strong>Email:</strong> {{ $user->email }}</div>
            <div class="detail"><strong>Phone:</strong> {{ $user->phone_no ?? 'N/A' }}</div>
            <div class="detail"><strong>DOB:</strong> {{ $user->dob ?? 'N/A' }}</div>
          </div>
        </div>

        <!-- 💰 Add Money -->
        <div class="send-money-box">
          <a href="{{ route('parent.sendmoney.page') }}" class="btn" style="text-decoration: none;">Send Money</a>
        </div>

        <!-- 💳 Transaction Section -->
        <!-- 💳 Transaction Section -->
<div class="transaction-section">
  <h3>Recent Transactions</h3>

  @if($transactions->isEmpty())
    <p class="no-data">No transactions yet.</p>
  @else
    <!-- ⬇️ White box wraps both the list + button -->
    <div class="transaction-list">
      @foreach($transactions->take(2) as $index => $txn)
        <div class="transaction-item">
          <div class="left">
            <span>{{ $index + 1 }}. {{ ucfirst($txn->kid->first_name ?? 'Unknown Kid') }}</span>
            <span>Stationery store in Palakkad, Kerala</span>
          </div>
          <div class="right">
            <span>₹{{ number_format($txn->amount, 2) }}</span>
            <span>{{ $txn->created_at->format('d-m-Y') }}</span>
          </div>
        </div>
      @endforeach

      <!-- ⬇️ Moved inside the same white card -->
      <div class="all-transactions" style="margin-top: 12px;">
        <button onclick="window.location.href='{{ route('parent.transactions') }}'">
          All Transactions
        </button>
      </div>
    </div>
  @endif
</div>
      </div>
    </div>
  </div>

</body>
</html>
