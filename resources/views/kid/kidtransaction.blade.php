<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Transactions - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{asset('assets/css/kidtransaction.css')}}">


</head>

<body>
  <div class="container">
    <div class="inner-container">

      <!-- ✅ Hamburger Menu -->
      <div class="header-bar">
        <div id="kidMenuToggle" class="menu-icon">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>

      <!-- ✅ Sidebar -->
      @include('sidebar.profile')

      <!-- ✅ Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <h1>My Transactions</h1>

      <!-- ✅ Balance Card -->
      <div class="balance-card">
        <h3>Available Balance</h3>
        <p>₹{{ number_format($balance, 2) }}</p>
      </div>

      <!-- ✅ Transactions -->
      <div class="transactions">
        @if($transactions->count() > 0)
          @foreach($transactions as $txn)
            <div class="transaction {{ $txn->type === 'credit' ? 'credit' : 'debit' }}">
              <div class="icon-box">
                @if($txn->type === 'credit') ↑ @else ↓ @endif
              </div>
              <div class="info">
                <h4>{{ $txn->type === 'credit' ? 'Received from Parent' : 'Spent for Needs' }}</h4>
                <span>{{ $txn->created_at->format('d M Y, h:i A') }}</span>
              </div>
              <div class="amount {{ $txn->type === 'credit' ? 'credit' : 'debit' }}">
                {{ $txn->type === 'credit' ? '+' : '-' }}₹{{ number_format($txn->amount, 2) }}
              </div>
            </div>
          @endforeach
        @else
          <div class="no-transactions">No transactions found.</div>
        @endif
      </div>
    </div>

    <!-- ✅ Overlay inside container -->
    <div id="sidebarOverlay"></div>
  </div>

<script src="{{ asset('assets/js/kidtransaction.js') }}"></script>

</body>
</html>
