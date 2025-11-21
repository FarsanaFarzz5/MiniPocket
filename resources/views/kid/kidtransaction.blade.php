<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Transactions - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- ✅ Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kidtransaction.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">

    
      <!-- ✅ Sidebar -->
      @include('sidebar.profile')

      <!-- ✅ Header (instead of logo) -->
      @include('header')

      <!-- ✅ Page Title -->
      <h1>My Transactions</h1>

      

      <!-- ✅ Balance Card -->
      <div class="balance-card">
        <h3>Available Balance</h3>
        <p>₹{{ number_format($balance, 2) }}</p>
      </div>

      <!-- ✅ Transactions List -->
      <div class="transactions">
        @if($transactions->count() > 0)
        @foreach($transactions as $txn)

  {{-- ✅ Skip savings transactions, show only goal payment --}}
  @if($txn->source === 'goal_saving')
      @continue
  @endif

  <div class="transaction {{ $txn->type === 'credit' ? 'credit' : 'debit' }}">
      <div class="icon-box">
        @if($txn->type === 'credit') ↑ @else ↓ @endif
      </div>

      <div class="info">
        <h4>
          @if($txn->type === 'credit')
            Received from Parent
          @else
            @switch($txn->source)

    @case('goal_payment')
        Goal Achieved
    @break

    @case('gift_payment')
        Gift Purchased
    @break

    @case('goal_refund')
        Returned Goal Savings
    @break

    @case('gift_refund')
        Returned Gift Savings
    @break

    @case('kid_to_parent')
        Sent to Parent
    @break

    @case('kid_spending')
        Spent for Needs
    @break

    @default
        Spent
    @break

@endswitch

          @endif
        </h4>
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

    <!-- ✅ Sidebar Overlay -->
    <div id="sidebarOverlay"></div>
  </div>

  <script src="{{ asset('assets/js/kidtransaction.js') }}"></script>
</body>
</html>